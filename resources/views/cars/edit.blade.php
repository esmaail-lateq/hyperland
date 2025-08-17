<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Car Listing') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data" x-data="carForm()">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="title" :value="__('Listing Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $car->title)" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Make -->
                            <div>
                                <x-input-label for="make" :value="__('Make')" />
                                <select id="make" name="make" x-model="make" @change="updateModels()" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Make</option>
                                    <template x-for="makeOption in makes" :key="makeOption">
                                        <option x-text="makeOption" :value="makeOption" :selected="makeOption === '{{ old('make', $car->make) }}'"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('make')" class="mt-2" />
                            </div>

                            <!-- Model -->
                            <div>
                                <x-input-label for="model" :value="__('Model')" />
                                <select id="model" name="model" x-model="model" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Model</option>
                                    <template x-for="modelOption in availableModels" :key="modelOption">
                                        <option x-text="modelOption" :value="modelOption" :selected="modelOption === '{{ old('model', $car->model) }}'"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('model')" class="mt-2" />
                            </div>

                            <!-- Year -->
                            <div>
                                <x-input-label for="year" :value="__('Year')" />
                                <x-text-input id="year" class="block mt-1 w-full" type="number" name="year" :value="old('year', $car->year)" min="1900" max="{{ date('Y') + 1 }}" required />
                                <x-input-error :messages="$errors->get('year')" class="mt-2" />
                            </div>

                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Price (€)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $car->price)" min="0" step="0.01" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Mileage -->
                            <div>
                                <x-input-label for="mileage" :value="__('Mileage (km)')" />
                                <x-text-input id="mileage" class="block mt-1 w-full" type="number" name="mileage" :value="old('mileage', $car->mileage)" min="0" required />
                                <x-input-error :messages="$errors->get('mileage')" class="mt-2" />
                            </div>

                            <!-- Fuel Type -->
                            <div>
                                <x-input-label for="fuel_type" :value="__('Fuel Type')" />
                                <select id="fuel_type" name="fuel_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="gasoline" {{ old('fuel_type', $car->fuel_type) == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                    <option value="diesel" {{ old('fuel_type', $car->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="electric" {{ old('fuel_type', $car->fuel_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="hybrid" {{ old('fuel_type', $car->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    <option value="lpg" {{ old('fuel_type', $car->fuel_type) == 'lpg' ? 'selected' : '' }}>LPG</option>
                                    <option value="other" {{ old('fuel_type', $car->fuel_type) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('fuel_type')" class="mt-2" />
                            </div>

                            <!-- Transmission -->
                            <div>
                                <x-input-label for="transmission" :value="__('Transmission')" />
                                <select id="transmission" name="transmission" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="manual" {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="automatic" {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="semi-automatic" {{ old('transmission', $car->transmission) == 'semi-automatic' ? 'selected' : '' }}>Semi-Automatic</option>
                                </select>
                                <x-input-error :messages="$errors->get('transmission')" class="mt-2" />
                            </div>

                            <!-- Cylinders -->
                            <div>
                                <x-input-label for="cylinders" :value="__('Cylinders')" />
                                <select id="cylinders" name="cylinders" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Cylinders</option>
                                    <option value="3" {{ old('cylinders', $car->cylinders) == '3' ? 'selected' : '' }}>3 Cylinders</option>
                                    <option value="4" {{ old('cylinders', $car->cylinders) == '4' ? 'selected' : '' }}>4 Cylinders</option>
                                    <option value="6" {{ old('cylinders', $car->cylinders) == '6' ? 'selected' : '' }}>6 Cylinders</option>
                                    <option value="8" {{ old('cylinders', $car->cylinders) == '8' ? 'selected' : '' }}>8 Cylinders</option>
                                    <option value="10" {{ old('cylinders', $car->cylinders) == '10' ? 'selected' : '' }}>10 Cylinders</option>
                                    <option value="12" {{ old('cylinders', $car->cylinders) == '12' ? 'selected' : '' }}>12 Cylinders</option>
                                    <option value="16" {{ old('cylinders', $car->cylinders) == '16' ? 'selected' : '' }}>16 Cylinders</option>
                                </select>
                                <x-input-error :messages="$errors->get('cylinders')" class="mt-2" />
                            </div>

                            <!-- Location -->
                            <div>
                                <x-input-label for="location" :value="__('Location')" />
                                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $car->location)" required />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <!-- Car Status -->
                            <div>
                                <x-input-label for="status" :value="__('Car Status')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="available" {{ old('status', $car->status) == 'available' ? 'selected' : '' }}>متوفرة للبيع في صنعاء أو أي محافظة أخرى</option>
                                    <option value="at_customs" {{ old('status', $car->status) == 'at_customs' ? 'selected' : '' }}>متوفرة في المنافذ الجمركية</option>
                                    <option value="in_transit" {{ old('status', $car->status) == 'in_transit' ? 'selected' : '' }}>قيد الشحن إلى اليمن</option>
                                    <option value="purchased" {{ old('status', $car->status) == 'purchased' ? 'selected' : '' }}>تم شراؤها مؤخرًا من المزاد</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="description" :value="__('common.description')" />
                                <textarea id="description" name="description" rows="6" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $car->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Current Images -->
                            <div class="col-span-1 md:col-span-2">
                                <h3 class="text-lg font-medium mb-2">{{ __('common.current_images') }}</h3>
                                
                                @if($car->images->count() > 0)
                                    <div class="mb-3 text-sm text-gray-600">
                                        <p>{{ __('common.drag_images_reorder') }}</p>
                                    </div>
                                    <div 
                                        class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4" 
                                        x-data="imageManager({{ $car->id }})"
                                        x-init="initSortable()"
                                    >
                                        @foreach($car->images->sortBy('display_order') as $image)
                                            <div 
                                                class="relative rounded-md overflow-hidden h-32 shadow-sm border cursor-move"
                                                x-ref="sortableItem"
                                                data-id="{{ $image->id }}"
                                            >
                                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $car->title }}" class="w-full h-full object-cover">
                                                <div class="absolute top-0 left-0 right-0 p-1 flex justify-between bg-black bg-opacity-50">
                                                    <button
                                                        type="button"
                                                        @click="setPrimary({{ $image->id }})"
                                                        class="text-{{ $image->is_primary ? 'yellow-500' : 'gray-300' }} hover:text-yellow-500 focus:outline-none"
                                                        title="{{ $image->is_primary ? 'Primary Image' : 'Set as Primary' }}"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                        </svg>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        @click="deleteImage({{ $image->id }})"
                                                        class="text-gray-300 hover:text-red-500 focus:outline-none"
                                                        title="Delete Image"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">{{ __('common.no_images_available') }}</p>
                                @endif
                            </div>

                            <!-- Add New Images -->
                            <div class="col-span-1 md:col-span-2 mt-4">
                                <x-input-label for="images" :value="__('common.add_new_images')" />
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                    x-on:dragover.prevent="$el.classList.add('border-indigo-500')"
                                    x-on:dragleave.prevent="$el.classList.remove('border-indigo-500')"
                                    x-on:drop.prevent="handleDrop($event)">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>{{ __('common.upload_files') }}</span>
                                                <input id="images" name="images[]" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg" multiple @change="previewImages">
                                            </label>
                                            <p class="pl-1">{{ __('common.or_drag_drop') }}</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            {{ __('common.file_types_limit') }}
                                        </p>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                <x-input-error :messages="$errors->get('images.*')" class="mt-2" />

                                <!-- Image Previews -->
                                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4" x-show="imageFiles.length > 0">
                                    <template x-for="(file, index) in imageFiles" :key="index">
                                        <div class="relative rounded-md overflow-hidden h-32">
                                            <img :src="file.url" class="w-full h-full object-cover">
                                            <button type="button" @click="removeImage(index)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('cars.show', $car) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Listing') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sortable.js for drag and drop functionality -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    
    <script>
        // Initialize car form with existing data
        document.addEventListener('DOMContentLoaded', function() {
            const carFormInstance = initCarForm('{{ old('make', $car->make) }}', '{{ old('model', $car->model) }}');
            // Make it available globally if needed
            window.carFormInstance = carFormInstance;
        });
    </script>
</x-app-layout> 