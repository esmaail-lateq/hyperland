{{--
    Car Grid Layout - Modernized for HybridLand (Improved Visuals)
    Note: Relying fully on Tailwind CSS classes for better maintainability.
--}}
<div class="w-full">
    <div class="w-full mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"> {{-- Adjusted grid for responsiveness --}}
            @foreach($cars as $car)
            <div class="relative bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 ease-in-out border border-gray-200">
                <a href="{{ route('cars.show', $car) }}" class="block">
                    {{-- Image Container --}}
                    <div class="relative h-48">
                    @if($car->is_featured)
                        <div class="absolute top-3 left-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-gray-900 px-4 py-1 text-sm font-bold rounded-full z-10 shadow-md">BEST</div>
                    @endif
                        
                        @if($car->isNew)
                        <div class="absolute top-3 right-3 bg-green-600 text-white px-4 py-2 text-sm font-bold rounded-full shadow-lg z-10 border-2 border-green-500">
                            جديد
                        </div>
                        @endif
                    
                        {{-- Car Status Badge --}}
                        <div class="absolute top-3 {{ $car->is_featured ? 'right-16' : 'right-3' }} z-10">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-lg {{ $car->status_badge_class }}">
                                {{ $car->status_display }}
                            </span>
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
                                    <div class="text-3xl font-black mb-1 text-red-200">SOLD</div>
                                    <div class="text-xs font-medium text-red-300">This car has been sold</div>
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
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-3 rounded-lg border border-blue-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-2">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-blue-600 font-medium">سنة الصنع</p>
                                            <p class="text-sm font-bold text-gray-900">{{ $car->year }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center mr-2">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-indigo-600 font-medium">المسافة</p>
                                            <p class="text-sm font-bold text-gray-900">{{ number_format($car->mileage) }} كم</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Row 2: Transmission & Fuel --}}
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-3 rounded-lg border border-green-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-2">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-green-600 font-medium">ناقل الحركة</p>
                                            <p class="text-sm font-bold text-gray-900 capitalize">{{ $car->transmission }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center mr-2">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-emerald-600 font-medium">نوع الوقود</p>
                                            <p class="text-sm font-bold text-gray-900 capitalize">{{ $car->fuel_type }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Row 3: Location & Cylinders --}}
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-3 rounded-lg border border-purple-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-2">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-purple-600 font-medium">الموقع</p>
                                            <p class="text-sm font-bold text-gray-900 truncate">{{ $car->location }}</p>
                                        </div>
                                    </div>
                                    @if($car->cylinders)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-pink-500 rounded-lg flex items-center justify-center mr-2">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-pink-600 font-medium">السلندر</p>
                                            <p class="text-sm font-bold text-gray-900">{{ $car->cylinders }}</p>
                                        </div>
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
                                    <p class="text-xs text-indigo-600 font-medium mb-1">السعر</p>
                                    <div class="text-2xl font-black text-indigo-600">{{ $car->formattedPrice }}</div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($car->status === 'sold')
                                        <div class="bg-red-500 text-white px-2 py-1 rounded-full font-bold text-xs shadow-lg border border-red-400">
                                            SOLD
                                        </div>
                                    @endif
                                    <div class="flex items-center bg-yellow-100 px-2 py-1 rounded-lg">
                                        <svg class="w-4 h-4 text-yellow-600 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                        <div>
                                            <p class="text-xs text-yellow-700 font-medium">التقييم</p>
                                            <p class="text-xs font-bold text-yellow-700">4.8</p>
                                        </div>
                                    </div>
                                </div>
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