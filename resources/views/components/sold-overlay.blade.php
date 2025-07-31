@if($car->status === 'sold')
    <div class="absolute inset-0 bg-red-600/80 flex items-center justify-center z-10">
        <div class="text-white text-center">
            <div class="text-4xl font-black mb-2">SOLD</div>
            <div class="text-sm font-medium">This car has been sold</div>
        </div>
    </div>
@endif 