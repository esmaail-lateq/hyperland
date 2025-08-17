// resources/js/app.js

import './bootstrap';

// --- Alpine (CSP-safe) ---
import Alpine from 'alpinejs';
import AlpineCSP from '@alpinejs/csp';

// فعّل وضع CSP لـ Alpine لتجنّب أي استخدام لـ eval
Alpine.plugin(AlpineCSP);

// اجعل Alpine متاحًا في الـ window (اختياري لكنه مفيد للتصحيح)
window.Alpine = Alpine;

// ابدأ Alpine بعد تحميل السكربتات
Alpine.start();


// --- Vue 3 App (Cars) ---
import { createApp } from 'vue';
import CarsList from './components/CarsList.vue';
import Pagination from './components/Pagination.vue';

// دالة مساعدة لقراءة JSON بأمان من data-attributes
function safeJSON(value, fallback) {
    if (value === undefined || value === null || value === '') return fallback;
    try { return JSON.parse(value); } catch { return fallback; }
}

document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('cars-component');
    if (!el) return;

    // اقرأ القيم من data-attributes بأمان
    const initialCars     = safeJSON(el.dataset.cars, []);
    const pagination      = safeJSON(el.dataset.pagination, null);
    const isAuthenticated = safeJSON(el.dataset.isAuthenticated, false);
    const csrfToken       = el.dataset.csrfToken || '';

    // أنشئ تطبيق Vue
    const app = createApp({
        components: {
            'cars-list': CarsList,
            'pagination': Pagination,
        },
        provide: {
            initialCars,
            pagination,
            isAuthenticated,
            csrfToken,
        },
    });

    app.component('cars-list', CarsList);
    app.component('pagination', Pagination);
    app.mount('#cars-component');
});

// Import utility functions and page-specific scripts
import '../public/js/utils.js';
import '../public/js/cars.js';
import '../public/js/notifications.js';
import '../public/js/spare-parts.js';
import '../public/js/cars-index.js';
import '../public/js/cars-create.js';
import '../public/css/components.css';
