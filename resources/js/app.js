import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';
import CarsList from './components/CarsList.vue';
import Pagination from './components/Pagination.vue';

window.Alpine = Alpine;
Alpine.start();

// Initialize Vue 3
const carsElement = document.getElementById('cars-component');
if (carsElement) {
    // Parse data attributes
    const initialCars = JSON.parse(carsElement.dataset.cars || '[]');
    const pagination = JSON.parse(carsElement.dataset.pagination || 'null');
    const isAuthenticated = JSON.parse(carsElement.dataset.isAuthenticated || 'false');
    const csrfToken = carsElement.dataset.csrfToken || '';
    
    // Create app instance
    const app = createApp({
        components: {
            'cars-list': CarsList,
            'pagination': Pagination,
        },
        provide: {
            initialCars,
            pagination,
            isAuthenticated,
            csrfToken
        }
    });
    
    app.component('cars-list', CarsList);
    app.component('pagination', Pagination);
    app.mount('#cars-component');
}
