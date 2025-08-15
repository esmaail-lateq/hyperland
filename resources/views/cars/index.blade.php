@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
    <!-- Enhanced Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 py-16">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative z-10 container mx-auto px-4 text-center">
            <h1 class="text-5xl md:text-6xl font-black mb-6 text-white leading-tight">
                {{ __('cars.find_perfect_car') }}
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                اكتشف مجموعة واسعة من السيارات عالية الجودة مع خيارات بحث متقدمة
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-8 relative z-20">
        <!-- Enhanced Search Form -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/20">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">البحث المتقدم</h2>
                <p class="text-gray-600">استخدم الفلاتر المتقدمة للعثور على السيارة المثالية</p>
            </div>
            
            <form action="{{ route('cars.index') }}" method="GET" class="space-y-6">
                <!-- Primary Search Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="search-field-group">
                        <label for="make" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            {{ __('cars.car_make') }}
                        </label>
                        <div class="relative">
                            <select id="make" name="make" class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 text-gray-800 appearance-none shadow-sm hover:border-blue-300">
                                <option value="All Cars">{{ __('cars.all_cars') }}</option>
                                @foreach($makes as $make)
                                    <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="search-field-group">
                        <label for="min_price" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            {{ __('cars.min_price') }}
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 text-lg font-bold">€</span>
                            <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" 
                                   class="w-full p-4 pl-12 border-2 border-gray-200 rounded-xl bg-white focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 text-gray-800 shadow-sm hover:border-green-300" 
                                   placeholder="5000">
                        </div>
                    </div>
                    
                    <div class="search-field-group">
                        <label for="max_price" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            {{ __('cars.max_price') }}
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 text-lg font-bold">€</span>
                            <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" 
                                   class="w-full p-4 pl-12 border-2 border-gray-200 rounded-xl bg-white focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 text-gray-800 shadow-sm hover:border-purple-300" 
                                   placeholder="50000">
                        </div>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-6 rounded-xl font-bold hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            {{ __('cars.search_cars') }}
                        </button>
                    </div>
                </div>
                
                <!-- Advanced Search Toggle -->
                <div class="text-center">
                    <button id="advancedSearchBtn" type="button" class="inline-flex items-center px-6 py-3 text-blue-600 hover:text-blue-800 font-bold transition-all duration-300 text-base focus:outline-none focus:ring-4 focus:ring-blue-100 rounded-xl hover:bg-blue-50 group">
                        <span class="text-base">{{ __('cars.advanced_search_options') }}</span>
                        <svg class="w-5 h-5 ml-2 group-hover:ml-3 transition-all duration-300 transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
                
                <!-- Advanced Search Options -->
                <div id="advancedSearchOptions" class="hidden space-y-6 pt-6 border-t-2 border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="search-field-group">
                            <label for="status" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                {{ __('cars.car_status') }}
                            </label>
                            <select id="status" name="status" class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl bg-white focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-300 text-gray-800 shadow-sm hover:border-emerald-300">
                                <option value="">{{ __('cars.all_status') }}</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('cars.car_available') }}</option>
                                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>{{ __('cars.car_sold') }}</option>
                            </select>
                        </div>
                        
                        <div class="search-field-group">
                            <label for="min_year" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                {{ __('cars.min_year') }}
                            </label>
                            <input type="number" id="min_year" name="min_year" value="{{ request('min_year') }}" 
                                   class="w-full p-4 border-2 border-gray-200 rounded-xl bg-white focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all duration-300 text-gray-800 shadow-sm hover:border-orange-300" 
                                   placeholder="2010">
                        </div>

                        <div class="search-field-group">
                            <label for="max_year" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                {{ __('cars.max_year') }}
                            </label>
                            <input type="number" id="max_year" name="max_year" value="{{ request('max_year') }}" 
                                   class="w-full p-4 border-2 border-gray-200 rounded-xl bg-white focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all duration-300 text-gray-800 shadow-sm hover:border-red-300" 
                                   placeholder="2023">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="search-field-group">
                            <label for="transmission" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                {{ __('cars.car_transmission') }}
                            </label>
                            <select id="transmission" name="transmission" class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-300 text-gray-800 shadow-sm hover:border-indigo-300">
                                <option value="">{{ __('cars.any_transmission') }}</option>
                                <option value="automatic" {{ request('transmission') == 'automatic' ? 'selected' : '' }}>{{ __('cars.car_automatic') }}</option>
                                <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>{{ __('cars.car_manual') }}</option>
                                <option value="semi-automatic" {{ request('transmission') == 'semi-automatic' ? 'selected' : '' }}>{{ __('cars.car_semi_automatic') }}</option>
                            </select>
                        </div>
                        
                        <div class="search-field-group">
                            <label for="fuel_type" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                {{ __('cars.car_fuel_type') }}
                            </label>
                            <select id="fuel_type" name="fuel_type" class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl bg-white focus:ring-4 focus:ring-yellow-100 focus:border-yellow-500 transition-all duration-300 text-gray-800 shadow-sm hover:border-yellow-300">
                                <option value="">{{ __('cars.any_fuel_type') }}</option>
                                <option value="gasoline" {{ request('fuel_type') == 'gasoline' ? 'selected' : '' }}>{{ __('cars.car_gasoline') }}</option>
                                <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>{{ __('cars.car_diesel') }}</option>
                                <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>{{ __('cars.car_electric') }}</option>
                                <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>{{ __('cars.car_hybrid') }}</option>
                                <option value="lpg" {{ request('fuel_type') == 'lpg' ? 'selected' : '' }}>{{ __('cars.car_lpg') }}</option>
                            </select>
                        </div>

                        <div class="search-field-group">
                            <label for="condition" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                {{ __('cars.car_condition') }}
                            </label>
                            <select id="condition" name="condition" class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl bg-white focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-300 text-gray-800 shadow-sm hover:border-teal-300">
                                <option value="">{{ __('cars.any_condition') }}</option>
                                <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>{{ __('cars.car_new') }}</option>
                                <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>{{ __('cars.car_used') }}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="search-field-group">
                            <label for="cylinders" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                {{ __('cars.car_cylinders') }}
                            </label>
                            <select id="cylinders" name="cylinders" class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl bg-white focus:ring-4 focus:ring-pink-100 focus:border-pink-500 transition-all duration-300 text-gray-800 shadow-sm hover:border-pink-300">
                                <option value="">{{ __('cars.any_cylinders') }}</option>
                                <option value="3" {{ request('cylinders') == '3' ? 'selected' : '' }}>3 Cylinders</option>
                                <option value="4" {{ request('cylinders') == '4' ? 'selected' : '' }}>4 Cylinders</option>
                                <option value="6" {{ request('cylinders') == '6' ? 'selected' : '' }}>6 Cylinders</option>
                                <option value="8" {{ request('cylinders') == '8' ? 'selected' : '' }}>8 Cylinders</option>
                                <option value="10" {{ request('cylinders') == '10' ? 'selected' : '' }}>10 Cylinders</option>
                                <option value="12" {{ request('cylinders') == '12' ? 'selected' : '' }}>12 Cylinders</option>
                                <option value="16" {{ request('cylinders') == '16' ? 'selected' : '' }}>16 Cylinders</option>
                            </select>
                        </div>
                    </div>

                    <!-- Enhanced Features Section -->
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            {{ __('cars.additional_features') }}
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="feature-checkbox">
                                <input type="checkbox" name="has_air_conditioning" value="1" {{ request('has_air_conditioning') ? 'checked' : '' }} class="sr-only">
                                <div class="checkbox-custom">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium">{{ __('cars.air_conditioning') }}</span>
                            </label>
                            
                            <label class="feature-checkbox">
                                <input type="checkbox" name="has_leather_seats" value="1" {{ request('has_leather_seats') ? 'checked' : '' }} class="sr-only">
                                <div class="checkbox-custom">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium">{{ __('cars.leather_seats') }}</span>
                            </label>
                            
                            <label class="feature-checkbox">
                                <input type="checkbox" name="has_navigation" value="1" {{ request('has_navigation') ? 'checked' : '' }} class="sr-only">
                                <div class="checkbox-custom">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium">{{ __('cars.navigation') }}</span>
                            </label>
                            
                            <label class="feature-checkbox">
                                <input type="checkbox" name="has_parking_sensors" value="1" {{ request('has_parking_sensors') ? 'checked' : '' }} class="sr-only">
                                <div class="checkbox-custom">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium">{{ __('cars.parking_sensors') }}</span>
                            </label>
                            
                            <label class="feature-checkbox">
                                <input type="checkbox" name="has_parking_camera" value="1" {{ request('has_parking_camera') ? 'checked' : '' }} class="sr-only">
                                <div class="checkbox-custom">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium">{{ __('cars.parking_camera') }}</span>
                            </label>
                            
                            <label class="feature-checkbox">
                                <input type="checkbox" name="has_heated_seats" value="1" {{ request('has_heated_seats') ? 'checked' : '' }} class="sr-only">
                                <div class="checkbox-custom">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium">{{ __('cars.heated_seats') }}</span>
                            </label>
                            
                            <label class="feature-checkbox">
                                <input type="checkbox" name="has_bluetooth" value="1" {{ request('has_bluetooth') ? 'checked' : '' }} class="sr-only">
                                <div class="checkbox-custom">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium">{{ __('cars.bluetooth') }}</span>
                            </label>
                            
                            <label class="feature-checkbox">
                                <input type="checkbox" name="has_led_lights" value="1" {{ request('has_led_lights') ? 'checked' : '' }} class="sr-only">
                                <div class="checkbox-custom">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium">{{ __('cars.led_lights') }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Enhanced Status Information -->
        <div class="mt-8 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl p-6 border border-white/20">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 w-full sm:w-auto">
                    <div class="status-card bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3 animate-pulse"></div>
                            <div>
                                <div class="text-2xl font-bold text-green-800">{{ $cars->where('status', 'approved')->count() }}</div>
                                <div class="text-sm text-green-600 font-medium">{{ __('cars.available_cars') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="status-card bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-purple-500 rounded-full mr-3 animate-pulse"></div>
                            <div>
                                <div class="text-2xl font-bold text-purple-800">{{ $cars->where('status', 'sold')->count() }}</div>
                                <div class="text-sm text-purple-600 font-medium">{{ __('cars.sold_cars') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="status-card bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3 animate-pulse"></div>
                            <div>
                                <div class="text-2xl font-bold text-yellow-800">{{ $cars->where('status', 'pending')->count() }}</div>
                                <div class="text-sm text-yellow-600 font-medium">{{ __('cars.pending_cars') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="status-card bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3 animate-pulse"></div>
                            <div>
                                <div class="text-2xl font-bold text-blue-800">{{ $cars->whereNotNull('cylinders')->count() }}</div>
                                <div class="text-sm text-blue-600 font-medium">{{ __('cars.with_cylinders') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 rounded-xl border border-gray-200">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $cars->total() }}</div>
                        <div class="text-sm text-gray-600 font-medium">{{ __('cars.total_cars') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cars List -->
        <div id="cars-list" class="mt-8">
            @include('cars.grid', ['cars' => $cars])
        </div>
        
        <noscript>
            @include('cars.grid', ['cars' => $cars])
        </noscript>
    </div>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Advanced search toggle with enhanced animations
            const advancedSearchBtn = document.getElementById('advancedSearchBtn');
            const advancedSearchOptions = document.getElementById('advancedSearchOptions');
            
            // Initial state check for advanced search options based on URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const hasAdvancedFilters = ['min_year', 'max_year', 'transmission', 'fuel_type', 'condition', 'cylinders',
                                        'has_air_conditioning', 'has_leather_seats', 'has_navigation', 
                                        'has_parking_sensors', 'has_parking_camera', 'has_heated_seats', 
                                        'has_bluetooth', 'has_led_lights'].some(param => urlParams.has(param));

            if (hasAdvancedFilters) {
                advancedSearchOptions.classList.remove('hidden');
                const arrow = advancedSearchBtn.querySelector('svg');
                arrow.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
                arrow.classList.add('rotate-180');
            }

            advancedSearchBtn.addEventListener('click', function() {
                advancedSearchOptions.classList.toggle('hidden');
                
                // Enhanced arrow animation
                const arrow = this.querySelector('svg');
                if (advancedSearchOptions.classList.contains('hidden')) {
                    arrow.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
                    arrow.classList.remove('rotate-180');
                } else {
                    arrow.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
                    arrow.classList.add('rotate-180');
                }
            });

            // Enhanced form field interactions
            const formFields = document.querySelectorAll('input, select');
            formFields.forEach(field => {
                field.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-4', 'ring-blue-100');
                });
                
                field.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-4', 'ring-blue-100');
                });
            });
        });
    </script>
@endpush

@push('styles')
<style>
    /* Enhanced Custom Styles */
    .search-field-group {
        @apply transition-all duration-300;
    }
    
    .search-field-group:hover {
        @apply transform -translate-y-1;
    }
    
    .status-card {
        @apply transition-all duration-300 cursor-pointer;
    }
    
    .status-card:hover {
        @apply transform scale-105;
    }
    
    .feature-checkbox {
        @apply flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-blue-300 transition-all duration-300 cursor-pointer hover:shadow-md;
    }
    
    .feature-checkbox:hover {
        @apply transform -translate-y-1;
    }
    
    .checkbox-custom {
        @apply w-5 h-5 border-2 border-gray-300 rounded-md flex items-center justify-center transition-all duration-300;
    }
    
    .feature-checkbox input:checked + .checkbox-custom {
        @apply bg-blue-500 border-blue-500;
    }
    
    .feature-checkbox input:checked + .checkbox-custom svg {
        @apply text-white;
    }
    
    /* Enhanced focus states */
    .search-field-group:focus-within {
        @apply transform -translate-y-1;
    }
    
    /* Smooth transitions for all interactive elements */
    * {
        @apply transition-all duration-200;
    }
    
    /* Enhanced button hover effects */
    button:hover {
        @apply transform -translate-y-1;
    }
    
    /* Custom scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        @apply bg-gray-100 rounded-full;
    }
    
    ::-webkit-scrollbar-thumb {
        @apply bg-blue-300 rounded-full hover:bg-blue-400;
    }
</style>
@endpush
