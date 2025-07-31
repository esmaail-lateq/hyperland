@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-extrabold mb-10 text-gray-900 text-center leading-tight">Find Your Perfect Car Here</h1>
    
    <div class="bg-white rounded-xl shadow-2xl p-6 md:p-8 mb-10 border-t-4 border-blue-600">
        <form action="{{ route('cars.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
            <div class="search-field">
                <label for="make" class="block text-sm font-bold text-gray-800 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Car Make
                </label>
                <div class="relative">
                    <select id="make" name="make" class="block w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800 appearance-none shadow-sm">
                        <option value="All Cars">All Cars</option>
                        @foreach($makes as $make)
                            <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                        <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            
            <div class="search-field">
                <label for="min_price" class="block text-sm font-bold text-gray-800 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Min Price (€)
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-lg">€</span>
                    <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" class="block w-full p-3 pl-9 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800 shadow-sm" placeholder="e.g., 5000">
                </div>
            </div>
            
            <div class="search-field">
                <label for="max_price" class="block text-sm font-bold text-gray-800 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Max Price (€)
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-lg">€</span>
                    <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" class="block w-full p-3 pl-9 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800 shadow-sm" placeholder="e.g., 50000">
                </div>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3.5 px-6 rounded-lg font-bold hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    SEARCH CARS
                </button>
            </div>
            
            <div class="md:col-span-2 lg:col-span-4 mt-2 text-center">
                <button id="advancedSearchBtn" type="button" class="text-blue-600 hover:text-blue-800 font-bold flex items-center justify-center mx-auto group transition-all text-base focus:outline-none">
                    <span class="text-base">Advanced Search Options</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:ml-3 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <div id="advancedSearchOptions" class="hidden grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t-2 border-gray-200">
                    <div class="search-field">
                        <label for="status" class="block text-sm font-bold text-gray-800 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Status
                        </label>
                        <select id="status" name="status" class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800 shadow-sm">
                            <option value="">All Status</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Available</option>
                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <label for="min_year" class="block text-sm font-bold text-gray-800 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Min Year
                        </label>
                        <input type="number" id="min_year" name="min_year" value="{{ request('min_year') }}" class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800 shadow-sm" placeholder="e.g., 2010">
                    </div>

                    <div class="search-field">
                        <label for="max_year" class="block text-sm font-bold text-gray-800 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Max Year
                        </label>
                        <input type="number" id="max_year" name="max_year" value="{{ request('max_year') }}" class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800 shadow-sm" placeholder="e.g., 2023">
                    </div>
                    
                    <div class="search-field">
                        <label for="transmission" class="block text-sm font-bold text-gray-800 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Transmission
                        </label>
                        <div class="relative">
                            <select id="transmission" name="transmission" class="block w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800 appearance-none shadow-sm">
                                <option value="">Any Transmission</option>
                                <option value="automatic" {{ request('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="semi-automatic" {{ request('transmission') == 'semi-automatic' ? 'selected' : '' }}>Semi-Automatic</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="search-field">
                        <label for="fuel_type" class="block text-sm font-bold text-gray-800 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Fuel Type
                        </label>
                        <div class="relative">
                            <select id="fuel_type" name="fuel_type" class="block w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800 appearance-none shadow-sm">
                                <option value="">Any Fuel Type</option>
                                <option value="gasoline" {{ request('fuel_type') == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="lpg" {{ request('fuel_type') == 'lpg' ? 'selected' : '' }}>LPG</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="search-field">
                        <label for="condition" class="block text-sm font-bold text-gray-800 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Condition
                        </label>
                        <div class="relative">
                            <select id="condition" name="condition" class="block w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800 appearance-none shadow-sm">
                                <option value="">Any Condition</option>
                                <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="search-field">
                        <label for="cylinders" class="block text-sm font-bold text-gray-800 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Cylinders
                        </label>
                        <div class="relative">
                            <select id="cylinders" name="cylinders" class="block w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800 appearance-none shadow-sm">
                                <option value="">Any Cylinders</option>
                                <option value="3" {{ request('cylinders') == '3' ? 'selected' : '' }}>3 Cylinders</option>
                                <option value="4" {{ request('cylinders') == '4' ? 'selected' : '' }}>4 Cylinders</option>
                                <option value="6" {{ request('cylinders') == '6' ? 'selected' : '' }}>6 Cylinders</option>
                                <option value="8" {{ request('cylinders') == '8' ? 'selected' : '' }}>8 Cylinders</option>
                                <option value="10" {{ request('cylinders') == '10' ? 'selected' : '' }}>10 Cylinders</option>
                                <option value="12" {{ request('cylinders') == '12' ? 'selected' : '' }}>12 Cylinders</option>
                                <option value="16" {{ request('cylinders') == '16' ? 'selected' : '' }}>16 Cylinders</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-full mt-4">
                        <p class="text-base font-bold text-gray-800 mb-3 border-b pb-2">Additional Features</p>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="inline-flex items-center text-gray-700 hover:text-blue-700 transition-colors cursor-pointer group">
                                <input type="checkbox" name="has_air_conditioning" value="1" {{ request('has_air_conditioning') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium group-hover:text-blue-700">Air Conditioning</span>
                            </label>
                            <label class="inline-flex items-center text-gray-700 hover:text-blue-700 transition-colors cursor-pointer group">
                                <input type="checkbox" name="has_leather_seats" value="1" {{ request('has_leather_seats') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium group-hover:text-blue-700">Leather Seats</span>
                            </label>
                            <label class="inline-flex items-center text-gray-700 hover:text-blue-700 transition-colors cursor-pointer group">
                                <input type="checkbox" name="has_navigation" value="1" {{ request('has_navigation') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium group-hover:text-blue-700">Navigation</span>
                            </label>
                            <label class="inline-flex items-center text-gray-700 hover:text-blue-700 transition-colors cursor-pointer group">
                                <input type="checkbox" name="has_parking_sensors" value="1" {{ request('has_parking_sensors') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium group-hover:text-blue-700">Parking Sensors</span>
                            </label>
                            <label class="inline-flex items-center text-gray-700 hover:text-blue-700 transition-colors cursor-pointer group">
                                <input type="checkbox" name="has_parking_camera" value="1" {{ request('has_parking_camera') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium group-hover:text-blue-700">Parking Camera</span>
                            </label>
                            <label class="inline-flex items-center text-gray-700 hover:text-blue-700 transition-colors cursor-pointer group">
                                <input type="checkbox" name="has_heated_seats" value="1" {{ request('has_heated_seats') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium">Heated Seats</span>
                            </label>
                            <label class="inline-flex items-center text-gray-700 hover:text-blue-700 transition-colors cursor-pointer group">
                                <input type="checkbox" name="has_bluetooth" value="1" {{ request('has_bluetooth') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium group-hover:text-blue-700">Bluetooth</span>
                            </label>
                            <label class="inline-flex items-center text-gray-700 hover:text-blue-700 transition-colors cursor-pointer group">
                                <input type="checkbox" name="has_led_lights" value="1" {{ request('has_led_lights') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium group-hover:text-blue-700">LED Lights</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    {{-- Status Information --}}
    <div class="mb-6 bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 w-full sm:w-auto">
                <div class="flex items-center bg-green-50 px-3 py-2 rounded-lg">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                    <div class="text-sm">
                        <div class="font-bold text-green-800">{{ $cars->where('status', 'approved')->count() }}</div>
                        <div class="text-green-600">Available</div>
                    </div>
                </div>
                <div class="flex items-center bg-purple-50 px-3 py-2 rounded-lg">
                    <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                    <div class="text-sm">
                        <div class="font-bold text-purple-800">{{ $cars->where('status', 'sold')->count() }}</div>
                        <div class="text-purple-600">Sold</div>
                    </div>
                </div>
                <div class="flex items-center bg-yellow-50 px-3 py-2 rounded-lg">
                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                    <div class="text-sm">
                        <div class="font-bold text-yellow-800">{{ $cars->where('status', 'pending')->count() }}</div>
                        <div class="text-yellow-600">Pending</div>
                    </div>
                </div>
                <div class="flex items-center bg-blue-50 px-3 py-2 rounded-lg">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                    <div class="text-sm">
                        <div class="font-bold text-blue-800">{{ $cars->whereNotNull('cylinders')->count() }}</div>
                        <div class="text-blue-600">With Cylinders</div>
                    </div>
                </div>
            </div>
            <div class="text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded-lg">
                Total: <span class="font-bold text-gray-700">{{ $cars->total() }}</span> cars
            </div>
        </div>
    </div>
    
    <div id="cars-list">
        @include('cars.grid', ['cars' => $cars])
    </div>
    
    <noscript>
        @include('cars.grid', ['cars' => $cars])
    </noscript>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Advanced search toggle
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
            }

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
    /* No custom styles needed, relying fully on Tailwind CSS */
</style>
@endpush
