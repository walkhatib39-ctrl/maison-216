@extends('layouts.store')

@section('content')
    <section class="py-12 lg:py-20 bg-gradient-to-b from-white to-dark-50/30">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10 lg:mb-14">
                <span class="inline-block bg-primary-100 text-primary-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                    Nos Collections
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark-900 mb-4">
                    Toutes les <span class="text-primary-600">catégories</span>
                </h1>
                <p class="text-base lg:text-lg text-dark-600 max-w-2xl mx-auto">
                    Explorez nos catégories pour trouver le meuble parfait pour votre maison.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
                @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}"
                       class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden border border-dark-100">
                        <div class="p-5 lg:p-6">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="font-bold text-base lg:text-lg text-dark-900 group-hover:text-primary-700 transition-colors duration-200 line-clamp-2">
                                        {{ $cat->name }}
                                    </div>

                                    @if($cat->children->count())
                                        <div class="text-xs lg:text-sm text-dark-500 mt-1 line-clamp-2">
                                            {{ $cat->children->pluck('name')->take(3)->join(' • ') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center font-bold shrink-0">
                                    {{ strtoupper(substr((string) $cat->name, 0, 1)) }}
                                </div>
                            </div>

                            <div class="mt-5 flex items-center justify-between">
                                <span class="text-sm text-dark-600">
                                    {{ $cat->children->count() }} sous-catégories
                                </span>

                                <span class="text-primary-700 font-semibold text-sm inline-flex items-center gap-2">
                                    Explorer
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection

