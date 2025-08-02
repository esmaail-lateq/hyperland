@if($car->status === 'sold')
    <div class="absolute inset-0 bg-red-600/80 flex items-center justify-center z-10">
        <div class="text-white text-center">
                <div class="text-4xl font-black mb-2">{{ __('components.sold') }}</div>
    <div class="text-sm font-medium">{{ __('components.this_car_has_been_sold') }}</div>
        </div>
    </div>
@endif 