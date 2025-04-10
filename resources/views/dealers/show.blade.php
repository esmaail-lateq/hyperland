<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dealer Profile') }}: {{ $dealer->dealer_name ?? $dealer->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Dealer Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/4 mb-4 md:mb-0">
                            <div class="h-32 w-32 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 text-4xl font-bold mx-auto md:mx-0">
                                @if($dealer->avatar)
                                    <img src="{{ asset('storage/' . $dealer->avatar) }}" alt="{{ $dealer->name }}" class="h-full w-full object-cover rounded-full">
                                @else
                                    {{ strtoupper(substr($dealer->name, 0, 1)) }}
                                @endif
                            </div>
                        </div>
                        <div class="md:w-3/4">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                                {{ $dealer->dealer_name ?? $dealer->name }}
                            </h1>
                            @if($dealer->dealer_address)
                                <p class="text-gray-600 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $dealer->dealer_address }}
                                </p>
                            @endif
                            <p class="text-gray-600 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $dealer->email }}
                            </p>
                            @if($dealer->phone)
                                <p class="text-gray-600 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $dealer->phone }}
                                </p>
                            @endif
                            
                            @if($dealer->dealer_description)
                                <div class="border-t pt-4 mt-4">
                                    <h3 class="text-lg font-semibold mb-2">About the Dealer</h3>
                                    <p class="text-gray-600">
                                        {{ $dealer->dealer_description }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Car Listings -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 w-full">
                    <h2 class="text-xl font-semibold mb-4">Car Listings ({{ $cars->total() }})</h2>
                    
                    @if($cars->count() > 0)
                        @include('cars.grid', ['cars' => $cars])
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">No cars found</h3>
                            <p class="mt-1 text-sm text-gray-500">This dealer doesn't have any active car listings at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 