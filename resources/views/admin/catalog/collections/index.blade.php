@extends('layouts.admin')

@section('content')
    @include('admin.catalog._manager', [
        'pageTitle' => 'Collections',
        'pageSubtitle' => 'Préparez la couche esthétique du futur catalogue: styles, familles visuelles et bundles prêts.',
        'entityNameSingular' => 'Collection',
        'modalSubtitle' => 'Les collections serviront aux pages de marque interne, aux compositions et aux sélections éditoriales.',
        'items' => $collections,
        'storeRoute' => route('admin.collections.store'),
        'updateBaseUrl' => url('/admin/collections'),
        'destroyBaseUrl' => url('/admin/collections'),
        'showRoom' => true,
        'rooms' => $rooms,
        'extraFields' => [
            ['name' => 'aesthetic_family', 'label' => 'Famille esthétique', 'placeholder' => 'Ex: contemporain chaleureux'],
            ['name' => 'badge_label', 'label' => 'Badge', 'placeholder' => 'Ex: Nouvelle composition'],
        ],
    ])
@endsection
