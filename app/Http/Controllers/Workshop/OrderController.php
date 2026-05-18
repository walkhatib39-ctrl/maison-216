<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\WorkshopClient;
use App\Models\WorkshopOrder;
use App\Models\WorkshopOrderFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        [$query, $filters] = $this->buildQuery($request);

        $orders = $query
            ->with(['client', 'coverFile'])
            ->withCount('files')
            ->latest('delivery_due_at')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('workshop.orders.index', [
            'orders' => $orders,
            'filters' => $filters,
            'clients' => $this->clientOptions(),
            'statuses' => WorkshopOrder::statuses(),
            'categories' => WorkshopOrder::categories(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('workshop.orders.form', [
            'order' => new WorkshopOrder([
                'workshop_client_id' => $request->integer('client_id') ?: null,
                'ordered_at' => now()->toDateString(),
                'status' => WorkshopOrder::STATUS_NEW,
                'category' => WorkshopOrder::CATEGORY_WOOD,
            ]),
            'clients' => $this->clientOptions(),
            'statuses' => WorkshopOrder::statuses(),
            'categories' => WorkshopOrder::categories(),
            'fileTypes' => WorkshopOrderFile::fileTypes(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $order = WorkshopOrder::create($this->validatedData($request));
        $this->storeFiles($request, $order);

        return redirect()
            ->route('workshop.orders.show', $order)
            ->with('status', 'Commande ajoutée.');
    }

    public function show(WorkshopOrder $order): View
    {
        $order->load(['client', 'files']);

        return view('workshop.orders.show', compact('order'));
    }

    public function edit(WorkshopOrder $order): View
    {
        $order->load(['files']);

        return view('workshop.orders.form', [
            'order' => $order,
            'clients' => $this->clientOptions(),
            'statuses' => WorkshopOrder::statuses(),
            'categories' => WorkshopOrder::categories(),
            'fileTypes' => WorkshopOrderFile::fileTypes(),
        ]);
    }

    public function update(Request $request, WorkshopOrder $order): RedirectResponse
    {
        $order->update($this->validatedData($request));
        $this->storeFiles($request, $order);

        return redirect()
            ->route('workshop.orders.show', $order)
            ->with('status', 'Commande mise à jour.');
    }

    public function destroy(WorkshopOrder $order): RedirectResponse
    {
        $order->load('files');

        foreach ($order->files as $file) {
            $this->deletePublicFile($file->file_path);
        }

        $order->delete();

        return redirect()
            ->route('workshop.orders.index')
            ->with('status', 'Commande supprimée.');
    }

    public function destroyFile(WorkshopOrder $order, WorkshopOrderFile $file): RedirectResponse
    {
        abort_unless($file->workshop_order_id === $order->id, 404);

        $this->deletePublicFile($file->file_path);
        $file->delete();

        return back()->with('status', 'Fichier supprimé.');
    }

    public function export(Request $request): StreamedResponse
    {
        [$query] = $this->buildQuery($request);
        $filename = 'carnet-commandes-atelier-' . now()->format('Y-m-d-H-i') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'ID',
                'Client',
                'Telephone',
                'WhatsApp',
                'Ville',
                'Commande',
                'Categorie',
                'Montant total',
                'Acompte reçu',
                'Reste à payer',
                'Statut',
                'Date commande',
                'Livraison prévue',
                'Description',
                'Dimensions',
                'Couleur / finition',
                'Notes internes',
            ]);

            $query->with('client')->orderBy('id')->chunk(300, function ($orders) use ($handle) {
                foreach ($orders as $order) {
                    fputcsv($handle, [
                        $order->id,
                        $order->client?->name,
                        $order->client?->phone,
                        $order->client?->whatsapp,
                        $order->client?->city,
                        $order->title,
                        $order->categoryLabel(),
                        (float) $order->total_amount,
                        (float) $order->deposit_amount,
                        $order->remaining_amount,
                        $order->status,
                        optional($order->ordered_at)->format('Y-m-d'),
                        optional($order->delivery_due_at)->format('Y-m-d'),
                        $order->description,
                        $order->dimensions,
                        $order->finish,
                        $order->internal_notes,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    protected function buildQuery(Request $request): array
    {
        $filters = [
            'q' => trim((string) $request->get('q', '')),
            'status' => (string) $request->get('status', ''),
            'client_id' => (string) $request->get('client_id', ''),
            'category' => (string) $request->get('category', ''),
            'delivery_due_at' => (string) $request->get('delivery_due_at', ''),
            'balance_due' => $request->boolean('balance_due'),
            'overdue' => $request->boolean('overdue'),
        ];

        $query = WorkshopOrder::query();

        $query
            ->when($filters['q'] !== '', function (Builder $query) use ($filters) {
                $q = $filters['q'];
                $query->where(function (Builder $sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('dimensions', 'like', "%{$q}%")
                        ->orWhereHas('client', function (Builder $clientQuery) use ($q) {
                            $clientQuery->where('name', 'like', "%{$q}%")
                                ->orWhere('phone', 'like', "%{$q}%")
                                ->orWhere('whatsapp', 'like', "%{$q}%");
                        });
                });
            })
            ->when($filters['status'] !== '', fn (Builder $query) => $query->where('status', $filters['status']))
            ->when($filters['client_id'] !== '', fn (Builder $query) => $query->where('workshop_client_id', $filters['client_id']))
            ->when($filters['category'] !== '', fn (Builder $query) => $query->where('category', $filters['category']))
            ->when($filters['delivery_due_at'] !== '', fn (Builder $query) => $query->whereDate('delivery_due_at', $filters['delivery_due_at']))
            ->when($filters['balance_due'], fn (Builder $query) => $query->whereColumn('deposit_amount', '<', 'total_amount'))
            ->when($filters['overdue'], fn (Builder $query) => $query
                ->whereDate('delivery_due_at', '<', today())
                ->whereNotIn('status', [WorkshopOrder::STATUS_CLOSED, WorkshopOrder::STATUS_CANCELED]));

        return [$query, $filters];
    }

    protected function validatedData(Request $request): array
    {
        $request->merge([
            'total_amount' => $this->normalizeAmount($request->input('total_amount')),
            'deposit_amount' => $this->normalizeAmount($request->input('deposit_amount')),
        ]);

        $validated = $request->validate([
            'workshop_client_id' => ['required', 'integer', 'exists:workshop_clients,id'],
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'in:' . implode(',', array_keys(WorkshopOrder::categories()))],
            'description' => ['nullable', 'string', 'max:8000'],
            'dimensions' => ['nullable', 'string', 'max:3000'],
            'finish' => ['nullable', 'string', 'max:500'],
            'total_amount' => ['nullable', 'numeric', 'min:0'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0', 'lte:total_amount'],
            'ordered_at' => ['nullable', 'date'],
            'delivery_due_at' => ['nullable', 'date'],
            'status' => ['required', 'string', 'in:' . implode(',', WorkshopOrder::statuses())],
            'internal_notes' => ['nullable', 'string', 'max:8000'],
            'attachment_type' => ['nullable', 'string', 'in:' . implode(',', array_keys(WorkshopOrderFile::fileTypes()))],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:20480'],
        ]);

        unset($validated['attachment_type'], $validated['attachments']);

        return $validated;
    }

    protected function storeFiles(Request $request, WorkshopOrder $order): void
    {
        if (! $request->hasFile('attachments')) {
            return;
        }

        $type = $request->input('attachment_type') ?: WorkshopOrderFile::TYPE_CLIENT_PHOTO;

        foreach ($request->file('attachments', []) as $uploadedFile) {
            if (! $uploadedFile->isValid()) {
                continue;
            }

            $originalName = $uploadedFile->getClientOriginalName();
            $mimeType = $uploadedFile->getMimeType();
            $size = $uploadedFile->getSize() ?: 0;

            $directory = public_path("uploads/workshop-orders/{$order->id}");
            File::ensureDirectoryExists($directory);

            $filename = Str::uuid() . '.' . strtolower($uploadedFile->getClientOriginalExtension() ?: 'file');
            $uploadedFile->move($directory, $filename);
            $path = "uploads/workshop-orders/{$order->id}/{$filename}";

            $order->files()->create([
                'file_type' => $type,
                'file_path' => $path,
                'original_name' => $originalName,
                'mime_type' => $mimeType,
                'size' => $size,
            ]);
        }
    }

    protected function clientOptions()
    {
        return WorkshopClient::query()
            ->orderBy('name')
            ->get(['id', 'name', 'phone', 'whatsapp']);
    }

    protected function normalizeAmount(mixed $value): float
    {
        $value = str_replace([' ', ','], ['', '.'], (string) $value);

        return is_numeric($value) ? (float) $value : 0.0;
    }

    protected function deletePublicFile(?string $path): void
    {
        if (! $path) {
            return;
        }

        $fullPath = public_path(ltrim($path, '/'));

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
