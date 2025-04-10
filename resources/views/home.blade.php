<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 h-[500px]">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
            <img src="{{ asset('storage/images/hero.jpg') }}" alt="Hero background" class="w-full h-full object-cover">
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="max-w-3xl">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    Find Your Perfect Car at AutoMarket
                </h1>
                <p class="text-lg text-white/90 mb-8 leading-relaxed">
                    Welcome to AutoMarket, a modern car marketplace platform. Browse through our extensive collection of vehicles and experience seamless car shopping.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('cars.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 transition-colors duration-150">
                        Browse Cars
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ route('cars.create') }}" class="inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-blue-600 transition-colors duration-150">
                        Post Your Car
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Cars Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Cars</h2>
                <p class="text-lg text-gray-600">Discover our handpicked selection of premium vehicles</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($featuredCars as $car)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <a href="{{ route('cars.show', $car) }}">
                            <div class="relative h-56">
                                @if($car->images->isNotEmpty())
                                    <img src="{{ Storage::url($car->images->first()->image_path) }}" 
                                         alt="{{ $car->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-blue-500 text-white px-3 py-1 text-sm font-semibold rounded-full">
                                    Featured
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $car->title }}</h3>
                                <div class="flex items-center text-gray-600 mb-3">
                                    <span class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $car->year }}
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        {{ number_format($car->mileage) }} km
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-bold text-blue-600">{{ $car->formattedPrice }}</span>
                                    <span class="text-sm text-gray-500 capitalize">{{ $car->transmission }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Latest Cars Grid -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Latest Listings</h2>
                <p class="text-lg text-gray-600">Check out the most recent additions to our marketplace</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($latestCars as $car)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ route('cars.show', $car) }}">
                            <div class="relative h-48">
                                @if($car->images->isNotEmpty())
                                    <img src="{{ Storage::url($car->images->first()->image_path) }}" 
                                         alt="{{ $car->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                @if($car->is_featured)
                                    <div class="absolute top-2 right-2 bg-blue-500 text-white px-2 py-1 text-sm rounded">
                                        Featured
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $car->title }}</h3>
                                <div class="flex items-center text-gray-600 mb-2">
                                    <span>{{ $car->year }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ number_format($car->mileage) }} km</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ ucfirst($car->transmission) }}</span>
                                </div>
                                <div class="text-xl font-bold text-blue-600">
                                    {{ $car->formattedPrice }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('cars.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-150">
                    View All Cars
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">About AutoMarket</h2>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-3xl">
                    AutoMarket is a portfolio project demonstrating modern web development practices. Built with Laravel, 
                    Vue.js, and Tailwind CSS, it showcases a fully functional car marketplace platform.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-3xl">
                    <div class="flex flex-col items-center p-6 bg-white rounded-lg shadow-sm">
                        <svg class="h-8 w-8 text-blue-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-gray-600">Modern and responsive design</span>
                    </div>
                    <div class="flex flex-col items-center p-6 bg-white rounded-lg shadow-sm">
                        <svg class="h-8 w-8 text-blue-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-gray-600">Advanced search and filtering</span>
                    </div>
                    <div class="flex flex-col items-center p-6 bg-white rounded-lg shadow-sm">
                        <svg class="h-8 w-8 text-blue-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-gray-600">User authentication and profiles</span>
                    </div>
                </div>
                <div class="mt-8 bg-blue-500 text-white px-8 py-4 rounded-lg shadow-lg">
                    <div class="text-4xl font-bold mb-1">100+</div>
                    <div class="text-sm">Cars Listed</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Any additional JavaScript for animations can go here
    </script>
    @endpush
</x-app-layout> 