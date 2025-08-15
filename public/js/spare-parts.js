// Image preview functionality for spare parts
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
                    <button type="button" class="remove-image-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                        ×
                    </button>
                `;
                
                // Add event listener to the remove button
                const removeBtn = div.querySelector('.remove-image-btn');
                removeBtn.addEventListener('click', function() {
                    removeImage(this);
                });
                
                preview.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        }
    } else {
        preview.classList.add('hidden');
    }
}

// Remove image from preview
function removeImage(button) {
    button.parentElement.remove();
    if (document.getElementById('image-preview').children.length === 0) {
        document.getElementById('image-preview').classList.add('hidden');
    }
}

// Change main image functionality
function changeMainImage(imageUrl) {
    const mainImage = document.getElementById('main-image');
    if (mainImage) {
        mainImage.src = imageUrl;
    }
}
