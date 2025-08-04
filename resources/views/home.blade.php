@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Enhanced Hero Section -->
    <section class="hero-section text-white py-20 hero-loading">
        <!-- Dynamic Background Images -->
        <div class="absolute inset-0 bg-car-slider opacity-30"></div>
        
        <!-- Animated Elements -->
        <div class="absolute inset-0">
            <div class="floating-shapes"></div>
        </div>
        
        <!-- Content -->
        <div class="relative container mx-auto px-4 z-10">
            <div class="text-center max-w-5xl mx-auto">
                <!-- Enhanced Title -->
                <h1 class="text-6xl md:text-7xl font-black mb-8 leading-tight">
                    <span class="hero-title-gradient">
                        {{ __('home.hero_title') }}
                    </span>
                </h1>
                
                <!-- Enhanced Subtitle -->
                <p class="text-2xl md:text-3xl mb-12 text-blue-100 font-light">
                    {{ __('home.hero_subtitle') }}
                </p>
                
                <!-- Enhanced Search Form -->
                <div class="glass-card p-8 rounded-3xl shadow-2xl max-w-3xl mx-auto mb-12">
                    <form action="{{ route('cars.index') }}" method="GET" class="search-form-enhanced">
                        <input type="text" name="search" placeholder="{{ __('home.search_placeholder') }}" 
                               class="search-input-enhanced">
                        <button type="submit" class="search-button-enhanced">
                            {{ __('home.search_button') }}
                        </button>
                    </form>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center mb-16">
                    <a href="{{ route('cars.index') }}" class="cta-button-primary">
                        {{ __('home.browse_cars') }}
                    </a>
                    <a href="{{ route('cars.create') }}" class="cta-button-secondary">
                        {{ __('home.sell_car') }}
                    </a>
                </div>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <div class="stats-card text-center">
                        <div class="stats-number">{{ number_format($totalCarsCount) }}</div>
                        <div class="text-blue-100 font-medium">{{ __('home.cars_available') }}</div>
                    </div>
                    <div class="stats-card text-center">
                        <div class="stats-number">2,500+</div>
                        <div class="text-blue-100 font-medium">{{ __('home.daily_visitors') }}</div>
                    </div>
                    <div class="stats-card text-center">
                        <div class="stats-number">1,200+</div>
                        <div class="text-blue-100 font-medium">{{ __('home.successful_sales') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Stats Section -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('home.hero_stats_title') }}</h2>
                <p class="text-lg text-gray-600">إحصائيات حية من منصتنا</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($totalCarsCount) }}</div>
                    <div class="text-gray-600 font-medium">{{ __('home.total_cars') }}</div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-green-600 mb-2">{{ $featuredCars->count() }}</div>
                    <div class="text-gray-600 font-medium">{{ __('home.featured_cars') }}</div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">1,500+</div>
                    <div class="text-gray-600 font-medium">{{ __('home.happy_customers') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Cars Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('home.featured_cars_title') }}</h2>
                <p class="text-xl text-gray-600">{{ __('home.featured_cars_subtitle') }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($featuredCars as $car)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="relative h-64 rounded-t-2xl overflow-hidden">
                        @if($car->images->count() > 0)
                            <img src="{{ Storage::url($car->images->first()->image_path) }}" alt="{{ $car->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <img src="{{ asset('images/default-car.svg') }}" alt="Default Car" class="w-1/3 h-1/3 opacity-50">
                            </div>
                        @endif
                        
                        {{-- Featured Badge (keep on image) --}}
                        <div class="absolute top-4 right-4 z-20">
                            @if($car->is_featured)
                                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 text-xs font-bold rounded-full shadow-lg">
                                    FEATURED
                                </div>
                            @endif
                        </div>
                        
                        {{-- Sold Overlay --}}
                        @if($car->status === 'sold')
                            <div class="absolute inset-0 bg-red-600/90 flex items-center justify-center z-10">
                                <div class="text-white text-center">
                                    <div class="text-4xl font-black mb-2 text-red-200">{{ __('home.sold') }}</div>
                                    <div class="text-sm font-medium text-red-300">{{ __('home.this_car_has_been_sold') }}</div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="absolute bottom-4 left-4 bg-black/70 backdrop-blur-sm text-white px-3 py-1 text-sm font-medium rounded-lg">
                            {{ $car->year }}
                        </div>
                    </div>
                    
                    <div class="p-6">
                        {{-- Ad Number --}}
                        <div class="text-xs text-gray-600 mb-4 font-mono bg-gray-100 px-3 py-2 rounded-lg inline-block border border-gray-200">
                            <span class="font-semibold">{{ __('home.ad_number') }}:</span> {{ $car->adNumber }}
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-6 group-hover:text-indigo-600 transition-colors duration-300 leading-relaxed">{{ $car->title }}</h3>
                        
                        {{-- Car Details - Clean Layout --}}
                        <div class="space-y-4 mb-6">
                            {{-- Row 1: Year & Mileage --}}
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-blue-600 font-medium">{{ __('home.manufacturing_year') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $car->year }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-indigo-600 font-medium">{{ __('home.mileage') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ number_format($car->mileage) }} كم</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Row 2: Transmission & Fuel Type --}}
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-green-600 font-medium">{{ __('home.transmission') }}</p>
                                            <p class="text-lg font-bold text-gray-900 capitalize">{{ $car->transmission }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-emerald-600 font-medium">{{ __('home.fuel_type') }}</p>
                                            <p class="text-lg font-bold text-gray-900 capitalize">{{ $car->fuel_type }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Row 3: Location & Cylinders --}}
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-xl border border-purple-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-purple-600 font-medium">{{ __('home.location') }}</p>
                                            <p class="text-lg font-bold text-gray-900 truncate">{{ $car->location }}</p>
                                        </div>
                                    </div>
                                    @if($car->cylinders)
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-pink-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-pink-600 font-medium">{{ __('home.cylinders') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $car->cylinders }} سلندر</p>
                                        </div>
                                    </div>
                                    @else
                                    <div></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Price and Rating --}}
                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-4 rounded-xl border border-indigo-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-indigo-600 font-medium mb-1">{{ __('home.price') }}</p>
                                    <span class="text-3xl font-black text-indigo-600">{{ $car->formattedPrice }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($car->status === 'sold')
                                        <div class="bg-red-500 text-white px-3 py-2 rounded-full font-bold text-sm shadow-lg border-2 border-red-400">
                                            {{ __('home.sold') }}
                                        </div>
                                    @endif
                                    <div class="flex items-center bg-yellow-100 px-3 py-2 rounded-lg">
                                        <svg class="w-5 h-5 text-yellow-600 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-yellow-700 font-medium">{{ __('home.rating') }}</p>
                                            <p class="text-sm font-bold text-yellow-700">4.8</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center">
                <a href="{{ route('cars.index') }}" class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    {{ __('home.view_all') }}
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Latest Listings Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('home.latest_listings_title') }}</h2>
                <p class="text-xl text-gray-600">{{ __('home.latest_listings_subtitle') }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($latestCars as $car)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group relative">
                    {{-- New Badge (top-right corner of card) --}}
                    @if($car->isNew)
                        <div class="absolute top-2 right-2 bg-gray-200 text-gray-800 px-2 py-1 text-xs font-bold rounded-md shadow-sm z-10">
                            {{ __('home.new') }}
                        </div>
                    @endif
                    
                    <div class="relative h-64 rounded-t-2xl overflow-hidden">
                        @if($car->images->count() > 0)
                            <img src="{{ Storage::url($car->images->first()->image_path) }}" alt="{{ $car->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <img src="{{ asset('images/default-car.svg') }}" alt="Default Car" class="w-1/3 h-1/3 opacity-50">
                            </div>
                        @endif
                        
                        @if($car->is_featured)
                            <div class="absolute top-4 right-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 text-xs font-bold rounded-full shadow-lg">
                                FEATURED
                            </div>
                        @endif
                        
                        {{-- Sold Overlay --}}
                        @if($car->status === 'sold')
                            <div class="absolute inset-0 bg-red-600/90 flex items-center justify-center z-10">
                                <div class="text-white text-center">
                                    <div class="text-4xl font-black mb-2 text-red-200">{{ __('home.sold') }}</div>
                                    <div class="text-sm font-medium text-red-300">{{ __('home.this_car_has_been_sold') }}</div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="absolute bottom-4 left-4 bg-black/70 backdrop-blur-sm text-white px-3 py-1 text-sm font-medium rounded-lg">
                            {{ $car->year }}
                        </div>
                    </div>
                    
                    <div class="p-6">
                        {{-- Ad Number --}}
                        <div class="text-xs text-gray-600 mb-4 font-mono bg-gray-100 px-3 py-2 rounded-lg inline-block border border-gray-200">
                            <span class="font-semibold">{{ __('home.ad_number') }}:</span> {{ $car->adNumber }}
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-6 group-hover:text-indigo-600 transition-colors duration-300 leading-relaxed">{{ $car->title }}</h3>
                        
                        {{-- Car Details - Clean Layout --}}
                        <div class="space-y-4 mb-6">
                            {{-- Row 1: Year & Mileage --}}
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-blue-600 font-medium">{{ __('home.manufacturing_year') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $car->year }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-indigo-600 font-medium">{{ __('home.mileage') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ number_format($car->mileage) }} كم</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Row 2: Transmission & Fuel Type --}}
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-green-600 font-medium">{{ __('home.transmission') }}</p>
                                            <p class="text-lg font-bold text-gray-900 capitalize">{{ $car->transmission }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-emerald-600 font-medium">{{ __('home.fuel_type') }}</p>
                                            <p class="text-lg font-bold text-gray-900 capitalize">{{ $car->fuel_type }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Row 3: Location & Cylinders --}}
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-xl border border-purple-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-purple-600 font-medium">{{ __('home.location') }}</p>
                                            <p class="text-lg font-bold text-gray-900 truncate">{{ $car->location }}</p>
                                        </div>
                                    </div>
                                    @if($car->cylinders)
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-pink-500 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-pink-600 font-medium">{{ __('home.cylinders') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $car->cylinders }} سلندر</p>
                                        </div>
                                    </div>
                                    @else
                                    <div></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Price --}}
                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-4 rounded-xl border border-indigo-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-indigo-600 font-medium mb-1">{{ __('home.price') }}</p>
                                    <div class="text-3xl font-black text-indigo-600">{{ $car->formattedPrice }}</div>
                                </div>
                                @if($car->status === 'sold')
                                    <div class="bg-red-500 text-white px-3 py-2 rounded-full font-bold text-sm shadow-lg border-2 border-red-400">
                                        {{ __('home.sold') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">{{ __('home.about_title') }}</h2>
                <p class="text-xl text-gray-600 mb-8">{{ __('home.about_subtitle') }}</p>
                <p class="text-lg text-gray-700 mb-8 leading-relaxed">{{ __('home.about_description') }}</p>
                <a href="{{ route('about') }}" class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    {{ __('home.learn_more') }}
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection