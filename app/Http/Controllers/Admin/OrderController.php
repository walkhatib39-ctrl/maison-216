<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource with filters.
     */
    public function index(Request $request)
    {
        [$query, $filters] = $this->buildOrderQuery($request);

        $orders = $query->latest()->paginate(20)->withQueryString();

        $statusOptions = $this->statusOptions();

        return view('admin.orders.index', compact('orders', 'filters', 'statusOptions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'statusHistory.user']);
        $statusOptions = $this->statusOptions();

        return view('admin.orders.show', compact('order', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage (status/admin_note).
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', array_values($this->statusOptions()))],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $previous = $order->status;

        $order->status = $data['status'];
        $order->admin_note = $data['admin_note'] ?? null;
        $order->save();

        // Log status change (and note if provided)
        if ($previous !== $order->status || !empty($data['admin_note'])) {
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status'   => $order->status,
                'note'     => $data['admin_note'] ?? null,
                'user_id'  => Auth::id(),
            ]);
        }

        return back()->with('status', 'Commande mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('status', 'Commande supprimée.');
    }

    /**
     * Bulk update status for selected orders.
     */
    public function bulkUpdate(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:orders,id'],
            'status' => ['required', 'string', 'in:' . implode(',', array_values($this->statusOptions()))],
        ]);

        $ids = array_map('intval', $data['ids']);
        $status = (string) $data['status'];
        $userId = Auth::id();
        $now = now();

        // Update in chunks
        $updated = 0;
        collect($ids)->chunk(200)->each(function ($chunk) use ($status, $userId, $now, &$updated) {
            $count = Order::whereIn('id', $chunk)->update(['status' => $status]);
            $updated += $count;

            // Insert status history logs for each updated order id
            $rows = [];
            foreach ($chunk as $id) {
                $rows[] = [
                    'order_id'   => $id,
                    'status'     => $status,
                    'note'       => null,
                    'user_id'    => $userId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            if (!empty($rows)) {
                OrderStatusHistory::insert($rows);
            }
        });

        return back()->with('status', "{$updated} commande(s) mises à jour au statut « {$status} ».");
    }

    /**
     * Export filtered orders to CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        [$query, $filters] = $this->buildOrderQuery($request);

        $filename = 'orders_export_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($handle, [
                'ID', 'Date', 'Nom', 'Téléphone', 'Email', 'Ville', 'Adresse',
                'Statut', 'Paiement', 'Frais livraison (DT)', 'Sous-total (DT)', 'Total (DT)'
            ]);

            $query->orderBy('id')->chunk(500, function ($chunk) use ($handle) {
                foreach ($chunk as $o) {
                    fputcsv($handle, [
                        $o->id,
                        optional($o->created_at)->format('Y-m-d H:i'),
                        $o->full_name,
                        $o->phone,
                        $o->email,
                        $o->city,
                        $o->address,
                        $o->status,
                        $o->payment_method,
                        (int) floor(($o->shipping_fee_millimes ?? 0) / 1000),
                        (int) floor(($o->subtotal_millimes ?? 0) / 1000),
                        (int) floor(($o->total_millimes ?? 0) / 1000),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, $headers);
    }

    /**
     * Printable view for a single order.
     */
    public function print(Order $order)
    {
        $order->load(['items.product']);

        return view('admin.orders.print', compact('order'));
    }

    /**
     * Generate a simple shipping label PDF for the order.
     */
    public function labelPdf(Order $order)
    {
        $order->load(['items']);

        $pdf = Pdf::loadView('admin.orders.pdf.label', [
            'order' => $order,
        ])->setPaper('a6', 'portrait'); // compact label size

        $filename = 'label_commande_' . $order->id . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Generate an invoice PDF for the order.
     */
    public function invoicePdf(Order $order)
    {
        $order->load(['items']);

        $pdf = Pdf::loadView('admin.orders.pdf.invoice', [
            'order' => $order,
        ])->setPaper('a4', 'portrait');

        $filename = 'facture_commande_' . $order->id . '.pdf';
        return $pdf->stream($filename);
    }

    // ----------------- Helpers -----------------

    /**
     * Build query with filters from request.
     *
     * @return array{0:\Illuminate\Database\Eloquent\Builder,1:array}
     */
    protected function buildOrderQuery(Request $request): array
    {
        $filters = [
            'q' => trim((string) $request->get('q', '')),
            'status' => (string) $request->get('status', ''),
            'date_from' => (string) $request->get('date_from', ''),
            'date_to' => (string) $request->get('date_to', ''),
            'city' => trim((string) $request->get('city', '')),
        ];

        $query = Order::query();

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $query->where(function ($qq) use ($q) {
                $qq->where('full_name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('address', 'like', "%{$q}%");
            });
        }

        if ($filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if ($filters['city'] !== '') {
            $query->where('city', 'like', '%' . $filters['city'] . '%');
        }

        if ($filters['date_from'] !== '') {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if ($filters['date_to'] !== '') {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return [$query, $filters];
    }

    /**
     * Map of statuses for UI and validation.
     *
     * @return array<int,string>
     */
    protected function statusOptions(): array
    {
        return [
            \App\Models\Order::STATUS_NEW,
            \App\Models\Order::STATUS_CONFIRMED,
            \App\Models\Order::STATUS_PREPARING,
            \App\Models\Order::STATUS_DELIVERING,
            \App\Models\Order::STATUS_DELIVERED,
            \App\Models\Order::STATUS_CANCELED,
        ];
    }
}
