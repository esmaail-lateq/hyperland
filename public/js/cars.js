// Car form functionality
function carForm() {
    return {
        make: '',
        model: '',
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
            'Opel': ['Corsa', 'Astra', 'Insignia', 'Mokka', 'Grandland X'],
            'Peugeot': ['208', '308', '3008', '5008', '508'],
            'Renault': ['Clio', 'Megane', 'Captur', 'Kadjar', 'Scenic'],
            'Skoda': ['Fabia', 'Octavia', 'Superb', 'Karoq', 'Kodiaq'],
            'Toyota': ['Yaris', 'Corolla', 'Camry', 'RAV4', 'Land Cruiser'],
            'Volkswagen': ['Polo', 'Golf', 'Passat', 'Tiguan', 'Touareg'],
            'Volvo': ['S60', 'S90', 'V60', 'V90', 'XC40', 'XC60', 'XC90']
        },
        
        get availableModels() {
            return this.make ? this.models[this.make] || [] : [];
        },
        
        updateModels() {
            if (this.make !== this.originalMake) {
                this.model = '';
            }
        },
        
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

// Image manager functionality
function imageManager(carId) {
    return {
        sortable: null,
        
        initSortable() {
            // Initialize Sortable.js
            const container = this.$el;
            const self = this;
            
            this.sortable = new Sortable(container, {
                animation: 150,
                draggable: '[x-ref="sortableItem"]',
                onEnd: function(evt) {
                    self.updateOrder();
                }
            });
        },
        
        updateOrder() {
            // Get the new order of images
            const imageIds = Array.from(this.$el.querySelectorAll('[x-ref="sortableItem"]'))
                .map(el => parseInt(el.dataset.id));
            
            // Send the new order to the server
            fetch(`/cars/${carId}/reorder-images`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ imageIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Optional: show success message
                }
            })
            .catch(error => {
                console.error('Error updating image order:', error);
            });
        },
        
        setPrimary(imageId) {
            fetch(`/car-images/${imageId}/set-primary`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI - set all stars to gray except the selected one
                    this.$el.querySelectorAll('button[title="Primary Image"], button[title="Set as Primary"]').forEach(btn => {
                        btn.classList.remove('text-yellow-500');
                        btn.classList.add('text-gray-300');
                        btn.setAttribute('title', 'Set as Primary');
                    });
                    
                    // Update the clicked button
                    const button = this.$el.querySelector(`[data-id="${imageId}"] button:first-child`);
                    button.classList.remove('text-gray-300');
                    button.classList.add('text-yellow-500');
                    button.setAttribute('title', 'Primary Image');
                }
            })
            .catch(error => {
                console.error('Error setting primary image:', error);
            });
        },
        
        deleteImage(imageId) {
            if (confirm('Are you sure you want to delete this image?')) {
                fetch(`/car-images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the image element from the DOM
                        const imageElement = this.$el.querySelector(`[data-id="${imageId}"]`);
                        if (imageElement) {
                            imageElement.remove();
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error deleting image:', error);
                });
            }
        }
    };
}

// Initialize car form with data
function initCarForm(make, model) {
    const form = carForm();
    form.make = make;
    form.model = model;
    form.originalMake = make;
    return form;
}
