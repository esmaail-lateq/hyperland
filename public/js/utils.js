// Common utility functions

// Confirm deletion with custom message
function confirmDelete(message) {
    return confirm(message || 'Are you sure you want to delete this item?');
}

// Auto-submit form on change
function autoSubmitForm(element) {
    if (element.form) {
        element.form.submit();
    }
}

// Handle form submission with confirmation
function submitFormWithConfirmation(form, message) {
    if (confirm(message || 'Are you sure you want to proceed?')) {
        form.submit();
    }
    return false;
}

// Add event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit forms with onchange="this.form.submit()"
    const autoSubmitElements = document.querySelectorAll('[onchange*="this.form.submit"]');
    autoSubmitElements.forEach(element => {
        element.addEventListener('change', function() {
            autoSubmitForm(this);
        });
        // Remove the inline onchange attribute
        element.removeAttribute('onchange');
    });
    
    // Handle confirmation buttons
    const confirmButtons = document.querySelectorAll('[onclick*="return confirm"]');
    confirmButtons.forEach(button => {
        const onclick = button.getAttribute('onclick');
        if (onclick) {
            const messageMatch = onclick.match(/confirm\('([^']+)'\)/);
            const message = messageMatch ? messageMatch[1] : 'Are you sure?';
            
            button.addEventListener('click', function(e) {
                if (!confirm(message)) {
                    e.preventDefault();
                    return false;
                }
            });
            
            // Remove the inline onclick attribute
            button.removeAttribute('onclick');
        }
    });
});
