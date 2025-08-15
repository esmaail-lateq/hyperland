// Cars index page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Advanced search toggle
    const advancedSearchBtn = document.getElementById('advancedSearchBtn');
    const advancedSearchOptions = document.getElementById('advancedSearchOptions');
    
    if (advancedSearchBtn && advancedSearchOptions) {
        // Initial state check for advanced search options based on URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const hasAdvancedFilters = ['min_year', 'max_year', 'transmission', 'fuel_type', 'condition', 'cylinders',
                                    'has_air_conditioning', 'has_leather_seats', 'has_navigation', 
                                    'has_parking_sensors', 'has_parking_camera', 'has_heated_seats', 
                                    'has_bluetooth', 'has_led_lights'].some(param => urlParams.has(param));

        if (hasAdvancedFilters) {
            advancedSearchOptions.classList.remove('hidden');
            const arrow = advancedSearchBtn.querySelector('svg');
            if (arrow) {
                arrow.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
            }
        }

        advancedSearchBtn.addEventListener('click', function() {
            advancedSearchOptions.classList.toggle('hidden');
            
            // Change the arrow direction
            const arrow = this.querySelector('svg');
            if (arrow) {
                if (advancedSearchOptions.classList.contains('hidden')) {
                    arrow.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
                } else {
                    arrow.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
                }
            }
        });
    }
});
