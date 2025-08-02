{{--
    Car Grid Layout - Modernized for HybridLand (Improved Visuals)
    Note: Relying fully on Tailwind CSS classes for better maintainability.
--}}
<div class="w-full">
    <div class="w-full mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"> {{-- Adjusted grid for responsiveness --}}
            @foreach($cars as $car)
            <div class="relative bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 ease-in-out border border-gray-200">
                {{-- New Badge (top-right corner of card) --}}
                @if($car->isNew)
                    <div class="absolute top-2 right-2 bg-gray-200 text-gray-800 px-2 py-1 text-xs font-bold rounded-md shadow-sm z-10">
                        جديد
                    </div>
                @endif
                
                <a href="{{ route('cars.show', $car) }}" class="block">
                    {{-- Image Container --}}
                    <div class="relative h-48">
                        {{-- Featured Badge (keep on image) --}}
                        <div class="absolute top-3 left-3 z-20">
                            @if($car->is_featured)
                                <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-gray-900 px-4 py-1 text-sm font-bold rounded-full shadow-md">{{ __('cars.best_badge') }}</div>
                            @endif
                        </div>
                    
                    @php
                        // تحقق أولاً مما إذا كانت خاصية 'imageUrl' موجودة (إذا كانت البيانات قادمة من AJAX)
                        // وإلا، ابحث عن الصورة في علاقة 'images'
                        $imageUrl = $car->imageUrl ?? null;
                        if (!$imageUrl && $car->images->isNotEmpty()) {
                            $primaryImage = $car->images->where('is_primary', true)->first() ?? $car->images->first();
                            if ($primaryImage) {
                                $imageUrl = Storage::url($primaryImage->image_path);
                            }
                        }
                        // إذا لم يتم العثور على أي صورة، استخدم الصورة الافتراضية
                        if (!$imageUrl) {
                            $imageUrl = asset('images/default_car.jpg'); // تأكد من وجود هذه الصورة في public/images
                        }
                    @endphp

                        <img src="{{ $imageUrl }}" alt="{{ $car->title }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        
                        {{-- Sold Overlay --}}
                        @if($car->status === 'sold')
                            <div class="absolute inset-0 bg-red-600/90 flex items-center justify-center z-10">
                                <div class="text-white text-center">
                                    <div class="text-3xl font-black mb-1 text-red-200">{{ __('cars.sold_badge') }}</div>
                                    <div class="text-xs font-medium text-red-300">{{ __('cars.sold_message') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Content Section --}}
                    <div class="p-4">
                        {{-- Ad Number --}}
                        <div class="text-xs text-gray-600 mb-3 font-mono bg-gray-100 px-3 py-2 rounded-lg inline-block border border-gray-200">
                            <span class="font-semibold">رقم الإعلان:</span> {{ $car->adNumber }}
                        </div>
                        
                        {{-- Status Label --}}
                        <div class="flex flex-wrap gap-2 mb-4">
                            <div class="px-3 py-1 text-xs font-semibold rounded-full shadow-sm {{ $car->status_badge_class }}">
                                {{ $car->status_display }}
                            </div>
                        </div>
                        
                        {{-- Title and Favorite --}}
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-300 leading-relaxed flex-1 pr-3">{{ $car->make }} {{ $car->model }}</h3>
                            @auth
                                <form action="{{ route('favorites.toggle', $car) }}" method="POST" class="flex-shrink-0">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="{{ auth()->user()->favoriteCars->contains($car->id) ? 'red' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </form>
                            @endauth
                        </div>
                        
                        {{-- Car Details - Clean Layout --}}
                        <div class="space-y-3 mb-4">
                            {{-- Row 1: Year & Mileage --}}
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-100">
                                <div class="flex items-center justify-between">
                                    <div class="text-center">
                                        <p class="text-xs text-blue-600 font-medium mb-1">{{ __('cars.car_year') }}</p>
                                        <p class="text-sm font-bold text-gray-900">{{ $car->year }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs text-indigo-600 font-medium mb-1">{{ __('cars.car_mileage') }}</p>
                                        <p class="text-sm font-bold text-gray-900">{{ number_format($car->mileage) }} كم</p>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Row 2: Transmission & Fuel --}}
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-lg border border-green-100">
                                <div class="flex items-center justify-between">
                                    <div class="text-center">
                                        <p class="text-xs text-green-600 font-medium mb-1">{{ __('cars.car_transmission') }}</p>
                                        <p class="text-sm font-bold text-gray-900 capitalize">{{ $car->transmission }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs text-emerald-600 font-medium mb-1">{{ __('cars.car_fuel_type') }}</p>
                                        <p class="text-sm font-bold text-gray-900 capitalize">{{ $car->fuel_type }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Row 3: Location & Cylinders --}}
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-lg border border-purple-100">
                                <div class="flex items-center justify-between">
                                    <div class="text-center">
                                        <p class="text-xs text-purple-600 font-medium mb-1">{{ __('cars.car_location') }}</p>
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $car->location }}</p>
                                    </div>
                                    @if($car->cylinders)
                                    <div class="text-center">
                                        <p class="text-xs text-pink-600 font-medium mb-1">{{ __('cars.car_cylinders') }}</p>
                                        <p class="text-sm font-bold text-gray-900">{{ $car->cylinders }}</p>
                                    </div>
                                    @else
                                    <div></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Price --}}
                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-3 rounded-lg border border-indigo-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-indigo-600 font-medium mb-1">{{ __('cars.car_price') }}</p>
                                    <div class="text-2xl font-black text-indigo-600">{{ $car->formattedPrice }}</div>
                                </div>
                                @if($car->status === 'sold')
                                    <div class="bg-red-500 text-white px-2 py-1 rounded-full font-bold text-xs shadow-lg border border-red-400">
                                        {{ __('cars.sold_badge') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Pagination --}}
@if(isset($cars) && method_exists($cars, 'links'))
<div class="mt-8 flex justify-center">
    {{ $cars->links() }}
</div>
@endif