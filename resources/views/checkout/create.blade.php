@extends('layouts.store')

@section('content')
@php
    $shippingFeeDt = (int) floor((\App\Models\Setting::get('shipping.fee_millimes', 20000) ?? 20000) / 1000);
    $wh = \App\Models\Setting::get('contact.whatsapp');
    $whDigits = $wh ? preg_replace('/\D+/', '', (string)$wh) : null;
    $ms = \App\Models\Setting::get('contact.messenger');
@endphp

<section class="bg-gradient-to-r from-primary-50 to-primary-100/50 border-b border-primary-200">
    <div class="container mx-auto px-4 py-6">
        <nav class="flex items-center gap-2 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors">Accueil</a>
            <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            @if($product->category)
                <a href="{{ route('category.show', $product->category->slug) }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors">
                    {{ $product->category->name }}
                </a>
                <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            @endif
            <a href="{{ route('product.show', $product->slug) }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors">
                {{ $product->title }}
            </a>
            <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-dark-700 font-semibold">Checkout</span>
        </nav>
    </div>
</section>

<div class="container mx-auto px-4 py-8 lg:py-12">
    <div class="grid lg:grid-cols-12 gap-8 lg:gap-12">
        <!-- Order form -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl border border-dark-100 p-6 lg:p-8 shadow-xl">
                <h1 class="text-2xl lg:text-3xl font-extrabold text-dark-900 mb-6">Finaliser ma commande</h1>

                <form id="checkout-form" action="{{ route('checkout.store', $product->slug) }}" method="post" class="space-y-5">
                    @csrf

                    <!-- Quantity moved to the summary card on the right -->

                    <!-- Customer Info -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Nom complet *</label>
                            <input name="full_name" required
                                   aria-invalid="{{ $errors->has('full_name') ? 'true' : 'false' }}"
                                   class="w-full px-4 py-3 border-2 rounded-xl focus:ring-0 transition-colors bg-white {{ $errors->has('full_name') ? 'border-red-500 focus:border-red-500' : 'border-dark-200 focus:border-primary-500' }}"
                                   value="{{ old('full_name') }}" placeholder="Votre nom complet">
                            @error('full_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Téléphone *</label>
                            <div class="flex">
                                <div class="flex items-center gap-2 px-3 border-2 border-dark-200 rounded-l-xl bg-gray-50 text-dark-700">
                                    <span class="inline-flex items-center justify-center w-5 h-4 rounded-sm overflow-hidden" aria-hidden="true">
                                        <svg width="20" height="14" viewBox="0 0 20 14">
                                            <rect width="20" height="14" fill="#E70013"></rect>
                                            <circle cx="10" cy="7" r="4.2" fill="#ffffff"></circle>
                                            <circle cx="10.8" cy="7" r="3" fill="#E70013"></circle>
                                            <circle cx="10.3" cy="7" r="2.6" fill="#ffffff"></circle>
                                            <path d="M12 7l1.1.35-.68.95-.02-1.15-1.04-.66 1.16-.04.36-1.1.35 1.1 1.14.04-1.02.67.02 1.15z" fill="#E70013"></path>
                                        </svg>
                                    </span>
                                    <span class="text-sm font-semibold">TN</span>
                                    <span class="text-sm text-dark-600">( +216 )</span>
                                </div>
                                <input name="phone" required inputmode="numeric" autocomplete="tel"
                                       class="flex-1 px-4 py-3 border-2 border-l-0 border-dark-200 rounded-r-xl focus:border-primary-500 focus:ring-0 transition-colors bg-white"
                                       value="{{ old('phone') }}" placeholder="55 123 456"
                                       pattern="^(?:\+?216)?\s*[24579](?:\s*\d){7}$"
                                       title="Numéro tunisien: 8 chiffres commençant par 2/4/5/7/9, ex: 55 123 456"
                                       data-tel-tn>
                            </div>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Ville *</label>
                            <input name="city" required
                                   aria-invalid="{{ $errors->has('city') ? 'true' : 'false' }}"
                                   class="w-full px-4 py-3 border-2 rounded-xl focus:ring-0 transition-colors bg-white {{ $errors->has('city') ? 'border-red-500 focus:border-red-500' : 'border-dark-200 focus:border-primary-500' }}"
                                   value="{{ old('city') }}" placeholder="Votre ville">
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Adresse complète *</label>
                        <textarea name="address" required rows="3"
                                  aria-invalid="{{ $errors->has('address') ? 'true' : 'false' }}"
                                  class="w-full px-4 py-3 border-2 rounded-xl focus:ring-0 transition-colors bg-white resize-none {{ $errors->has('address') ? 'border-red-500 focus:border-red-500' : 'border-dark-200 focus:border-primary-500' }}"
                                  placeholder="Adresse complète de livraison">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Email</label>
                            <input type="email" name="email"
                                   aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                   class="w-full px-4 py-3 border-2 rounded-xl focus:ring-0 transition-colors bg-white {{ $errors->has('email') ? 'border-red-500 focus:border-red-500' : 'border-dark-200 focus:border-primary-500' }}"
                                   value="{{ old('email') }}" placeholder="votre@email.com (optionnel)">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Commentaire</label>
                        <textarea name="customer_note" rows="2"
                                  aria-invalid="{{ $errors->has('customer_note') ? 'true' : 'false' }}"
                                  class="w-full px-4 py-3 border-2 rounded-xl focus:ring-0 transition-colors bg-white resize-none {{ $errors->has('customer_note') ? 'border-red-500 focus:border-red-500' : 'border-dark-200 focus:border-primary-500' }}"
                                  placeholder="Instructions spéciales...">{{ old('customer_note') }}</textarea>
                        @error('customer_note')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="space-y-3 pt-2">
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-[1.01] flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Confirmer ma commande
                        </button>

                        <div class="text-center text-sm text-dark-600">ou contactez-nous directement</div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @if($whDigits)
                                @php
                                    $whatsappMsg = rawurlencode("Bonjour, je souhaite commander: {$product->title} - " . url(route('product.show', $product->slug, false)));
                                @endphp
                                <a href="https://wa.me/{{ $whDigits }}?text={{ $whatsappMsg }}"
                                   target="_blank" rel="noopener"
                                   class="flex items-center justify-center gap-3 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors shadow-lg">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/></svg>
                                    WhatsApp
                                </a>
                            @endif

                            @if($ms)
                                <a href="{{ $ms }}" target="_blank" rel="noopener"
                                   class="flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors shadow-lg">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 4.975 0 11.111c0 3.497 1.745 6.616 4.472 8.652V24l4.086-2.242c1.09.301 2.246.464 3.442.464 6.626 0 12-4.974 12-11.111C24 4.975 18.626 0 12 0z"/></svg>
                                    Messenger
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary -->
        <div class="lg:col-span-5">
            <div class="lg:sticky lg:top-8 space-y-6">
                <div class="bg-white rounded-2xl border border-dark-100 p-6 shadow-xl">
                    <div class="flex items-start gap-4">
                        <img src="{{ $product->main_image ?? ($product->images->first()->url ?? 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?q=80&w=1200&auto=format&fit=crop') }}"
                             alt="{{ $product->title }}" class="w-28 h-28 object-cover rounded-xl border">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-dark-900">{{ $product->title }}</h3>
                            @if($product->category)
                                <div class="text-sm text-dark-600">{{ $product->category->name }}</div>
                            @endif
                            <div class="mt-3">
                                <div class="text-2xl font-extrabold text-primary-700">{{ $product->price_display }}</div>
                                @if($product->compare_at_display)
                                    <div class="text-sm line-through text-dark-400">{{ $product->compare_at_display }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quantity (now here, linked to the form via the 'form' attribute) -->
                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Quantité</label>
                        <input type="number" min="1" max="20" name="quantity" form="checkout-form" id="qty-input"
                               value="{{ old('quantity', $qty ?? 1) }}"
                               aria-invalid="{{ $errors->has('quantity') ? 'true' : 'false' }}"
                               class="w-28 px-4 py-3 border-2 rounded-xl focus:ring-0 transition-colors bg-white {{ $errors->has('quantity') ? 'border-red-500 focus:border-red-500' : 'border-dark-200 focus:border-primary-500' }}">
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product total -->
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-dark-600">Total produit</span>
                        <span id="product-total-display"
                              class="text-xl font-extrabold text-dark-900"
                              data-unit="{{ (int) floor(($product->price_millimes ?? 0)/1000) }}">
                            {{ $product->price_display }}
                        </span>
                    </div>

                    <div class="mt-6 p-4 bg-primary-50 rounded-xl border border-primary-200 text-primary-800 text-sm">
                        Livraison partout en Tunisie (3–7 jours) • Frais {{ $shippingFeeDt }} DT • Paiement à la livraison
                    </div>
                </div>

                @if(!$product->inStock())
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
                        <div class="flex items-center gap-2 text-amber-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="text-sm font-medium">Stock à confirmer lors de la prise de contact</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('head')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const qty = document.getElementById('qty-input');
  const disp = document.getElementById('product-total-display');
  if (qty && disp) {
    const unit = parseInt(disp.dataset.unit || '0', 10);
    const clamp = (n) => Math.max(1, Math.min(20, isNaN(n) ? 1 : n));
    const update = () => {
      const q = clamp(parseInt(qty.value, 10));
      qty.value = q;
      const total = unit * q;
      disp.textContent = total + ' DT';
    };
    qty.addEventListener('input', update);
    update();
  }
});
</script>
@endpush
@endsection
