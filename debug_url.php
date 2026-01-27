<?php
// Debug script to check URL parsing
$j = json_decode(file_get_contents('C:/Users/WALID DEV/apps walid/meuble/exports/processed/products_batch_001.json'), true);

// Show first 3 products with their URLs
for ($i = 0; $i < 3; $i++) {
    $url = $j[$i]['url'];
    $path = parse_url($url, PHP_URL_PATH);
    $segments = array_values(array_filter(explode('/', $path)));
    
    echo "Product: " . $j[$i]['title'] . "\n";
    echo "URL: " . $url . "\n";
    echo "Path: " . $path . "\n";
    echo "Segments: " . implode(' | ', $segments) . "\n";
    echo "---\n";
}
