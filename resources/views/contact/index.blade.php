@extends('layouts.store')

@section('content')
@php
    $wa = \App\Models\Setting::get('contact.whatsapp');
    $waDigits = $wa ? preg_replace('/\D+/', '', (string)$wa) : null;
    $ms = \App\Models\Setting::get('contact.messenger');
@endphp

<section class="bg-gradient-to-r from-primary-50 to-primary-100/50 border-b border-primary-200">
    <div class="container mx-auto px-4 py-6">
        <nav class="flex items-center gap-2 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors">Accueil</a>
            <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-dark-700 font-semibold">Contact</span>
        </nav>
    </div>
</section>

<div class="container mx-auto px-4 py-8 lg:py-12">
    <div class="grid lg:grid-cols-12 gap-8 lg:gap-12">
        <!-- Contact details -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl border border-dark-100 p-6 shadow-xl">
                <h1 class="text-2xl lg:text-3xl font-extrabold text-dark-900 mb-2">Contactez-nous</h1>
                <p class="text-dark-600 mb-6">Notre équipe répond rapidement 7j/7.</p>

                <div class="space-y-3">
                    @if($waDigits)
                    <a href="https://wa.me/{{ $waDigits }}"
                       target="_blank" rel="noopener"
                       class="w-full inline-flex items-center justify-center gap-3 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
                        WhatsApp
                    </a>
                    @endif
                    @if($ms)
                    <a href="{{ $ms }}" target="_blank" rel="noopener"
                       class="w-full inline-flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 4.975 0 11.111c0 3.497 1.745 6.616 4.472 8.652V24l4.086-2.242c1.09.301 2.246.464 3.442.464 6.626 0 12-4.974 12-11.111C24 4.975 18.626 0 12 0z"/></svg>
                        Messenger
                    </a>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-dark-100 p-6 shadow-sm">
                <h2 class="text-lg font-bold text-dark-900 mb-2">Coordonnées</h2>
                <ul class="space-y-2 text-dark-700">
                    @if($wa)<li><strong>WhatsApp:</strong> {{ $wa }}</li>@endif
                    @if(\App\Models\Setting::get('contact.admin_email'))<li><strong>Email:</strong> {{ \App\Models\Setting::get('contact.admin_email') }}</li>@endif
                    <li><strong>Site:</strong> {{ url('/') }}</li>
                </ul>
            </div>
        </div>

        <!-- Contact form -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl border border-dark-100 p-6 lg:p-8 shadow-xl">
                <h3 class="text-xl font-bold text-dark-900 mb-4">Formulaire de contact</h3>

                <form action="{{ route('contact.submit') }}" method="post" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Nom *</label>
                            <input name="name" required value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border-2 rounded-xl focus:ring-0 transition-colors bg-white {{ $errors->has('name') ? 'border-red-500 focus:border-red-500' : 'border-dark-200 focus:border-primary-500' }}">
                            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Email *</label>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border-2 rounded-xl focus:ring-0 transition-colors bg-white {{ $errors->has('email') ? 'border-red-500 focus:border-red-500' : 'border-dark-200 focus:border-primary-500' }}">
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Téléphone (TN)</label>
                        <div class="flex">
                            <div class="flex items-center gap-2 px-3 border-2 border-dark-200 rounded-l-xl bg-gray-50 text-dark-700">
                                <span class="text-lg" aria-hidden="true">🇹🇳</span>
                                <span class="text-sm font-semibold">TN</span>
                                <span class="text-sm text-dark-600">( +216 )</span>
                            </div>
                            <input name="phone" inputmode="numeric" autocomplete="tel"
                                   class="flex-1 px-4 py-3 border-2 border-l-0 border-dark-200 rounded-r-xl focus:border-primary-500 focus:ring-0 transition-colors bg-white"
                                   value="{{ old('phone') }}" placeholder="55 123 456"
                                   pattern="^(?:\+?216\s*)?(?:[24579]\d{7}|[24579]\d{2}\s\d{3}\s\d{3})$"
                                   title="Numéro tunisien: 8 chiffres commençant par 2/4/5/7/9, ex: 55 123 456"
                                   data-tel-tn>
                        </div>
                        @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Message *</label>
                        <textarea name="message" rows="5" required
                                  class="w-full px-4 py-3 border-2 rounded-xl focus:ring-0 transition-colors bg-white resize-none {{ $errors->has('message') ? 'border-red-500 focus:border-red-500' : 'border-dark-200 focus:border-primary-500' }}"
                                  placeholder="Votre message...">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 shadow-xl hover:shadow-2xl">
                            Envoyer
                        </button>
                    </div>

                    <p class="text-xs text-dark-500">En soumettant ce formulaire, vous acceptez nos conditions et notre politique de confidentialité.</p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
