<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkshopOrder;
use Illuminate\View\View;

class WorkshopTodayController extends Controller
{
    public function __invoke(): View
    {
        $base = WorkshopOrder::query()->with('client');

        return view('admin.workshop.today', [
            'todayDeliveries' => (clone $base)
                ->whereDate('delivery_due_at', today())
                ->open()
                ->orderBy('delivery_due_at')
                ->get(),
            'lateOrders' => (clone $base)
                ->whereDate('delivery_due_at', '<', today())
                ->open()
                ->orderBy('delivery_due_at')
                ->get(),
            'noDepositOrders' => (clone $base)
                ->where('deposit_amount', '<=', 0)
                ->open()
                ->latest()
                ->limit(50)
                ->get(),
            'readyOrders' => (clone $base)
                ->where('status', WorkshopOrder::STATUS_READY)
                ->orderBy('delivery_due_at')
                ->get(),
            'deliveredWithBalance' => (clone $base)
                ->whereIn('status', [WorkshopOrder::STATUS_DELIVERED, WorkshopOrder::STATUS_INSTALLED])
                ->whereColumn('deposit_amount', '<', 'total_amount')
                ->orderBy('delivery_due_at')
                ->get(),
        ]);
    }
}
