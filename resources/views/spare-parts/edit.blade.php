@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('spare_parts.edit_spare_part') }}</h1>
            <p class="text-gray-600">
                {{ __('spare_parts.update_spare_part_description') }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('spare-parts.update', $sparePart) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('spare_parts.spare_part_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $sparePart->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="{{ __('spare_parts.name_placeholder') }}"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('spare_parts.description') }}
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="{{ __('spare_parts.description_placeholder') }}"
                    >{{ old('description', $sparePart->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Images -->
                @if($sparePart->images && count($sparePart->images) > 0)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('spare_parts.current_images') }}
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($sparePart->image_urls as $index => $imageUrl)
                        <div class="relative">
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $sparePart->name }}" 
                                 class="w-full h-24 object-cover rounded-md">
                            <div class="absolute top-1 right-1">
                                <span class="bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ __('spare_parts.replace_images_description') }}
                    </p>
                </div>
                @endif

                <!-- New Images -->
                <div class="mb-6">
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('spare_parts.new_images') }}
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="mt-4">
                            <label for="images" class="cursor-pointer">
                                <span class="mt-2 block text-sm font-medium text-gray-900">
                                    {{ __('spare_parts.choose_images') }}
                                </span>
                                <span class="mt-1 block text-xs text-gray-500">
                                    {{ __('spare_parts.image_format_info') }}
                                </span>
                            </label>
                            <input id="images" 
                                   name="images[]" 
                                   type="file" 
                                   multiple 
                                   accept="image/*"
                                   class="sr-only">
                        </div>
                    </div>
                    
                    <!-- Image Preview -->
                    <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden">
                    </div>
                    
                    @error('images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('spare-parts.show', $sparePart) }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors duration-200">
                        {{ __('spare_parts.cancel') }}
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
                        {{ __('spare_parts.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('images');
    
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            previewImages(this);
        });
    }
});

function previewImages(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        preview.classList.remove('hidden');
        
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-md">
                    <button type="button" onclick="removeImage(this)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                        ×
                    </button>
                `;
                preview.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        }
    } else {
        preview.classList.add('hidden');
    }
}

function removeImage(button) {
    button.parentElement.remove();
    if (document.getElementById('image-preview').children.length === 0) {
        document.getElementById('image-preview').classList.add('hidden');
    }
}
</script>
@endsection 