@extends('layouts.app')

@section('title', __('shipping.shipping_services') . ' - ' . __('shipping.container_tracking'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                <svg class="inline-block w-8 h-8 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                {{ __('shipping.shipping_services') }}
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                {{ __('shipping.shipping_description') }}
            </p>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6 text-center">
                    {{ __('shipping.track_shipment') }}
                </h2>

                <!-- Search Form -->
                <form id="trackingForm" class="space-y-6">
                    @csrf
                    
                    <!-- Tracking Type Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('shipping.tracking_type') }}
                            </label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="tracking_type" value="container" checked
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">{{ __('shipping.container_number') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="tracking_type" value="booking"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">{{ __('shipping.booking_number') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Tracking Number Input -->
                    <div>
                        <label for="tracking_number" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('shipping.tracking_number') }}
                        </label>
                        <div class="relative">
                            <input type="text" id="tracking_number" name="tracking_number" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg"
                                   placeholder="{{ __('shipping.tracking_number_placeholder') }}"
                                   maxlength="50">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Track Button -->
                    <div class="text-center">
                        <button type="submit" id="trackButton"
                                class="inline-flex items-center px-8 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-white text-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('shipping.track_shipment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="hidden bg-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="text-center">
                <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-blue-600">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('shipping.searching_shipment') }}
                </div>
            </div>
        </div>

        <!-- Error State -->
        <div id="errorState" class="hidden bg-red-50 border border-red-200 rounded-2xl p-8 mb-8">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <h3 class="text-lg font-medium text-red-800 mb-2" id="errorTitle">{{ __('shipping.error_title') }}</h3>
                <p class="text-red-600" id="errorMessage">{{ __('shipping.error_message') }}</p>
            </div>
        </div>

        <!-- Results Section -->
        <div id="resultsSection" class="hidden space-y-6">
            
            <!-- Main Info Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-semibold text-gray-900">{{ __('shipping.shipment_info') }}</h3>
                    <div id="statusBadge" class="px-4 py-2 rounded-full text-sm font-medium"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-sm font-medium text-gray-500 mb-1">{{ __('shipping.tracking_number_label') }}</div>
                        <div id="trackingNumber" class="text-lg font-semibold text-gray-900"></div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-sm font-medium text-gray-500 mb-1">{{ __('shipping.current_location_label') }}</div>
                        <div id="currentLocation" class="text-lg font-semibold text-gray-900"></div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-sm font-medium text-gray-500 mb-1">{{ __('shipping.expected_arrival_label') }}</div>
                        <div id="expectedArrival" class="text-lg font-semibold text-gray-900"></div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-sm font-medium text-gray-500 mb-1">{{ __('shipping.last_update_label') }}</div>
                        <div id="lastUpdate" class="text-lg font-semibold text-gray-900"></div>
                    </div>
                </div>
            </div>

            <!-- Movement History -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h3 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('shipping.movement_history') }}</h3>
                
                <div id="movementHistory" class="space-y-4">
                    <!-- Movement items will be populated here -->
                </div>
            </div>

            <!-- Container Info (if available) -->
            <div id="containerInfoSection" class="hidden bg-white rounded-2xl shadow-xl p-8">
                <h3 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('shipping.container_info') }}</h3>
                
                <div id="containerInfo" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Container info will be populated here -->
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="bg-blue-50 rounded-2xl p-8 mt-8">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-xl font-semibold text-blue-900 mb-4">{{ __('shipping.how_to_use') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <h4 class="font-medium text-blue-800">{{ __('shipping.container_number_info') }}</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• يتكون من 11 حرف (مثال: ABCD1234567)</li>
                            <li>• موجود على الحاوية نفسها</li>
                            <li>• يبدأ بـ 4 أحرف تليها 7 أرقام</li>
                        </ul>
                    </div>
                    
                    <div class="space-y-3">
                        <h4 class="font-medium text-blue-800">{{ __('shipping.booking_number_info') }}</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• يتكون من 9 أرقام (مثال: 123456789)</li>
                            <li>• موجود في وثائق الشحن</li>
                            <li>• يبدأ بـ 3 أرقام تليها 6 أرقام</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('trackingForm');
    const loadingState = document.getElementById('loadingState');
    const errorState = document.getElementById('errorState');
    const resultsSection = document.getElementById('resultsSection');
    const trackButton = document.getElementById('trackButton');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const trackingType = formData.get('tracking_type');
        const trackingNumber = formData.get('tracking_number').trim();

        if (!trackingNumber) {
            showError('يرجى إدخال رقم التتبع');
            return;
        }

        // Show loading state
        showLoading();
        
        try {
            const response = await fetch('{{ route("shipping.track") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tracking_type: trackingType,
                    tracking_number: trackingNumber
                })
            });

            const result = await response.json();

            if (result.success) {
                displayResults(result.data);
            } else {
                showError(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            showError('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.');
        }
    });

    function showLoading() {
        loadingState.classList.remove('hidden');
        errorState.classList.add('hidden');
        resultsSection.classList.add('hidden');
        trackButton.disabled = true;
    }

    function showError(message) {
        loadingState.classList.add('hidden');
        errorState.classList.remove('hidden');
        resultsSection.classList.add('hidden');
        trackButton.disabled = false;
        
        document.getElementById('errorMessage').textContent = message;
    }

    function displayResults(data) {
        loadingState.classList.add('hidden');
        errorState.classList.add('hidden');
        resultsSection.classList.remove('hidden');
        trackButton.disabled = false;

        // Update main info
        document.getElementById('trackingNumber').textContent = data.tracking_number;
        document.getElementById('currentLocation').textContent = data.current_location;
        document.getElementById('expectedArrival').textContent = data.expected_arrival;
        document.getElementById('lastUpdate').textContent = data.last_update;

        // Update status badge
        const statusBadge = document.getElementById('statusBadge');
        statusBadge.textContent = data.status;
        statusBadge.className = getStatusBadgeClass(data.status);

        // Update movement history
        const movementHistory = document.getElementById('movementHistory');
        movementHistory.innerHTML = '';

        if (data.movement_history && data.movement_history.length > 0) {
            data.movement_history.forEach((movement, index) => {
                const movementItem = createMovementItem(movement, index);
                movementHistory.appendChild(movementItem);
            });
        } else {
            movementHistory.innerHTML = '<p class="text-gray-500 text-center py-4">لا توجد بيانات حركة متاحة</p>';
        }

        // Update container info if available
        if (data.container_info && Object.keys(data.container_info).length > 0) {
            document.getElementById('containerInfoSection').classList.remove('hidden');
            const containerInfo = document.getElementById('containerInfo');
            containerInfo.innerHTML = '';

            Object.entries(data.container_info).forEach(([key, value]) => {
                const infoItem = createInfoItem(key, value);
                containerInfo.appendChild(infoItem);
            });
        } else {
            document.getElementById('containerInfoSection').classList.add('hidden');
        }
    }

    function getStatusBadgeClass(status) {
        const statusClasses = {
            'قيد النقل': 'bg-blue-100 text-blue-800',
            'تم التسليم': 'bg-green-100 text-green-800',
            'وصلت': 'bg-green-100 text-green-800',
            'غادرت': 'bg-yellow-100 text-yellow-800',
            'قيد التحميل': 'bg-purple-100 text-purple-800',
            'قيد التفريغ': 'bg-purple-100 text-purple-800',
            'في نقطة البداية': 'bg-gray-100 text-gray-800',
            'في نقطة الوصول': 'bg-gray-100 text-gray-800'
        };

        return `px-4 py-2 rounded-full text-sm font-medium ${statusClasses[status] || 'bg-gray-100 text-gray-800'}`;
    }

    function createMovementItem(movement, index) {
        const item = document.createElement('div');
        item.className = 'flex items-start space-x-4 p-4 bg-gray-50 rounded-lg';
        
        item.innerHTML = `
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-blue-600">${index + 1}</span>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-medium text-gray-900">${movement.location}</h4>
                    <span class="text-sm text-gray-500">${movement.timestamp}</span>
                </div>
                <p class="text-sm text-gray-600 mt-1">${movement.activity}</p>
                <div class="mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusBadgeClass(movement.status)}">
                        ${movement.status}
                    </span>
                </div>
            </div>
        `;
        
        return item;
    }

    function createInfoItem(key, value) {
        const item = document.createElement('div');
        item.className = 'bg-gray-50 rounded-lg p-4';
        
        item.innerHTML = `
            <div class="text-sm font-medium text-gray-500 mb-1">${key}</div>
            <div class="text-lg font-semibold text-gray-900">${value}</div>
        `;
        
        return item;
    }
});
</script>
@endpush
@endsection 