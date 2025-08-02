<x-app-layout>
    <x-slot name="header">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 sm:p-6 rounded-xl shadow-lg border-t-4 border-blue-600">
                <h2 class="font-extrabold text-3xl md:text-4xl text-gray-900 leading-tight mb-4 sm:mb-0 text-center sm:text-left">
                    {{ $car->title }}
                </h2>
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                    @can('update', $car)
                        <a href="{{ route('cars.edit', $car) }}" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-200 shadow-md hover:shadow-lg transform hover:scale-105 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-6 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            {{ __('Edit Listing') }}
                        </a>
                    @endcan
                    
                    @can('delete', $car)
                        <form action="{{ route('cars.destroy', $car) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this listing permanently? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-200 shadow-md hover:shadow-lg transform hover:scale-105 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:shake-x transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1H9a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                {{ __('Delete Listing') }}
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-blue-600">
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2">
                            {{-- Image Carousel Section --}}
                            <div class="mb-8">
                                @if($car->images->count() > 0)
                                    <div x-data="{ activeSlide: 0, totalSlides: {{ $car->images->count() }}, init() { setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.totalSlides; }, 5000); } }">
                                        <div class="relative rounded-xl overflow-hidden h-96 lg:h-[500px] shadow-lg mb-4 border-2 border-gray-200">
                                            {{-- Sold Overlay --}}
                                            @if($car->status === 'sold')
                                                <div class="absolute inset-0 bg-red-700/90 flex items-center justify-center z-20">
                                                    <div class="text-white text-center">
                                                                                            <div class="text-6xl font-black mb-4 text-red-100">{{ __('components.sold') }}</div>
                                    <div class="text-xl font-medium text-red-200">{{ __('components.this_car_has_been_sold') }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @foreach($car->images as $index => $image)
                                                <div x-show="activeSlide === {{ $index }}" 
                                                     x-transition:enter="transition ease-out duration-700" 
                                                     x-transition:enter-start="opacity-0 transform scale-95" 
                                                     x-transition:enter-end="opacity-100 transform scale-100" 
                                                     x-transition:leave="transition ease-in duration-500" 
                                                     x-transition:leave-start="opacity-100 transform scale-100" 
                                                     x-transition:leave-end="opacity-0 transform scale-95"
                                                     class="absolute inset-0 w-full h-full">
                                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $car->title }}" class="w-full h-full object-cover">
                                                </div>
                                            @endforeach
                                            
                                            <button @click="activeSlide = (activeSlide === 0) ? totalSlides - 1 : activeSlide - 1" 
                                                    class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-900 bg-opacity-50 text-white p-3 rounded-full focus:outline-none hover:bg-opacity-70 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </button>
                                            <button @click="activeSlide = (activeSlide === totalSlides - 1) ? 0 : activeSlide + 1" 
                                                    class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-900 bg-opacity-50 text-white p-3 rounded-full focus:outline-none hover:bg-opacity-70 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </button>
                                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                                @foreach($car->images as $index => $image)
                                                    <button @click="activeSlide = {{ $index }}" 
                                                            class="h-2 w-2 rounded-full bg-white opacity-60 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                                                            :class="{ 'opacity-100 scale-150 bg-blue-500': activeSlide === {{ $index }} }"></button>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        <div class="flex space-x-3 mt-4 overflow-x-auto pb-2 custom-scrollbar">
                                            @foreach($car->images as $index => $image)
                                                <button @click="activeSlide = {{ $index }}" 
                                                        class="flex-shrink-0 rounded-lg overflow-hidden h-24 w-32 border-2 focus:outline-none transition-all duration-200" 
                                                        :class="{ 'border-blue-600 ring-2 ring-blue-400': activeSlide === {{ $index }}, 'border-gray-300 hover:border-blue-400': activeSlide !== {{ $index }} }">
                                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $car->title }}" class="h-full w-full object-cover">
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="rounded-xl overflow-hidden h-96 lg:h-[500px] bg-gray-200 flex items-center justify-center shadow-md border border-gray-300">
                                        <img src="{{ asset('images/default_car.jpg') }}" alt="{{ $car->title }}" class="h-1/3 w-1/3 object-contain opacity-50">
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Price & Title Box --}}
                            <div class="mb-8 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl p-6 shadow-md relative">
                                <div class="flex items-center justify-between">
                                    <div>
                                <h3 class="text-4xl md:text-5xl font-extrabold mb-2 text-yellow-300">{{ $car->formattedPrice }}</h3>
                                <p class="text-xl md:text-2xl opacity-95 font-semibold">{{ $car->title }}</p>
                                    </div>
                                    @if($car->status === 'sold')
                                        <div class="bg-red-500 text-white px-4 py-2 rounded-full font-bold text-lg shadow-lg border-2 border-red-400">
                                            SOLD
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Key Specifications Section --}}
                            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-8">
                                <h4 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">{{ __('cars.key_specifications') }}</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl flex items-center shadow-sm border border-blue-200 hover:bg-blue-200 transition-colors duration-200">
                                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-blue-600">{{ __('cars.make') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $car->make }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-5 rounded-xl flex items-center shadow-sm border border-green-200 hover:bg-green-200 transition-colors duration-200">
                                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6m-9-11H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.5a1.5 1.5 0 01-1.5-1.5V3a1.5 1.5 0 00-1.5-1.5H9.75a1.5 1.5 0 00-1.5 1.5v2.25z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-green-600">{{ __('cars.model') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $car->model }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-5 rounded-xl flex items-center shadow-sm border border-purple-200 hover:bg-purple-200 transition-colors duration-200">
                                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-purple-600">{{ __('cars.year') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $car->year }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-5 rounded-xl flex items-center shadow-sm border border-orange-200 hover:bg-orange-200 transition-colors duration-200">
                                        <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M3 19l12 3V6L3 3v13z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-orange-600">{{ __('cars.mileage') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ number_format($car->mileage) }} km</p>
                                        </div>
                                    </div>
                                    <div class="bg-gradient-to-br from-red-50 to-red-100 p-5 rounded-xl flex items-center shadow-sm border border-red-200 hover:bg-red-200 transition-colors duration-200">
                                        <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-red-600">{{ __('cars.fuel_type') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ ucfirst($car->fuel_type) }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-5 rounded-xl flex items-center shadow-sm border border-indigo-200 hover:bg-indigo-200 transition-colors duration-200">
                                        <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-indigo-600">{{ __('cars.transmission') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ ucfirst($car->transmission) }}</p>
                                        </div>
                                    </div>
                                    @if($car->cylinders)
                                    <div class="bg-gradient-to-br from-teal-50 to-teal-100 p-5 rounded-xl flex items-center shadow-sm border border-teal-200 hover:bg-teal-200 transition-colors duration-200">
                                        <div class="w-12 h-12 bg-teal-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-teal-600">{{ __('cars.cylinders') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $car->cylinders }} Cylinders</p>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="bg-gradient-to-br {{ $car->status === 'sold' ? 'from-red-50 to-red-100 border-red-200' : ($car->status === 'approved' ? 'from-green-50 to-green-100 border-green-200' : 'from-yellow-50 to-yellow-100 border-yellow-200') }} p-5 rounded-xl flex items-center shadow-sm border hover:{{ $car->status === 'sold' ? 'bg-red-200' : ($car->status === 'approved' ? 'bg-green-200' : 'bg-yellow-200') }} transition-colors duration-200">
                                        <div class="w-12 h-12 {{ $car->status === 'sold' ? 'bg-red-500' : ($car->status === 'approved' ? 'bg-green-500' : 'bg-yellow-500') }} rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium {{ $car->status === 'sold' ? 'text-red-600' : ($car->status === 'approved' ? 'text-green-600' : 'text-yellow-600') }}">{{ __('cars.status') }}</p>
                                            <p class="text-lg font-bold {{ $car->status === 'sold' ? 'text-red-600' : ($car->status === 'approved' ? 'text-green-600' : 'text-yellow-600') }}">{{ ucfirst($car->status) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Features & Condition Section --}}
                            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-8">
                                <h4 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">Features & Condition</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                                    <div class="bg-gray-50 p-4 rounded-lg flex items-center shadow-sm border border-gray-100 hover:bg-gray-100 transition-colors duration-200">
                                        <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">{{ __('cars.condition') }}</p>
                                            <p class="text-base font-semibold text-gray-900">{{ ucfirst($car->condition) }}</p>
                                        </div>
                                        </div>
                                    </div>
                                    
                                    @if($car->has_air_conditioning || $car->has_leather_seats || $car->has_navigation || 
                                        $car->has_parking_sensors || $car->has_parking_camera || $car->has_heated_seats || 
                                        $car->has_bluetooth || $car->has_led_lights)
                                    <div class="mt-6">
                                            <p class="text-lg font-bold text-gray-800 mb-4">{{ __('cars.additional_features') }}</p>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                                                @if($car->has_air_conditioning)
                                                    <div class="flex items-center bg-blue-50 px-4 py-3 rounded-lg shadow-sm border border-blue-100 group hover:bg-blue-100 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-blue-800 font-medium text-sm">{{ __('cars.air_conditioning') }}</span>
                                                    </div>
                                                @endif
                                                @if($car->has_leather_seats)
                                                    <div class="flex items-center bg-blue-50 px-4 py-3 rounded-lg shadow-sm border border-blue-100 group hover:bg-blue-100 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-blue-800 font-medium text-sm">{{ __('cars.leather_seats') }}</span>
                                                    </div>
                                                @endif
                                                @if($car->has_navigation)
                                                    <div class="flex items-center bg-blue-50 px-4 py-3 rounded-lg shadow-sm border border-blue-100 group hover:bg-blue-100 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-blue-800 font-medium text-sm">{{ __('cars.navigation') }}</span>
                                                    </div>
                                                @endif
                                                @if($car->has_parking_sensors)
                                                    <div class="flex items-center bg-blue-50 px-4 py-3 rounded-lg shadow-sm border border-blue-100 group hover:bg-blue-100 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-blue-800 font-medium text-sm">{{ __('cars.parking_sensors') }}</span>
                                                    </div>
                                                @endif
                                                @if($car->has_parking_camera)
                                                    <div class="flex items-center bg-blue-50 px-4 py-3 rounded-lg shadow-sm border border-blue-100 group hover:bg-blue-100 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-blue-800 font-medium text-sm">{{ __('cars.parking_camera') }}</span>
                                                    </div>
                                                @endif
                                                @if($car->has_heated_seats)
                                                    <div class="flex items-center bg-blue-50 px-4 py-3 rounded-lg shadow-sm border border-blue-100 group hover:bg-blue-100 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-blue-800 font-medium text-sm">{{ __('cars.heated_seats') }}</span>
                                                    </div>
                                                @endif
                                                @if($car->has_bluetooth)
                                                    <div class="flex items-center bg-blue-50 px-4 py-3 rounded-lg shadow-sm border border-blue-100 group hover:bg-blue-100 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-blue-800 font-medium text-sm">{{ __('cars.bluetooth') }}</span>
                                                    </div>
                                                @endif
                                                @if($car->has_led_lights)
                                                    <div class="flex items-center bg-blue-50 px-4 py-3 rounded-lg shadow-sm border border-blue-100 group hover:bg-blue-100 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-blue-800 font-medium text-sm">{{ __('cars.led_lights') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                            </div>
                            
                            {{-- Description Section --}}
                            @if($car->description)
                            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-8">
                                <h4 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">{{ __('common.description') }}</h4>
                                <div class="prose max-w-none text-gray-700 leading-relaxed">
                                    {{ $car->description }}
                                </div>
                            </div>
                            @endif

                            {{-- Location Section --}}
                            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                                <h4 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">{{ __('cars.car_location') }}</h4>
                                <p class="text-gray-700 flex items-center">
                                    <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $car->location }}
                                </p>
                            </div>
                        </div>
                        
                        {{-- Seller Information Section --}}
                        <div class="lg:col-span-1">
                            <div class="border border-gray-200 rounded-xl p-6 shadow-md bg-white sticky top-8">
                                <div class="flex justify-between items-start mb-4 border-b pb-4 border-gray-200">
                                    <h3 class="text-3xl font-extrabold text-blue-700">{{ $car->formattedPrice }}</h3>
                                    @auth
                                        <form action="{{ route('favorites.toggle', $car) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="{{ auth()->user()->favoriteCars->contains($car->id) ? '#ef4444' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                                
                                <div class="mt-4 border-t pt-4 border-gray-200">
                                    <h4 class="font-bold text-gray-900 text-xl mb-4">{{ __('cars.seller_information') }}</h4>
                                    <div class="mt-3 flex items-center mb-4">
                                        @if($car->user->avatar)
                                            <img src="{{ asset('storage/' . $car->user->avatar) }}" alt="{{ $car->user->name }}" class="h-16 w-16 object-cover rounded-full border-2 border-blue-400 mr-4 shadow-md">
                                        @else
                                            <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold mr-4 shadow-md">
                                                {{ substr($car->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        
                                        <div>
                                            <p class="font-bold text-lg text-gray-900">
                                                {{ $car->user->name }}
                                            </p>
                                        </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 border-t pt-4 border-gray-200">
                                        <p class="text-lg font-bold text-gray-900 mb-3">Contact Details:</p>
                                        @if($car->user->phone)
                                            <a href="tel:{{ $car->user->phone }}" class="mt-2 flex items-center text-blue-600 hover:text-blue-800 transition-colors text-base font-semibold">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                {{ $car->user->phone }}
                                            </a>
                                        @endif
                                        
                                        <a href="mailto:{{ $car->user->email }}" class="mt-2 flex items-center text-blue-600 hover:text-blue-800 transition-colors text-base font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Send Email
                                        </a>
                                        
                                        @auth
                                            @if(auth()->id() !== $car->user_id)
                                                <div class="mt-6">
                                                    <a href="mailto:{{ $car->user->email }}" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 inline-flex items-center justify-center font-bold shadow-md hover:shadow-lg transition-all duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        Contact Seller
                                                    </a>
                                                    <p class="text-xs text-gray-500 mt-2 text-center">The seller will respond to you via email.</p>
                                                </div>
                                            @endif
                                        @else
                                            <div class="mt-6">
                                                <a href="{{ route('login') }}" class="block w-full text-center text-blue-600 hover:text-blue-800 font-semibold text-sm transition-colors">{{ __('cars.login_to_contact_seller') }}</a>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <style>
        /* Custom scrollbar for thumbnail navigation */
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
            border: 2px solid #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Custom shake-x animation for delete button */
        @keyframes shakeX {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .group:hover .group-hover\:shake-x {
            animation: shakeX 0.8s cubic-bezier(.36,.07,.19,.97) both;
        }
    </style>
    @endpush
</x-app-layout>