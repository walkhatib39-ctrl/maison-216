@extends('layouts.store')

@push('head')
{{-- Schema.org Structured Data --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => \App\Models\Setting::get('site.name', config('app.name')),
    'url' => url('/'),
    'logo' => \App\Models\Setting::get('ui.logo'),
    'description' => 'Vente de meubles en Tunisie. Livraison partout en Tunisie, paiement à la livraison.',
    'address' => [
        '@type' => 'PostalAddress',
        'addressCountry' => 'TN',
    ],
    'sameAs' => array_values(array_filter([
        (function () {
            $wh = \App\Models\Setting::get('contact.whatsapp');
            $digits = $wh ? preg_replace('/\D+/', '', (string) $wh) : null;
            return $digits ? ('https://wa.me/' . $digits) : null;
        })(),
        \App\Models\Setting::get('contact.messenger') ?: null,
    ])),
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>

{{-- WebSite Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => \App\Models\Setting::get('site.name', config('app.name')),
    'url' => url('/'),
    'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => url('/search') . '?q={search_term_string}',
        'query-input' => 'required name=search_term_string',
    ],
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
    {{-- Hero Section with Slider --}}
    @include('partials.home._hero', ['categories' => $rootCategories])
    
    {{-- Categories Grid --}}
    @include('partials.home._categories-grid', ['categories' => $gridCategories])
    
    {{-- Nouveautés / New Arrivals --}}
    @include('partials.home._nouveautes', ['products' => $latest])
    
    {{-- Best Sellers --}}
    @include('partials.home._bestsellers', ['products' => $bestsellers])
    
    {{-- Category Spotlight: Salon & Séjour --}}
    @include('partials.home._spotlight-salon', ['products' => $salonProducts])
    
    {{-- Parallax Promotional Banner --}}
    @include('partials.home._parallax-banner')
    
    {{-- Category Spotlight: Chambre --}}
    @include('partials.home._spotlight-chambre', ['products' => $chambreProducts])
    
    {{-- Category Spotlight: Salle à Manger --}}
    @include('partials.home._spotlight-salle-manger', ['products' => $salleMangerProducts])
    
    {{-- Newsletter Subscription --}}
    @include('partials.home._newsletter')
@endsection
