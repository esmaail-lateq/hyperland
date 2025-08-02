@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('spare-parts.index') }}" class="text-gray-700 hover:text-blue-600">
                        {{ __('spare_parts.spare_parts') }}
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-500">{{ $sparePart->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $sparePart->name }}</h1>
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span>{{ __('spare_parts.by') }}: {{ $sparePart->creator->name ?? __('spare_parts.not_specified') }}</span>
                            <span>{{ $sparePart->created_at->format('d/m/Y') }}</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $sparePart->approval_status_badge_class }}">
                                {{ $sparePart->approval_status_display }}
                            </span>
                        </div>
                    </div>
                    
                    @can('update', $sparePart)
                    <div class="flex space-x-2">
                        <a href="{{ route('spare-parts.edit', $sparePart) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            {{ __('spare_parts.edit') }}
                        </a>
                        
                        @can('delete', $sparePart)
                        <form action="{{ route('spare-parts.destroy', $sparePart) }}" method="POST" class="inline" 
                              onsubmit="return confirm('{{ __('spare_parts.delete_confirmation') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                {{ __('spare_parts.delete') }}
                            </button>
                        </form>
                        @endcan
                    </div>
                    @endcan
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Images -->
                    <div>
                        @if($sparePart->images && count($sparePart->images) > 0)
                        <div class="space-y-4">
                            <!-- Main Image -->
                            <div class="aspect-w-16 aspect-h-9">
                                <img id="main-image" 
                                     src="{{ $sparePart->first_image_url }}" 
                                     alt="{{ $sparePart->name }}" 
                                     class="w-full h-96 object-cover rounded-lg">
                            </div>
                            
                            <!-- Thumbnail Images -->
                            @if(count($sparePart->images) > 1)
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($sparePart->image_urls as $index => $imageUrl)
                                <button onclick="changeMainImage('{{ $imageUrl }}')" 
                                        class="aspect-w-1 aspect-h-1">
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $sparePart->name }}" 
                                         class="w-full h-20 object-cover rounded-md hover:opacity-75 transition-opacity duration-200">
                                </button>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">{{ __('spare_parts.no_images_available') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div>
                        @if($sparePart->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('spare_parts.description') }}</h3>
                            <div class="prose max-w-none">
                                <p class="text-gray-700 leading-relaxed">{{ $sparePart->description }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Additional Info -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('spare_parts.additional_info') }}</h3>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('spare_parts.status') }}:</dt>
                                    <dd class="text-sm text-gray-900">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $sparePart->approval_status_badge_class }}">
                                            {{ $sparePart->approval_status_display }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('spare_parts.date_added') }}:</dt>
                                    <dd class="text-sm text-gray-900">{{ $sparePart->created_at->format('d/m/Y H:i') }}</dd>
                                </div>
                                @if($sparePart->updated_at != $sparePart->created_at)
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('spare_parts.last_updated') }}:</dt>
                                    <dd class="text-sm text-gray-900">{{ $sparePart->updated_at->format('d/m/Y H:i') }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Contact Info -->
                        @if($sparePart->creator)
                        <div class="mt-6 bg-blue-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('spare_parts.contact_info') }}</h3>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium">{{ __('spare_parts.name') }}:</span> {{ $sparePart->creator->name }}
                                </p>
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium">{{ __('spare_parts.email') }}:</span> {{ $sparePart->creator->email }}
                                </p>
                                @if($sparePart->creator->phone)
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium">{{ __('spare_parts.phone') }}:</span> {{ $sparePart->creator->phone }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('spare-parts.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('spare_parts.back_to_spare_parts') }}
            </a>
        </div>
    </div>
</div>

<script>
function changeMainImage(imageUrl) {
    document.getElementById('main-image').src = imageUrl;
}
</script>
@endsection 