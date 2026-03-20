@extends('layouts.admin')

@section('content')
    @include('admin.catalog._manager', [
        'pageTitle' => 'Types de produit',
        'pageSubtitle' => 'Structurez les entrées SEO et les modules métier: lit, commode, armoire, meuble TV, etc.',
        'entityNameSingular' => 'Type de produit',
        'modalSubtitle' => 'Les types relieront les catégories, les produits et les futurs parcours de composition.',
        'items' => $productTypes,
        'storeRoute' => route('admin.product-types.store'),
        'updateBaseUrl' => url('/admin/product-types'),
        'destroyBaseUrl' => url('/admin/product-types'),
        'showRoom' => true,
        'rooms' => $rooms,
        'extraFields' => [
            ['name' => 'short_label', 'label' => 'Libellé court', 'placeholder' => 'Ex: Dressing'],
        ],
    ])
@endsection
