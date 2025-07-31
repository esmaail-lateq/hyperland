<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post New Car Listing') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" x-data="carForm()">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="title" :value="__('Listing Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Make -->
                            <div>
                                <x-input-label for="make" :value="__('Cars')" />
                                <select id="make" name="make" x-model="make" @change="updateModels()" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">All Cars</option>
                                    <template x-for="makeOption in makes" :key="makeOption">
                                        <option x-text="makeOption" :value="makeOption" :selected="makeOption === '{{ old('make') }}'"></option>
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
                                        <option x-text="modelOption" :value="modelOption" :selected="modelOption === '{{ old('model') }}'"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('model')" class="mt-2" />
                            </div>

                            <!-- Year -->
                            <div>
                                <x-input-label for="year" :value="__('Year')" />
                                <x-text-input id="year" class="block mt-1 w-full" type="number" name="year" :value="old('year')" min="1900" max="{{ date('Y') + 1 }}" required />
                                <x-input-error :messages="$errors->get('year')" class="mt-2" />
                            </div>

                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Price (€)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" min="0" step="0.01" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Mileage -->
                            <div>
                                <x-input-label for="mileage" :value="__('Mileage (km)')" />
                                <x-text-input id="mileage" class="block mt-1 w-full" type="number" name="mileage" :value="old('mileage')" min="0" required />
                                <x-input-error :messages="$errors->get('mileage')" class="mt-2" />
                            </div>

                            <!-- Fuel Type -->
                            <div>
                                <x-input-label for="fuel_type" :value="__('Fuel Type')" />
                                <select id="fuel_type" name="fuel_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="gasoline" {{ old('fuel_type') == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                    <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    <option value="lpg" {{ old('fuel_type') == 'lpg' ? 'selected' : '' }}>LPG</option>
                                    <option value="other" {{ old('fuel_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('fuel_type')" class="mt-2" />
                            </div>

                            <!-- Transmission -->
                            <div>
                                <x-input-label for="transmission" :value="__('Transmission')" />
                                <select id="transmission" name="transmission" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="semi-automatic" {{ old('transmission') == 'semi-automatic' ? 'selected' : '' }}>Semi-Automatic</option>
                                </select>
                                <x-input-error :messages="$errors->get('transmission')" class="mt-2" />
                            </div>

                            <!-- Cylinders -->
                            <div>
                                <x-input-label for="cylinders" :value="__('Cylinders')" />
                                <select id="cylinders" name="cylinders" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Cylinders</option>
                                    <option value="3" {{ old('cylinders') == '3' ? 'selected' : '' }}>3 Cylinders</option>
                                    <option value="4" {{ old('cylinders') == '4' ? 'selected' : '' }}>4 Cylinders</option>
                                    <option value="6" {{ old('cylinders') == '6' ? 'selected' : '' }}>6 Cylinders</option>
                                    <option value="8" {{ old('cylinders') == '8' ? 'selected' : '' }}>8 Cylinders</option>
                                    <option value="10" {{ old('cylinders') == '10' ? 'selected' : '' }}>10 Cylinders</option>
                                    <option value="12" {{ old('cylinders') == '12' ? 'selected' : '' }}>12 Cylinders</option>
                                    <option value="16" {{ old('cylinders') == '16' ? 'selected' : '' }}>16 Cylinders</option>
                                </select>
                                <x-input-error :messages="$errors->get('cylinders')" class="mt-2" />
                            </div>

                            <!-- Location -->
                            <div>
                                <x-input-label for="location" :value="__('Location')" />
                                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <!-- Condition -->
                            <div>
                                <x-input-label for="condition" :value="__('Condition')" />
                                <select id="condition" name="condition" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                                    <option value="for_parts" {{ old('condition') == 'for_parts' ? 'selected' : '' }}>For Parts</option>
                                </select>
                                <x-input-error :messages="$errors->get('condition')" class="mt-2" />
                            </div>

                            <!-- Car Status -->
                            <div>
                                <x-input-label for="status" :value="__('Car Status')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>متوفرة للبيع في صنعاء أو أي محافظة أخرى</option>
                                    <option value="at_customs" {{ old('status') == 'at_customs' ? 'selected' : '' }}>متوفرة في المنافذ الجمركية</option>
                                    <option value="in_transit" {{ old('status') == 'in_transit' ? 'selected' : '' }}>قيد الشحن إلى اليمن</option>
                                    <option value="purchased" {{ old('status') == 'purchased' ? 'selected' : '' }}>تم شراؤها مؤخرًا من المزاد</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Number of Owners -->
                            <div>
                                <x-input-label for="owners_count" :value="__('Number of Previous Owners')" />
                                <x-text-input id="owners_count" class="block mt-1 w-full" type="number" name="owners_count" :value="old('owners_count')" min="0" />
                                <x-input-error :messages="$errors->get('owners_count')" class="mt-2" />
                            </div>

                            <!-- Service History -->
                            <div class="flex items-center mt-4">
                                <input id="has_service_history" type="checkbox" name="has_service_history" value="1" {{ old('has_service_history') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="has_service_history" class="ml-2 block text-sm text-gray-900">Has Service History</label>
                                <x-input-error :messages="$errors->get('has_service_history')" class="mt-2" />
                            </div>

                            <!-- Features -->
                            <div class="col-span-1 md:col-span-2">
                                <x-input-label :value="__('Features')" class="mb-3" />
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="flex items-center">
                                        <input id="has_air_conditioning" type="checkbox" name="has_air_conditioning" value="1" {{ old('has_air_conditioning') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="has_air_conditioning" class="ml-2 block text-sm text-gray-900">Air Conditioning</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="has_leather_seats" type="checkbox" name="has_leather_seats" value="1" {{ old('has_leather_seats') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="has_leather_seats" class="ml-2 block text-sm text-gray-900">Leather Seats</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="has_navigation" type="checkbox" name="has_navigation" value="1" {{ old('has_navigation') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="has_navigation" class="ml-2 block text-sm text-gray-900">Navigation</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="has_parking_sensors" type="checkbox" name="has_parking_sensors" value="1" {{ old('has_parking_sensors') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="has_parking_sensors" class="ml-2 block text-sm text-gray-900">Parking Sensors</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="has_parking_camera" type="checkbox" name="has_parking_camera" value="1" {{ old('has_parking_camera') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="has_parking_camera" class="ml-2 block text-sm text-gray-900">Parking Camera</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="has_heated_seats" type="checkbox" name="has_heated_seats" value="1" {{ old('has_heated_seats') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="has_heated_seats" class="ml-2 block text-sm text-gray-900">Heated Seats</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="has_bluetooth" type="checkbox" name="has_bluetooth" value="1" {{ old('has_bluetooth') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="has_bluetooth" class="ml-2 block text-sm text-gray-900">Bluetooth</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="has_led_lights" type="checkbox" name="has_led_lights" value="1" {{ old('has_led_lights') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="has_led_lights" class="ml-2 block text-sm text-gray-900">LED Lights</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" rows="6" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Images -->
                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="images" :value="__('Images (1-10 images)')" />
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                    x-on:dragover.prevent="$el.classList.add('border-indigo-500')"
                                    x-on:dragleave.prevent="$el.classList.remove('border-indigo-500')"
                                    x-on:drop.prevent="handleDrop($event)"
                                >
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload files</span>
                                                <input id="images" name="images[]" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg" multiple @change="previewImages">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, JPEG up to 2MB
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-2 text-sm text-gray-500" x-show="imageFiles.length === 0">
                                    <p>At least one image is required. The first image will be the primary image displayed in listings.</p>
                                </div>
                                
                                <div class="mt-2 text-sm text-gray-500" x-show="imageFiles.length > 0">
                                    <p>You've selected <span x-text="imageFiles.length"></span> images. The first image will be the primary image.</p>
                                </div>
                                
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                <x-input-error :messages="$errors->get('images.*')" class="mt-2" />

                                <!-- Image Previews -->
                                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4" x-show="imageFiles.length > 0">
                                    <template x-for="(file, index) in imageFiles" :key="index">
                                        <div class="relative rounded-md overflow-hidden h-32 border shadow-sm">
                                            <img :src="file.url" class="w-full h-full object-cover">
                                            <div class="absolute top-0 left-0 right-0 flex justify-between p-1 bg-black bg-opacity-50">
                                                <span x-show="index === 0" class="text-yellow-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                </span>
                                                <span x-show="index !== 0" class="text-transparent">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                </span>
                                                <button type="button" @click="removeImage(index)" class="text-gray-300 hover:text-red-500 focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Post Listing') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function carForm() {
            return {
                make: '{{ old('make') }}',
                model: '{{ old('model') }}',
                imageFiles: [],
                
                // Car make and model data
                makes: ['Audi', 'BMW', 'Ford', 'Honda', 'Hyundai', 'Kia', 'Mazda', 'Mercedes-Benz', 'Nissan', 'Opel', 'Peugeot', 'Renault', 'Skoda', 'Toyota', 'Volkswagen', 'Volvo'],
                models: {
                    'Audi': ['A1', 'A3', 'A4', 'A5', 'A6', 'Q3', 'Q5', 'Q7'],
                    'BMW': ['1 Series', '3 Series', '5 Series', '7 Series', 'X1', 'X3', 'X5', 'X6'],
                    'Ford': ['Fiesta', 'Focus', 'Mondeo', 'Kuga', 'Puma', 'Mustang'],
                    'Honda': ['Civic', 'Accord', 'CR-V', 'HR-V', 'Jazz'],
                    'Hyundai': ['i10', 'i20', 'i30', 'Tucson', 'Santa Fe'],
                    'Kia': ['Picanto', 'Rio', 'Ceed', 'Sportage', 'Sorento'],
                    'Mazda': ['2', '3', '6', 'CX-3', 'CX-5', 'MX-5'],
                    'Mercedes-Benz': ['A-Class', 'C-Class', 'E-Class', 'S-Class', 'GLA', 'GLC', 'GLE'],
                    'Nissan': ['Micra', 'Juke', 'Qashqai', 'X-Trail', 'Leaf'],
                    'Opel': ['Corsa', 'Astra', 'Insignia', 'Mokka', 'Crossland'],
                    'Peugeot': ['208', '308', '508', '2008', '3008', '5008'],
                    'Renault': ['Clio', 'Megane', 'Captur', 'Kadjar', 'Koleos'],
                    'Skoda': ['Fabia', 'Octavia', 'Superb', 'Kamiq', 'Karoq', 'Kodiaq'],
                    'Toyota': ['Yaris', 'Corolla', 'Camry', 'RAV4', 'C-HR', 'Prius'],
                    'Volkswagen': ['Polo', 'Golf', 'Passat', 'Tiguan', 'T-Roc', 'Touareg'],
                    'Volvo': ['S60', 'S90', 'V60', 'V90', 'XC40', 'XC60', 'XC90']
                },
                
                get availableModels() {
                    return this.make ? this.models[this.make] : [];
                },
                
                updateModels() {
                    this.model = '';
                },
                
                init() {
                    // Custom dropdown functionality
                    const makeDropdown = document.getElementById('makeDropdown');
                    const makeOptions = document.getElementById('makeOptions');
                    const selectedMake = document.getElementById('selectedMake');
                    const selectElement = document.getElementById('make');
                    
                    makeDropdown.addEventListener('click', () => {
                        makeOptions.classList.toggle('hidden');
                    });
                    
                    document.querySelectorAll('#makeOptions div').forEach(option => {
                        option.addEventListener('click', () => {
                            const value = option.getAttribute('data-value');
                            this.make = value;
                            makeOptions.classList.add('hidden');
                            this.updateModels();
                        });
                    });
                    
                    // Close dropdown when clicking outside
                    document.addEventListener('click', (event) => {
                        if (!makeDropdown.contains(event.target)) {
                            makeOptions.classList.add('hidden');
                        }
                    });
                },
                
                // Image handling methods
                previewImages(event) {
                    const newFiles = Array.from(event.target.files);
                    
                    newFiles.forEach(file => {
                        if (file.type.match('image.*')) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.imageFiles.push({
                                    file: file,
                                    url: e.target.result
                                });
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                },
                
                handleDrop(event) {
                    event.preventDefault();
                    event.currentTarget.classList.remove('border-indigo-500');
                    
                    const newFiles = Array.from(event.dataTransfer.files);
                    
                    newFiles.forEach(file => {
                        if (file.type.match('image.*')) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.imageFiles.push({
                                    file: file,
                                    url: e.target.result
                                });
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                    
                    // Update the file input
                    const dt = new DataTransfer();
                    this.imageFiles.forEach(item => dt.items.add(item.file));
                    document.getElementById('images').files = dt.files;
                },
                
                removeImage(index) {
                    this.imageFiles.splice(index, 1);
                    
                    // Update the file input
                    const dt = new DataTransfer();
                    this.imageFiles.forEach(item => dt.items.add(item.file));
                    document.getElementById('images').files = dt.files;
                }
            }
        }
    </script>
</x-app-layout> 