<?php
$cat = \App\Models\Category::where('slug', 'meubles-tv')->first();
if($cat) {
    echo "Slug: " . $cat->slug . "\n";
    echo "Parent ID: " . ($cat->parent_id ?? 'NULL') . "\n";
    if($cat->parent) {
         echo "Parent Name: " . $cat->parent->name . "\n";
    }
} else {
    echo "Category not found.\n";
}
