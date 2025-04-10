{{-- Car Grid Layout - Mobile.bg Style --}}
<style>
    .car-grid {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 12px !important;
    }
    
    .car-item {
        width: 100% !important;
        break-inside: avoid !important;
        position: relative !important;
        height: 220px !important;
        overflow: hidden !important;
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        background-color: #f3f4f6 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: transform 0.2s ease-in-out !important;
    }
    
    .car-item:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
    }
    
    .car-image {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        z-index: 1 !important;
    }
    
    .car-default-image {
        width: 80px !important;
        height: 80px !important;
        opacity: 0.4 !important;
        z-index: 1 !important;
    }
    
    .car-overlay {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.7), transparent) !important;
        color: white !important;
        padding: 15px !important;
        width: 100% !important;
        z-index: 2 !important;
    }
    
    .car-title {
        font-weight: bold !important;
        font-size: 14px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        width: 100% !important;
        display: block !important;
    }
    
    .car-price {
        font-weight: bold !important;
        font-size: 16px !important;
        color: #FFD700 !important;
        margin-top: 4px !important;
    }
    
    .car-details {
        font-size: 12px !important;
        opacity: 0.9 !important;
        margin-top: 4px !important;
        display: flex !important;
        justify-content: space-between !important;
        width: 100% !important;
    }
    
    .car-badge {
        position: absolute !important;
        top: 10px !important;
        left: 10px !important;
        background: #FFD700 !important;
        color: black !important;
        font-weight: bold !important;
        font-size: 12px !important;
        padding: 4px 10px !important;
        border-radius: 4px !important;
        z-index: 10 !important;
    }
    
    @media (max-width: 1280px) {
        .car-grid {
            grid-template-columns: repeat(4, 1fr) !important;
        }
    }
    
    @media (max-width: 1024px) {
        .car-grid {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }
    
    @media (max-width: 768px) {
        .car-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
    
    @media (max-width: 480px) {
        .car-grid {
            grid-template-columns: repeat(1, 1fr) !important;
        }
    }
</style>

<div class="w-full">
    <div class="w-full mx-auto">
        <div class="car-grid">
            @foreach($cars as $car)
            <div class="car-item">
                <a href="{{ route('cars.show', $car) }}" class="block h-full w-full">
                    @if($car->is_featured)
                        <div class="car-badge">BEST</div>
                    @endif
                    
                    @if(strpos($car->mainImage, 'default-car') !== false)
                        <img src="{{ asset($car->mainImage) }}" alt="{{ $car->title }}" class="car-default-image">
                    @else
                        <img src="{{ asset('storage/' . $car->mainImage) }}" alt="{{ $car->title }}" class="car-image">
                    @endif
                    
                    <div class="car-overlay">
                        <div class="car-title">{{ $car->make }} {{ $car->model }}</div>
                        <div class="car-price">{{ $car->formattedPrice }}</div>
                        <div class="car-details">
                            <span>{{ $car->year }} • {{ number_format($car->mileage) }} km • {{ $car->location }}</span>
                            @auth
                                <form action="{{ route('favorites.toggle', $car) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="{{ auth()->user()->favoriteCars->contains($car->id) ? '#ff6b6b' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </form>
                            @endauth
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
<div class="mt-6">
    {{ $cars->links() }}
</div>
@endif 