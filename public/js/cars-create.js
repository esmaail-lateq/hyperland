// Cars create page functionality
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
            
            if (makeDropdown && makeOptions) {
                makeDropdown.addEventListener('click', () => {
                    makeOptions.classList.toggle('hidden');
                });
                
                document.querySelectorAll('#makeOptions div').forEach(option => {
                    option.addEventListener('click', () => {
                        const value = option.getAttribute('data-value');
                        this.make = value;
                        if (selectedMake) {
                            selectedMake.textContent = value;
                        }
                        if (selectElement) {
                            selectElement.value = value;
                        }
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
            }
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
            const imagesInput = document.getElementById('images');
            if (imagesInput) {
                imagesInput.files = dt.files;
            }
        },
        
        removeImage(index) {
            this.imageFiles.splice(index, 1);
            
            // Update the file input
            const dt = new DataTransfer();
            this.imageFiles.forEach(item => dt.items.add(item.file));
            const imagesInput = document.getElementById('images');
            if (imagesInput) {
                imagesInput.files = dt.files;
            }
        }
    }
}

// Initialize car form when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the car form if it exists
    if (typeof window.carForm === 'undefined') {
        window.carForm = carForm();
    }
});
