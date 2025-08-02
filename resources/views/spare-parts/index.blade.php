@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ __('spare_parts.spare_parts') }}</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                {{ __('spare_parts.spare_parts_description') }}
            </p>
        </div>

        <!-- Add Spare Part Button (Admin/Sub-admin only) -->
        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isSubAdmin())
            <div class="text-center mb-8">
                <a href="{{ route('spare-parts.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    {{ __('spare_parts.add_spare_part') }}
                </a>
            </div>
            @endif
        @endauth

        <!-- Spare Parts Grid -->
        @if($spareParts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
            @foreach($spareParts as $sparePart)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                <!-- Image -->
                <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                    <img src="{{ $sparePart->first_image_url }}" 
                         alt="{{ $sparePart->name }}" 
                         class="w-full h-48 object-cover">
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                        {{ $sparePart->name }}
                    </h3>
                    
                    @if($sparePart->description)
                    <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                        {{ $sparePart->description }}
                    </p>
                    @endif
                    
                    <!-- Creator Info -->
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                        <span>{{ __('spare_parts.by') }}: {{ $sparePart->creator->name ?? __('spare_parts.not_specified') }}</span>
                        <span>{{ $sparePart->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <!-- Action Button -->
                    <a href="{{ route('spare-parts.show', $sparePart) }}" 
                       class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200">
                        {{ __('spare_parts.view_details') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $spareParts->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('spare_parts.no_spare_parts_available') }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ __('spare_parts.no_spare_parts_description') }}</p>
            @auth
                @if(auth()->user()->isAdmin() || auth()->user()->isSubAdmin())
                <div class="mt-6">
                    <a href="{{ route('spare-parts.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                        {{ __('spare_parts.add_spare_part_button') }}
                    </a>
                </div>
                @endif
            @endauth
        </div>
        @endif

        <!-- Request Custom Spare Part Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-12">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('spare_parts.custom_spare_part_request') }}</h2>
                <p class="text-gray-600">
                    {{ __('spare_parts.custom_request_description') }}
                </p>
            </div>

            @auth
            <form action="{{ route('spare-parts.request-custom') }}" method="POST" class="max-w-2xl mx-auto">
                @csrf
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('spare_parts.custom_request_label') }}
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="{{ __('spare_parts.custom_request_placeholder') }}"
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="text-center">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        {{ __('spare_parts.send_request') }}
                    </button>
                </div>
            </form>
            @else
            <div class="text-center">
                <p class="text-gray-600 mb-4">{{ __('spare_parts.login_to_request') }}</p>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    {{ __('spare_parts.login') }}
                </a>
            </div>
            @endauth
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 