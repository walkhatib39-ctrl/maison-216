<!-- Admin PDF: Invoice (A4) -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture — #{{ $order->id }}</title>
    <style>
        @page { margin: 15mm; }
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #0f172a; }
        .row { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; }
        .brand { font-size: 22px; font-weight: 900; }
        .muted { color:#475569; }
        .box { border:1px solid #e5e7eb; border-radius:8px; padding:10px; }
        .section { margin-top: 14px; }
        .title { font-weight: 800; font-size: 14px; margin: 0 0 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 10px; border-bottom: 1px solid #e5e7eb; }
        th { text-align: left; background: #f8fafc; font-size: 12px; }
        .right { text-align: right; }
        .totals td { border: 0; }
        .grand { font-size: 16px; font-weight: 900; }
        .mono { font-family: ui-monospace, Menlo, Consolas, monospace; }
        .footer-note { font-size: 10px; color:#64748b; margin-top: 18px; }
    </style>
</head>
<body>
@php
    $shipping = (int) floor(($order->shipping_fee_millimes ?? 0) / 1000);
    $subtotal = (int) floor(($order->subtotal_millimes ?? 0) / 1000);
    $total = (int) floor(($order->total_millimes ?? 0) / 1000);
@endphp

<!-- Header -->
<div class="row">
    <div>
        <div class="brand">{{ \App\Models\Setting::get('site.name', 'Maison 216') }}</div>
        <div class="muted">{{ \App\Models\Setting::get('site.tagline', 'Meubles & Décoration en Tunisie') }}</div>
        <div class="muted" style="margin-top:6px;">{{ url('/') }}</div>
    </div>
    <div class="box" style="min-width: 220px;">
        <div class="title">Facture</div>
        <div><strong>N°:</strong> MA216-{{ str_pad((string)$order->id, 6, '0', STR_PAD_LEFT) }}</div>
        <div><strong>Date:</strong> {{ $order->created_at?->format('d/m/Y H:i') }}</div>
        <div><strong>Mode:</strong> Paiement à la livraison (COD)</div>
    </div>
</div>

<!-- Parties -->
<div class="row section">
    <div class="box" style="flex:1;">
        <div class="title">Vendu par</div>
        <div><strong>{{ \App\Models\Setting::get('site.name', 'Maison 216') }}</strong></div>
        @php $wa = \App\Models\Setting::get('contact.whatsapp'); @endphp
        @if($wa)
            <div>WhatsApp: {{ $wa }}</div>
        @endif
        <div>Site: {{ url('/') }}</div>
    </div>
    <div class="box" style="flex:1;">
        <div class="title">Client</div>
        <div><strong>{{ $order->full_name }}</strong></div>
        <div>{{ $order->address }}</div>
        <div>{{ $order->postal_code ? ($order->postal_code . ' ') : '' }}{{ $order->city }}{{ $order->governorate ? (', ' . $order->governorate) : '' }}</div>
        <div>Tél: {{ $order->phone }}{{ $order->phone_alt ? (' / ' . $order->phone_alt) : '' }}</div>
        @if($order->email)<div>Email: {{ $order->email }}</div>@endif
    </div>
</div>

<!-- Items -->
<div class="section">
    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th class="right">PU (DT)</th>
            <th class="right">Qté</th>
            <th class="right">Total (DT)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
            @php
                $unit = (int) floor(($item->unit_price_millimes ?? 0) / 1000);
                $line = (int) floor(($item->line_total_millimes ?? 0) / 1000);
            @endphp
            <tr>
                <td>
                    <div><strong>{{ $item->product_title }}</strong></div>
                    @if($item->product_sku)<div class="muted mono">SKU: {{ $item->product_sku }}</div>@endif
                </td>
                <td class="right">{{ $unit }}</td>
                <td class="right">{{ $item->quantity }}</td>
                <td class="right">{{ $line }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Totals -->
<div class="row section">
    <div></div>
    <div style="min-width: 260px;">
        <table class="totals" style="width:100%;">
            <tr>
                <td class="right muted">Sous-total</td>
                <td class="right">{{ $subtotal }} DT</td>
            </tr>
            <tr>
                <td class="right muted">Frais de livraison</td>
                <td class="right">{{ $shipping }} DT</td>
            </tr>
            <tr>
                <td class="right grand">Total</td>
                <td class="right grand">{{ $total }} DT</td>
            </tr>
        </table>
    </div>
</div>

<!-- Notes -->
@if($order->customer_note)
<div class="section">
    <div class="title">Note du client</div>
    <div class="box">{{ $order->customer_note }}</div>
</div>
@endif

<div class="footer-note">
    Document généré le {{ now()->format('d/m/Y H:i') }} — Commande #{{ $order->id }}.
    Ce document sert de justificatif de commande pour paiement à la livraison. TVA incluse si applicable.
</div>
</body>
</html>
