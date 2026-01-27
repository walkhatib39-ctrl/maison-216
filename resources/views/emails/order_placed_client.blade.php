<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation commande #{{ $order->id }} — Maison 216</title>
</head>
<body style="font-family: Arial, sans-serif; color:#111">
    <h2>Merci pour votre commande #{{ $order->id }}</h2>
    <p>Bonjour {{ $order->full_name }},</p>
    <p>Nous avons bien reçu votre commande. Un membre de notre équipe vous contactera pour la confirmer.</p>

    <h3>Détails</h3>
    <ul>
        <li>Nom: {{ $order->full_name }}</li>
        <li>Téléphone: {{ $order->phone }}</li>
        <li>Ville: {{ $order->city }}</li>
        <li>Adresse: {{ $order->address }}</li>
        <li>Total: {{ (int) floor(($order->total_millimes ?? 0)/1000) }} DT</li>
        <li>Paiement: {{ $order->payment_method }}</li>
        <li>Statut: {{ $order->status }}</li>
    </ul>

    <p style="color:#555;font-size:12px">Email automatique — Merci de ne pas répondre directement.</p>
</body>
</html>
