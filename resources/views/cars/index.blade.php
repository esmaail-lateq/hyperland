@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Browse Cars</h1>
    
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8 border-t-4 border-blue-500">
        <form action="{{ route('cars.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="search-field">
                <label for="make" class="block text-sm font-semibold text-gray-700 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Cars
                </label>
                <div class="relative select-none">
                    <div class="fake-select">
                        <select id="make" name="make" class="hidden">
                            <option value="All Cars">All Cars</option>
                            @foreach($makes as $make)
                                <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                            @endforeach
                        </select>
                        
                        <div id="makeDropdown" class="select-box w-full p-3 pr-10 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all flex justify-between items-center cursor-pointer">
                            <span id="selectedMake">{{ request('make') ?: 'All Cars' }}</span>
                            <svg class="fill-current h-5 w-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                        
                        <div id="makeOptions" class="dropdown-content hidden absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            <div class="p-2 hover:bg-blue-50 cursor-pointer" data-value="All Cars">All Cars</div>
                            @foreach($makes as $make)
                                <div class="p-2 hover:bg-blue-50 cursor-pointer" data-value="{{ $make }}">{{ $make }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="search-field">
                <label for="min_price" class="block text-sm font-semibold text-gray-700 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Min Price (€)
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">€</span>
                    <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" class="block w-full p-3 pl-8 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Minimum price">
                </div>
            </div>
            
            <div class="search-field">
                <label for="max_price" class="block text-sm font-semibold text-gray-700 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Max Price (€)
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">€</span>
                    <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" class="block w-full p-3 pl-8 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Maximum price">
                </div>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    SEARCH
                </button>
            </div>
            
            <div class="md:col-span-2 lg:col-span-4 mt-2">
                <button id="advancedSearchBtn" type="button" class="text-blue-600 hover:text-blue-800 font-medium flex items-center group transition-all">
                    <span>Advanced Search</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:ml-2 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <div id="advancedSearchOptions" class="hidden grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-200">
                    <div class="search-field">
                        <label for="min_year" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Min Year
                        </label>
                        <input type="number" id="min_year" name="min_year" value="{{ request('min_year') }}" class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="From year">
                    </div>

                    <div class="search-field">
                        <label for="max_year" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Max Year
                        </label>
                        <input type="number" id="max_year" name="max_year" value="{{ request('max_year') }}" class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="To year">
                    </div>
                    
                    <div class="search-field">
                        <label for="transmission" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Transmission
                        </label>
                        <select id="transmission" name="transmission" class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Any Transmission</option>
                            <option value="automatic" {{ request('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                            <option value="semi-automatic" {{ request('transmission') == 'semi-automatic' ? 'selected' : '' }}>Semi-Automatic</option>
                        </select>
                    </div>
                    
                    <div class="search-field">
                        <label for="fuel_type" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Fuel Type
                        </label>
                        <select id="fuel_type" name="fuel_type" class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Any Fuel Type</option>
                            <option value="gasoline" {{ request('fuel_type') == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                            <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                            <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="lpg" {{ request('fuel_type') == 'lpg' ? 'selected' : '' }}>LPG</option>
                        </select>
                    </div>

                    <!-- Condition -->
                    <div class="search-field">
                        <label for="condition" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Condition
                        </label>
                        <select id="condition" name="condition" class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Any Condition</option>
                            <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
                        </select>
                    </div>

                    <!-- Features -->
                    <div class="col-span-full mt-4">
                        <p class="text-sm font-semibold text-gray-700 mb-3">Features</p>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="has_air_conditioning" value="1" {{ request('has_air_conditioning') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Air Conditioning</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="has_leather_seats" value="1" {{ request('has_leather_seats') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Leather Seats</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="has_navigation" value="1" {{ request('has_navigation') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Navigation</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="has_parking_sensors" value="1" {{ request('has_parking_sensors') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Parking Sensors</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="has_parking_camera" value="1" {{ request('has_parking_camera') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Parking Camera</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="has_heated_seats" value="1" {{ request('has_heated_seats') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Heated Seats</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="has_bluetooth" value="1" {{ request('has_bluetooth') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Bluetooth</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="has_led_lights" value="1" {{ request('has_led_lights') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">LED Lights</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Vue Component -->
    <div id="cars-list">
        @include('cars.grid', ['cars' => $cars])
    </div>
    
    <!-- Fallback for no JavaScript -->
    <noscript>
        @include('cars.grid', ['cars' => $cars])
    </noscript>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Custom dropdown for make selection
            const makeDropdown = document.getElementById('makeDropdown');
            const makeOptions = document.getElementById('makeOptions');
            const selectedMake = document.getElementById('selectedMake');
            const selectElement = document.getElementById('make');
            
            makeDropdown.addEventListener('click', function() {
                makeOptions.classList.toggle('hidden');
            });
            
            document.querySelectorAll('#makeOptions div').forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    selectedMake.textContent = this.textContent;
                    selectElement.value = value;
                    makeOptions.classList.add('hidden');
                });
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!makeDropdown.contains(event.target)) {
                    makeOptions.classList.add('hidden');
                }
            });
            
            // Advanced search toggle
            const advancedSearchBtn = document.getElementById('advancedSearchBtn');
            const advancedSearchOptions = document.getElementById('advancedSearchOptions');
            
            advancedSearchBtn.addEventListener('click', function() {
                advancedSearchOptions.classList.toggle('hidden');
                
                // Change the arrow direction
                const arrow = this.querySelector('svg');
                if (advancedSearchOptions.classList.contains('hidden')) {
                    arrow.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
                } else {
                    arrow.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
                }
            });
        });
    </script>
@endpush

@push('styles')
<style>
    /* Dropdown styling */
    .select-box {
        position: relative;
        color: #374151;
    }
    
    .dropdown-content {
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    /* Custom select styles */
    #transmission, #fuel_type {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
</style>
@endpush 