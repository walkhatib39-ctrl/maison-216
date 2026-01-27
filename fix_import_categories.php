<?php

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

// 1. Ensure Categories Exist
$catDining = Category::firstOrCreate(
    ['slug' => 'salles-a-manger-completes'],
    ['name' => 'Salles à manger complètes', 'parent_id' => null, 'active' => 1]
);

$catLiving = Category::firstOrCreate(
    ['slug' => 'salons-complets'],
    ['name' => 'Salons complets', 'parent_id' => null, 'active' => 1]
);

$catKids = Category::firstOrCreate(
    ['slug' => 'chambres-enfant-completes'],
    ['name' => 'Chambres enfant complètes', 'parent_id' => null, 'active' => 1]
);

echo "Categories ensured: {$catDining->id}, {$catLiving->id}, {$catKids->id}\n";

// 2. Reclassify Products
$products = Product::whereHas('category', function($q) {
    $q->whereIn('slug', ['grouped', 'chambres-junior-completes', 'salons-complets', 'salles-a-manger-completes']); // Include target cats to re-verify mixed items
})->orWhereDoesntHave('category')->get();

$counts = [
    'dining' => 0,
    'living' => 0,
    'kids' => 0,
    'skipped' => 0
];

foreach ($products as $product) {
    $title = Str::lower($product->title);
    
    if (Str::contains($title, ['salle à manger', 'salle a manger', 'table à manger'])) {
        $product->category_id = $catDining->id;
        $counts['dining']++;
    } elseif (Str::contains($title, ['salon', 'meuble tv', 'canapé', 'fauteuil'])) {
        $product->category_id = $catLiving->id;
        $counts['living']++;
    } elseif (Str::contains($title, ['chambre', 'enfant', 'bébé', 'bebe', 'ado ', 'lit ', 'junior'])) {
        $product->category_id = $catKids->id;
        $counts['kids']++;
    } else {
        $counts['skipped']++;
        // echo "Skipped: {$product->title}\n";
    }
    $product->save();
}

echo "Reclassification Complete:\n";
echo "  Salles à manger: {$counts['dining']}\n";
echo "  Salons: {$counts['living']}\n";
echo "  Chambres enfant: {$counts['kids']}\n";
echo "  Skipped: {$counts['skipped']}\n";
