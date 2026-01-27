<!-- Admin PDF: Shipping Label (A6) -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Étiquette expédition — #{{ $order->id }}</title>
    <style>
        @page { margin: 10mm; }
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #0f172a; }
        .wrap { border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px; }
        .row { display: flex; align-items: center; justify-content: space-between; }
        .brand { font-weight: 900; font-size: 16px; }
        .muted { color: #475569; }
        .badge { display:inline-block; padding: 4px 8px; border-radius: 999px; background: #f1f5f9; font-weight: 700; font-size: 10px; }
        .section { margin-top: 8px; padding-top: 8px; border-top: 1px dashed #e2e8f0; }
        .title { font-weight: 800; font-size: 12px; margin-bottom: 4px; }
        .line { margin: 2px 0; }
        .big { font-size: 20px; font-weight: 900; letter-spacing: 1px; }
        .right { text-align: right; }
        .codebox { border: 1px dashed #94a3b8; padding: 6px 8px; font-family: ui-monospace, monospace; font-weight: 700; display: inline-block; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="row">
        <div class="brand">{{ \App\Models\Setting::get('site.name', 'Maison 216') }}</div>
        <div class="badge">COD</div>
    </div>
    <div class="row muted">
        <div>Étiquette d’expédition</div>
        <div>#{{ $order->id }}</div>
    </div>

    <div class="section">
        <div class="title">Destinataire</div>
        <div class="line"><strong>{{ $order->full_name }}</strong></div>
        <div class="line">{{ $order->address }}</div>
        <div class="line">{{ $order->postal_code ? ($order->postal_code . ' ') : '' }}{{ $order->city }}{{ $order->governorate ? (', ' . $order->governorate) : '' }}</div>
        <div class="line">Tél: <strong>{{ $order->phone }}</strong>{{ $order->phone_alt ? (' / ' . $order->phone_alt) : '' }}</div>
    </div>

    <div class="section">
        <div class="title">Commande</div>
        @php
            $item = $order->items->first();
            $totalDT = (int) floor(($order->total_millimes ?? 0) / 1000);
        @endphp
        @if($item)
            <div class="line"><strong>{{ $item->product_title }}</strong></div>
            <div class="line">Qté: {{ $item->quantity }}</div>
        @else
            <div class="line">Aucun article</div>
        @endif
    </div>

    <div class="section row">
        <div>
            <div class="muted">Montant à encaisser</div>
            <div class="big">{{ $totalDT }} DT</div>
        </div>
        <div class="right">
            <div class="muted">Commande</div>
            <div class="codebox">MA216-{{ str_pad((string)$order->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>

    <div class="section muted" style="font-size:10px;">
        <div>Support: WhatsApp {{ \App\Models\Setting::get('contact.whatsapp') }} — {{ url('/') }}</div>
        <div>Imprimé le {{ now()->format('d/m/Y H:i') }}</div>
    </div>
</div>
</body>
</html>
