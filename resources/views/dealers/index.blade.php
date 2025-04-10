<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Car Dealers') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    @if($dealers->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($dealers as $dealer)
                                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                                    <div class="p-6">
                                        <div class="flex items-center mb-4">
                                            <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 text-2xl font-bold mr-4">
                                                @if($dealer->avatar)
                                                    <img src="{{ asset('storage/' . $dealer->avatar) }}" alt="{{ $dealer->name }}" class="h-full w-full object-cover rounded-full">
                                                @else
                                                    {{ strtoupper(substr($dealer->name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold">
                                                    <a href="{{ route('dealers.show', $dealer) }}" class="hover:text-indigo-600">
                                                        {{ $dealer->dealer_name ?? $dealer->name }}
                                                    </a>
                                                </h3>
                                                @if($dealer->dealer_address)
                                                    <p class="text-sm text-gray-600">{{ $dealer->dealer_address }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        @if($dealer->dealer_description)
                                            <p class="text-sm text-gray-600 mb-4">
                                                {{ Str::limit($dealer->dealer_description, 150) }}
                                            </p>
                                        @endif
                                        
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">
                                                {{ $dealer->cars_count }} {{ Str::plural('listing', $dealer->cars_count) }}
                                            </span>
                                            <a href="{{ route('dealers.show', $dealer) }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600">
                                                View Listings
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $dealers->links() }}
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">No dealers found</h3>
                            <p class="mt-1 text-sm text-gray-500">There are currently no car dealers registered.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 