<?php

use App\Models\Category;

$categories = Category::withCount('products')->get();

echo "start_dump\n";
foreach ($categories as $c) {
    echo "ID: {$c->id} | Slug: {$c->slug} | Name: {$c->name} | Count: {$c->products_count}\n";
}
echo "end_dump\n";
