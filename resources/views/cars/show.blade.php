<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $car->title }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $car)
                    <a href="{{ route('cars.edit', $car) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Edit') }}
                    </a>
                @endcan
                
                @can('delete', $car)
                    <form action="{{ route('cars.destroy', $car) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Delete') }}
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Image Gallery -->
                        <div class="lg:col-span-2">
                            <div class="mb-4">
                                @if($car->images->count() > 0)
                                    <div x-data="{ activeSlide: 0, totalSlides: {{ $car->images->count() }} }">
                                        <!-- Main Image -->
                                        <div class="relative rounded-lg overflow-hidden h-96">
                                            @foreach($car->images as $index => $image)
                                                <div x-show="activeSlide === {{ $index }}" class="absolute inset-0 w-full h-full transition-opacity duration-500">
                                                    @if(strpos($image->image_path, 'default-car') !== false)
                                                        <div class="flex items-center justify-center h-full w-full bg-gray-100">
                                                            <img src="{{ asset($image->image_path) }}" alt="{{ $car->title }}" class="w-1/4 h-1/4 object-contain opacity-40">
                                                        </div>
                                                    @else
                                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $car->title }}" class="w-full h-full object-cover">
                                                    @endif
                                                </div>
                                            @endforeach
                                            
                                            <!-- Navigation arrows -->
                                            <button @click="activeSlide = (activeSlide === 0) ? totalSlides - 1 : activeSlide - 1" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </button>
                                            <button @click="activeSlide = (activeSlide === totalSlides - 1) ? 0 : activeSlide + 1" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Thumbnails -->
                                        <div class="flex space-x-2 mt-2 overflow-x-auto pb-2">
                                            @foreach($car->images as $index => $image)
                                                <button @click="activeSlide = {{ $index }}" class="flex-shrink-0 rounded-md overflow-hidden h-20 w-20 focus:outline-none" :class="{ 'ring-2 ring-indigo-500': activeSlide === {{ $index }} }">
                                                    @if(strpos($image->image_path, 'default-car') !== false)
                                                        <div class="flex items-center justify-center h-full w-full bg-gray-100">
                                                            <img src="{{ asset($image->image_path) }}" alt="{{ $car->title }}" class="w-1/2 h-1/2 object-contain opacity-40">
                                                        </div>
                                                    @else
                                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $car->title }}" class="h-full w-full object-cover">
                                                    @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="rounded-lg overflow-hidden h-80 bg-gray-100 flex items-center justify-center">
                                        <img src="{{ asset('images/default-car.svg') }}" alt="{{ $car->title }}" class="h-1/4 w-1/4 object-contain opacity-40">
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Car Details -->
                            <div class="border-t pt-6">
                                <!-- Price Section -->
                                <div class="mb-8 bg-indigo-50 rounded-lg p-6 shadow-sm">
                                    <h3 class="text-3xl font-bold text-indigo-900">{{ $car->formattedPrice }}</h3>
                                    <p class="text-sm text-indigo-600 mt-1">{{ $car->title }}</p>
                                </div>

                                <!-- Main Details -->
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Main Specifications</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <p class="text-sm font-medium text-gray-500">Make</p>
                                            <p class="text-lg font-semibold text-gray-900">{{ $car->make }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <p class="text-sm font-medium text-gray-500">Model</p>
                                            <p class="text-lg font-semibold text-gray-900">{{ $car->model }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <p class="text-sm font-medium text-gray-500">Year</p>
                                            <p class="text-lg font-semibold text-gray-900">{{ $car->year }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <p class="text-sm font-medium text-gray-500">Mileage</p>
                                            <p class="text-lg font-semibold text-gray-900">{{ number_format($car->mileage) }} km</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <p class="text-sm font-medium text-gray-500">Fuel Type</p>
                                            <p class="text-lg font-semibold text-gray-900">{{ ucfirst($car->fuel_type) }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <p class="text-sm font-medium text-gray-500">Transmission</p>
                                            <p class="text-lg font-semibold text-gray-900">{{ ucfirst($car->transmission) }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Features & Condition -->
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Features & Condition</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                        <!-- Condition Details -->
                                        <div class="col-span-full bg-gray-50 p-4 rounded-lg mb-4">
                                            <p class="text-sm font-medium text-gray-500">Condition</p>
                                            <p class="text-lg font-semibold text-gray-900">{{ ucfirst($car->condition) }}</p>
                                        </div>
                                        
                                        <!-- Features -->
                                        @if($car->has_air_conditioning || $car->has_leather_seats || $car->has_navigation || 
                                            $car->has_parking_sensors || $car->has_parking_camera || $car->has_heated_seats || 
                                            $car->has_bluetooth || $car->has_led_lights)
                                            <div class="col-span-full">
                                                <p class="text-sm font-medium text-gray-500 mb-3">Additional Features</p>
                                                <div class="grid grid-cols-2 gap-4">
                                                    @if($car->has_air_conditioning)
                                                        <div class="flex items-center bg-green-50 p-3 rounded-lg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="text-green-700 font-medium">Air Conditioning</span>
                                                        </div>
                                                    @endif
                                                    @if($car->has_leather_seats)
                                                        <div class="flex items-center bg-green-50 p-3 rounded-lg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="text-green-700 font-medium">Leather Seats</span>
                                                        </div>
                                                    @endif
                                                    @if($car->has_navigation)
                                                        <div class="flex items-center bg-green-50 p-3 rounded-lg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="text-green-700 font-medium">Navigation</span>
                                                        </div>
                                                    @endif
                                                    @if($car->has_parking_sensors)
                                                        <div class="flex items-center bg-green-50 p-3 rounded-lg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="text-green-700 font-medium">Parking Sensors</span>
                                                        </div>
                                                    @endif
                                                    @if($car->has_parking_camera)
                                                        <div class="flex items-center bg-green-50 p-3 rounded-lg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="text-green-700 font-medium">Parking Camera</span>
                                                        </div>
                                                    @endif
                                                    @if($car->has_heated_seats)
                                                        <div class="flex items-center bg-green-50 p-3 rounded-lg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="text-green-700 font-medium">Heated Seats</span>
                                                        </div>
                                                    @endif
                                                    @if($car->has_bluetooth)
                                                        <div class="flex items-center bg-green-50 p-3 rounded-lg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="text-green-700 font-medium">Bluetooth</span>
                                                        </div>
                                                    @endif
                                                    @if($car->has_led_lights)
                                                        <div class="flex items-center bg-green-50 p-3 rounded-lg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="text-green-700 font-medium">LED Lights</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Description -->
                                @if($car->description)
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Description</h4>
                                    <div class="prose max-w-none">
                                        {{ $car->description }}
                                    </div>
                                </div>
                                @endif

                                <!-- Location -->
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Location</h4>
                                    <p class="text-gray-700">{{ $car->location }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Seller Info & Actions -->
                        <div class="lg:col-span-1">
                            <div class="border rounded-lg p-6">
                                <div class="flex justify-between">
                                    <h3 class="text-2xl font-bold text-indigo-600">{{ $car->formattedPrice }}</h3>
                                    @auth
                                        <form action="{{ route('favorites.toggle', $car) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-gray-400 hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ auth()->user()->favoriteCars->contains($car->id) ? 'red' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                                
                                <div class="mt-6">
                                    <h4 class="font-semibold text-gray-700">Seller Information</h4>
                                    <div class="mt-4">
                                        @if($car->user->isDealer() && $car->user->avatar)
                                            <div class="flex items-center mb-4">
                                                <img src="{{ asset('storage/' . $car->user->avatar) }}" alt="{{ $car->user->dealer_name }}" class="h-16 w-16 object-cover rounded-full">
                                            </div>
                                        @endif
                                        
                                        <p class="font-semibold">
                                            @if($car->user->isDealer())
                                                <a href="{{ route('dealers.show', $car->user) }}" class="text-indigo-600 hover:text-indigo-800">
                                                    {{ $car->user->dealer_name }}
                                                </a>
                                            @else
                                                {{ $car->user->name }}
                                            @endif
                                        </p>
                                        
                                        @if($car->user->isDealer() && $car->user->dealer_description)
                                            <p class="mt-2 text-sm text-gray-600">{{ Str::limit($car->user->dealer_description, 100) }}</p>
                                        @endif
                                        
                                        <div class="mt-4">
                                            <p class="text-sm font-semibold">Contact:</p>
                                            @if($car->user->phone)
                                                <a href="tel:{{ $car->user->phone }}" class="mt-1 flex items-center text-indigo-600 hover:text-indigo-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                    {{ $car->user->phone }}
                                                </a>
                                            @endif
                                            
                                            <a href="mailto:{{ $car->user->email }}" class="mt-2 flex items-center text-indigo-600 hover:text-indigo-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                Send Email
                                            </a>
                                            
                                            <!-- Contact Seller Button -->
                                            @auth
                                                @if(auth()->id() !== $car->user_id)
                                                    <div class="mt-4">
                                                        <a href="mailto:{{ $car->user->email }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 inline-flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                            </svg>
                                                            Contact Seller
                                                        </a>
                                                        <p class="text-sm text-gray-500 mt-1">The seller will respond to you via email.</p>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="mt-4">
                                                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Login to contact this seller</a>
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                                
                                @if($car->user->isDealer())
                                    <div class="mt-6 pt-6 border-t">
                                        <a href="{{ route('dealers.show', $car->user) }}" class="block w-full text-center bg-indigo-100 text-indigo-800 py-2 px-4 rounded-md font-medium hover:bg-indigo-200 transition-colors">
                                            View all listings from this dealer
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Modal - TEMPORARILY DISABLED UNTIL MESSAGING FEATURE IS IMPLEMENTED -->
    {{-- Commented with Blade comment to prevent PHP code execution
    <div class="modal fade" id="contactSellerModal" tabindex="-1" aria-labelledby="contactSellerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactSellerModalLabel">Contact Seller about {{ $car->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="contactSellerForm" action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="car_id" value="{{ $car->id }}">
                        <input type="hidden" name="recipient_id" value="{{ $car->user_id }}">
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Your Phone (optional)</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    --}}
</x-app-layout>

@section('scripts')
<script>
    // Initialize the image gallery
    // ... existing code ...
    
    // Contact seller modal functionality disabled until messaging feature is implemented
    /*
    document.getElementById('contactSellerBtn').addEventListener('click', function() {
        var contactModal = new bootstrap.Modal(document.getElementById('contactSellerModal'));
        contactModal.show();
    });
    */
</script>
@endsection 