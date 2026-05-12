<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitePageController;
use Illuminate\Support\Facades\Route;

// Front routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/c/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/p/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/{product}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{product}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('search.suggest');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/menuiserie-bois/{path?}', [SitePageController::class, 'show'])
    ->where('path', '.*')
    ->defaults('section', 'menuiserie-bois')
    ->name('site.menuiserie-bois');
Route::get('/sur-mesure/{path?}', [SitePageController::class, 'show'])
    ->where('path', '.*')
    ->defaults('section', 'sur-mesure')
    ->name('site.sur-mesure');
Route::get('/projets/{path?}', [SitePageController::class, 'show'])
    ->where('path', '.*')
    ->defaults('section', 'projets')
    ->name('site.projets');
Route::get('/cuisine-dressing/{path?}', function (?string $path = null) {
    return redirect('/sur-mesure' . ($path ? '/' . trim($path, '/') : ''), 301);
})->where('path', '.*');
Route::redirect('/aluminium/fenetre-alu', '/aluminium/fenetre-aluminium', 301);
Route::redirect('/aluminium/porte-alu', '/aluminium/porte-aluminium', 301);
Route::redirect('/aluminium/cloison-alu', '/aluminium', 301);
Route::redirect('/aluminium/cloison-aluminium', '/aluminium', 301);
Route::redirect('/aluminium/vitrine-magasin', '/aluminium', 301);
Route::redirect('/aluminium/verriere', '/aluminium', 301);
Route::redirect('/aluminium/cabine-de-douche', '/aluminium', 301);
Route::get('/aluminium/{path?}', [SitePageController::class, 'show'])
    ->where('path', '.*')
    ->defaults('section', 'aluminium')
    ->name('site.aluminium');
Route::redirect('/fer-metal/grille-de-protection', '/fer-metal', 301);
Route::get('/fer-metal/{path?}', [SitePageController::class, 'show'])
    ->where('path', '.*')
    ->defaults('section', 'fer-metal')
    ->name('site.fer-metal');
Route::get('/meubles/{path?}', function () {
    return redirect('/menuiserie-bois', 301);
})->where('path', '.*');
Route::get('/guides/{path?}', function () {
    return redirect('/projets', 301);
})->where('path', '.*');
Route::get('/partenaires', [SitePageController::class, 'show'])
    ->defaults('section', 'partenaires')
    ->name('site.partenaires');
Route::get('/devis', [SitePageController::class, 'show'])
    ->defaults('section', 'devis')
    ->name('devis');

// Quick order (guest checkout only)
Route::post('/order/quick', [ProductController::class, 'quickOrder'])->name('order.quick');

// Default Breeze dashboard (protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile (protected)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

 // Admin area (minimal) — requires is_admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        // Basic dashboard
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Products - Import via UI
        Route::get('products/import', [\App\Http\Controllers\Admin\ProductController::class, 'importForm'])->name('products.import');
        Route::post('products/import', [\App\Http\Controllers\Admin\ProductController::class, 'import'])->name('products.import.store');


        // Products CRUD
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        
        // Categories Management
        // Categories Management
        Route::delete('categories/bulk-destroy', [\App\Http\Controllers\Admin\CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('rooms', \App\Http\Controllers\Admin\RoomController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('product-types', \App\Http\Controllers\Admin\ProductTypeController::class)
            ->parameters(['product-types' => 'productType'])
            ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('collections', \App\Http\Controllers\Admin\CollectionController::class)->only(['index', 'store', 'update', 'destroy']);

        // Orders - extra actions
        Route::get('orders/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');
        Route::get('orders/{order}/print', [\App\Http\Controllers\Admin\OrderController::class, 'print'])->name('orders.print');
        Route::get('orders/{order}/label.pdf', [\App\Http\Controllers\Admin\OrderController::class, 'labelPdf'])->name('orders.label.pdf');
        Route::get('orders/{order}/invoice.pdf', [\App\Http\Controllers\Admin\OrderController::class, 'invoicePdf'])->name('orders.invoice.pdf');

        // Orders resource
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update', 'destroy']);

        // Orders bulk update and product toggle
        Route::post('orders/bulk-update', [\App\Http\Controllers\Admin\OrderController::class, 'bulkUpdate'])->name('orders.bulk');
        Route::post('products/{product}/toggle', [\App\Http\Controllers\Admin\ProductController::class, 'toggle'])->name('products.toggle');

        // Settings UI
        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // SEO placeholder
        Route::get('seo', [\App\Http\Controllers\Admin\SeoController::class, 'index'])->name('seo.index');
    });

Route::get('/sitemap.xml', function () {
    $urls = [];
    $urls[] = url('/');
    $urls = array_merge($urls, app(\App\Support\SiteStructure::class)->allUrls()->all());
    $categories = \App\Models\Category::select('slug')->get();
    foreach ($categories as $c) {
        $urls[] = url('/c/' . $c->slug);
    }
    $products = \App\Models\Product::where('is_active', true)->select('slug', 'updated_at')->get();

    return response()->view('sitemap', [
        'urls' => $urls,
        'products' => $products,
    ])->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/robots.txt', function () {
    $lines = [
        'User-agent: *',
        'Allow: /',
        'Disallow: /admin',
        'Sitemap: ' . url('/sitemap.xml'),
    ];
    return response(implode(PHP_EOL, $lines), 200)->header('Content-Type', 'text/plain');
})->name('robots');

// Legal pages (placeholders)
Route::view('/legal/cgv', 'legal.cgv')->name('legal.cgv');
Route::view('/legal/confidentialite', 'legal.confidentialite')->name('legal.confidentialite');
Route::view('/legal/livraison-retours', 'legal.livraison')->name('legal.livraison');

require __DIR__ . '/auth.php';
