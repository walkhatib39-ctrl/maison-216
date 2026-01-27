<?php

// Mapping Ville -> Gouvernorat (simplifié). À étendre si nécessaire.
// Les clés sont en minuscules pour une comparaison case-insensitive.
return [
    'tunis' => 'Tunis',
    'ariana' => 'Ariana',
    'ben arous' => 'Ben Arous',
    'manouba' => 'Manouba',
    'bizerte' => 'Bizerte',
    'nabeul' => 'Nabeul',
    'zaghouan' => 'Zaghouan',
    'béja' => 'Béja',
    'beja' => 'Béja',
    'jendouba' => 'Jendouba',
    'kef' => 'Le Kef',
    'siliana' => 'Siliana',
    'sousse' => 'Sousse',
    'monastir' => 'Monastir',
    'mahdia' => 'Mahdia',
    'sfax' => 'Sfax',
    'kairouan' => 'Kairouan',
    'kasserine' => 'Kasserine',
    'sidi bouzid' => 'Sidi Bouzid',
    'gabès' => 'Gabès',
    'gabes' => 'Gabès',
    'médenine' => 'Médenine',
    'medenine' => 'Médenine',
    'tataouine' => 'Tataouine',
    'tozeur' => 'Tozeur',
    'gafsa' => 'Gafsa',
    'kébili' => 'Kébili',
    'kebili' => 'Kébili',
];

// Helper suggestion (usage dans les contrôleurs):
// function governorate_from_city(string $city): ?string {
//     $map = config('governorates');
//     $key = mb_strtolower(trim($city), 'UTF-8');
//     return $map[$key] ?? null;
// }
