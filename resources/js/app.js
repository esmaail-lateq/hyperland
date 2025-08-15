import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';
import CarsList from './components/CarsList.vue';
import Pagination from './components/Pagination.vue';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Initialize Vue 3
const app = createApp({});
app.component('cars-list', CarsList);
app.component('pagination', Pagination);
app.mount('#app');

// Import utility functions and page-specific scripts
import '../public/js/utils.js';
import '../public/js/cars.js';
import '../public/js/notifications.js';
import '../public/js/spare-parts.js';
import '../public/js/cars-index.js';
import '../public/js/cars-create.js';
import '../public/css/components.css';
