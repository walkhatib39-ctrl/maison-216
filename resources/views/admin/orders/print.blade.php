<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bon de préparation — #{{ $order->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
        body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; color: #111827; }
        .container { max-width: 900px; margin: 0 auto; padding: 24px; }
        .muted { color: #6B7280; }
        .section { margin-top: 16px; border: 1px solid #E5E7EB; border-radius: 8px; }
        .section h3 { margin: 0; padding: 12px 16px; font-size: 16px; background: #F9FAFB; border-bottom: 1px solid #E5E7EB; }
        .section .content { padding: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #E5E7EB; padding: 10px; text-align: left; font-size: 14px; }
        th { background: #F9FAFB; font-weight: 600; color: #374151; }
        .right { text-align: right; }
        .badge { display: inline-block; padding: 2px 8px; font-size: 12px; border-radius: 9999px; background: #F3F4F6; color: #374151; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .title { font-size: 20px; font-weight: 700; }
        .actions a { display: inline-block; padding: 8px 12px; border-radius: 8px; text-decoration: none; color: white; background: #111827; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        .label { font-size: 12px; color: #6B7280; }
        .value { font-size: 14px; color: #111827; font-weight: 600; }
        .totals { width: 300px; margin-left: auto; }
        .totals td { border: none; padding: 6px 0; }
        .totals .sum td { font-weight: 700; border-top: 1px solid #E5E7EB; padding-top: 10px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <div class="title">Bon de préparation — #{{ $order->id }}</div>
            <div class="muted">Passée le {{ optional($order->created_at)->format('Y-m-d H:i') }}</div>
        </div>
        <div class="actions no-print">
            <a href="javascript:window.print()">Imprimer</a>
        </div>
    </div>

    <div class="section">
        <h3>Informations client</h3>
        <div class="content grid">
            <div>
                <div class="label">Nom complet</div>
                <div class="value">{{ $order->full_name }}</div>
            </div>
            <div>
                <div class="label">Téléphone</div>
                <div class="value">{{ $order->phone }} @if($order->phone_alt) · {{ $order->phone_alt }} @endif</div>
            </div>
            <div>
                <div class="label">Email</div>
                <div class="value">{{ $order->email ?? '—' }}</div>
            </div>
            <div>
                <div class="label">Ville</div>
                <div class="value">{{ $order->city }}</div>
            </div>
            <div style="grid-column: span 2;">
                <div class="label">Adresse</div>
                <div class="value">{{ $order->address }}</div>
            </div>
            <div>
                <div class="label">Code postal</div>
                <div class="value">{{ $order->postal_code ?? '—' }}</div>
            </div>
            <div>
                <div class="label">Paiement</div>
                <div class="value">{{ $order->payment_method }}</div>
            </div>
            <div>
                <div class="label">Statut</div>
                <div class="value"><span class="badge">{{ $order->status }}</span></div>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Articles</h3>
        <div class="content">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Produit</th>
                    <th>SKU</th>
                    <th>Prix unitaire</th>
                    <th>Qté</th>
                    <th class="right">Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->items as $it)
                    <tr>
                        <td>{{ $it->id }}</td>
                        <td>{{ $it->product_title }}</td>
                        <td>{{ $it->product_sku ?? '—' }}</td>
                        <td>{{ (int) floor(($it->unit_price_millimes ?? 0)/1000) }} DT</td>
                        <td>{{ $it->quantity }}</td>
                        <td class="right">{{ (int) floor(($it->line_total_millimes ?? 0)/1000) }} DT</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <table class="totals">
                <tr>
                    <td class="label">Sous-total</td>
                    <td class="right value">{{ (int) floor(($order->subtotal_millimes ?? 0)/1000) }} DT</td>
                </tr>
                <tr>
                    <td class="label">Frais de livraison</td>
                    <td class="right value">{{ (int) floor(($order->shipping_fee_millimes ?? 0)/1000) }} DT</td>
                </tr>
                <tr class="sum">
                    <td class="value">Total</td>
                    <td class="right value">{{ (int) floor(($order->total_millimes ?? 0)/1000) }} DT</td>
                </tr>
            </table>
        </div>
    </div>

    @if($order->customer_note)
        <div class="section">
            <h3>Note client</h3>
            <div class="content" style="white-space: pre-line;">
                {{ $order->customer_note }}
            </div>
        </div>
    @endif

    @if($order->admin_note)
        <div class="section">
            <h3>Note admin</h3>
            <div class="content" style="white-space: pre-line;">
                {{ $order->admin_note }}
            </div>
        </div>
    @endif
</div>
</body>
</html>
