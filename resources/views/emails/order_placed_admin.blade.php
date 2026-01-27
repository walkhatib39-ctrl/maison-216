<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle commande #{{ $order->id }} — Maison 216</title>
</head>
<body style="font-family: Arial, sans-serif; color:#111">
    <h2>Nouvelle commande #{{ $order->id }}</h2>

    <h3>Client</h3>
    <ul>
        <li>Nom: {{ $order->full_name }}</li>
        <li>Téléphone: {{ $order->phone }} @if($order->phone_alt) · {{ $order->phone_alt }} @endif</li>
        <li>Email: {{ $order->email ?? '—' }}</li>
        <li>Ville: {{ $order->city }}</li>
        <li>Adresse: {{ $order->address }}</li>
    </ul>

    <h3>Commande</h3>
    <ul>
        <li>Total: {{ (int) floor(($order->total_millimes ?? 0)/1000) }} DT</li>
        <li>Paiement: {{ $order->payment_method }}</li>
        <li>Statut: {{ $order->status }}</li>
    </ul>

    <p>Accéder à l’admin: <a href="{{ url('/admin/orders/' . $order->id) }}">{{ url('/admin/orders/' . $order->id) }}</a></p>

    <p style="color:#555;font-size:12px">Email automatique — Ne pas répondre.</p>
</body>
</html>
