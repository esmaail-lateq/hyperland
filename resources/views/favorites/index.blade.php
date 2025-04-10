@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">My Favorite Cars</h1>
    
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        @if($favoriteCars->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($favoriteCars as $car)
                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <a href="{{ route('cars.show', $car) }}" class="block">
                            <div class="relative h-64">
                                @if($car->is_featured)
                                    <div class="absolute top-2 left-0 bg-yellow-500 text-white text-xs font-bold px-2 py-1 z-10">
                                        BEST
                                    </div>
                                @endif
                                
                                @if(strpos($car->mainImage, 'default-car') !== false)
                                    <div class="flex items-center justify-center h-full w-full bg-gray-100">
                                        <img src="{{ asset($car->mainImage) }}" alt="{{ $car->title }}" class="w-1/4 h-1/4 object-contain opacity-40">
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $car->mainImage) }}" alt="{{ $car->title }}" class="w-full h-full object-cover">
                                @endif
                                
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                    <h3 class="text-white font-bold text-lg">{{ $car->make }} {{ $car->model }}</h3>
                                    <p class="text-yellow-400 font-bold text-xl">{{ $car->formattedPrice }}</p>
                                </div>
                            </div>
                        </a>
                        
                        <div class="p-4 pb-2">
                            <div class="flex justify-between mb-3">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-gray-700">{{ $car->year }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    <span class="text-gray-700">{{ number_format($car->mileage) }} km</span>
                                </div>
                            </div>
                            
                            <div class="flex justify-between mb-3">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <span class="text-gray-600">{{ ucfirst($car->fuel_type) }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-gray-600">{{ ucfirst($car->transmission) }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center mt-1 text-gray-600 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $car->location }}</span>
                            </div>
                        </div>
                        
                        <div class="px-4 py-3 border-t flex justify-between items-center">
                            <div class="text-sm">
                                <span class="text-gray-600">Added by: </span>
                                <span class="font-medium">
                                    @if($car->user->isDealer())
                                        <a href="{{ route('dealers.show', $car->user) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $car->user->dealer_name }}
                                        </a>
                                    @else
                                        {{ $car->user->name }}
                                    @endif
                                </span>
                            </div>
                            
                            <form action="{{ route('favorites.toggle', $car) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $favoriteCars->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <h3 class="mt-2 text-xl font-medium text-gray-900">No favorite cars yet</h3>
                <p class="mt-1 text-gray-500">Browse cars and click the heart icon to add them to your favorites.</p>
                <div class="mt-6">
                    <a href="{{ route('cars.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Browse Cars
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 