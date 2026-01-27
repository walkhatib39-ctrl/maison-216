@extends('layouts.store')

@section('content')
<section class="container mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-4">Conditions Générales de Vente (CGV)</h1>
    <div class="prose max-w-none">
        <p>Ces CGV sont des placeholders et doivent être adaptées/validées par le client.</p>
        <h2>1. Objet</h2>
        <p>La vente de meubles et objets de décoration en Tunisie. Paiement à la livraison (COD).</p>
        <h2>2. Commande</h2>
        <p>Les commandes passées via le site impliquent l’acceptation sans réserve des présentes CGV.</p>
        <h2>3. Livraison</h2>
        <p>Livraison partout en Tunisie, délai indicatif 3–7 jours. Frais fixes: {{ (int) floor((\App\Models\Setting::get('shipping.fee_millimes', 20000))/1000) }} DT.</p>
        <h2>4. Retours</h2>
        <p>Politique de retour à définir par le client (placeholder).</p>
        <h2>5. Service client</h2>
        <p>Contact via WhatsApp/Messenger (configurable dans Paramètres).</p>
    </div>
</section>
@endsection
