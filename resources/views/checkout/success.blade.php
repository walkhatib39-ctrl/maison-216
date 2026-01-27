@extends('layouts.store')

@section('content')
<section class="bg-gradient-to-r from-emerald-50 to-green-100/50 border-b border-emerald-200">
    <div class="container mx-auto px-4 py-10 text-center">
        <div class="mx-auto w-16 h-16 rounded-full bg-emerald-600 flex items-center justify-center shadow-lg">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="mt-6 text-3xl lg:text-4xl font-extrabold text-emerald-900">Votre commande est bien reçue</h1>
        <p class="mt-3 text-emerald-800">Nous vous contacterons pour confirmation. Merci pour votre confiance.</p>
        <div class="mt-2 text-sm text-emerald-700">N° de commande: <span class="font-semibold">#{{ $orderId }}</span></div>
        <div class="mt-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6m-6 6h12"/></svg>
                Retour à l’accueil
            </a>
        </div>
    </div>
</section>
@endsection
