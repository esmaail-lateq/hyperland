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
