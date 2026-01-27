@extends('layouts.store')

@section('content')
<section class="container mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-4">Livraison & Retours</h1>
    <div class="prose max-w-none">
        <p>Page placeholder. À adapter selon la politique du client.</p>

        <h2>Livraison</h2>
        <ul>
            <li>Zone: 24 gouvernorats de Tunisie</li>
            <li>Délai indicatif: 3–7 jours ouvrés</li>
            <li>Frais: {{ (int) floor((\App\Models\Setting::get('shipping.fee_millimes', 20000))/1000) }} DT TTC</li>
            <li>Paiement: À la livraison (COD)</li>
        </ul>

        <h2>Retours</h2>
        <p>Conditions de retour/échange à définir par le client (placeholder).</p>

        <h2>Support</h2>
        <p>Contact via WhatsApp/Messenger depuis la barre supérieure du site.</p>
    </div>
</section>
@endsection
