@extends('layouts.admin')

@section('content')
    @include('admin.catalog._manager', [
        'pageTitle' => 'Univers',
        'pageSubtitle' => 'Pilotez les grands univers du site: chambre, salon, cuisine, bureau, sur mesure.',
        'entityNameSingular' => 'Univers',
        'modalSubtitle' => 'Cette couche servira de colonne vertébrale pour la navigation, les pages piliers et le builder.',
        'items' => $rooms,
        'storeRoute' => route('admin.rooms.store'),
        'updateBaseUrl' => url('/admin/rooms'),
        'destroyBaseUrl' => url('/admin/rooms'),
        'showRoom' => false,
        'extraFields' => [
            ['name' => 'tagline', 'label' => 'Tagline', 'placeholder' => 'Ex: Composez une chambre adulte complète'],
        ],
    ])
@endsection
