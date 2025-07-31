<template>
  <div class="w-full">
    <div class="w-full mx-auto">
      <div class="car-grid">
        <div v-for="car in cars" :key="car.id" class="car-item group">
          <a :href="carUrl(car)" class="car-card">
            <div v-if="car.is_featured" class="car-badge">Featured</div>
            
            <!-- Car Status Badge -->
            <div v-if="car.status" class="car-status-badge" :class="getStatusBadgeClass(car.status)">
              {{ getStatusDisplay(car.status) }}
            </div>
            
            <div class="car-image-container">
              <img v-if="car.imageStatus === 'success'"
                   :src="car.finalImageUrl" 
                   :alt="`${car.make} ${car.model}`" 
                   class="car-image"
                   @error="handleImageError(car)">
              <div v-else class="car-placeholder">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                </svg>
                <div class="text-gray-500 text-sm mt-2">{{ car.make }} {{ car.model }}</div>
              </div>
            </div>
            
            <div class="car-overlay">
              <div class="car-title">{{ car.make }} {{ car.model }}</div>
              <div class="car-price">{{ car.formattedPrice }}</div>
              <div class="car-details">
                <div class="car-specs">
                  <div class="car-year">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ car.year }}
                  </div>
                  <div class="car-mileage">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    {{ formatNumber(car.mileage) }} km
                  </div>
                  <div class="car-location">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ car.location }}
                  </div>
                </div>
                <button v-if="isAuthenticated" 
                        @click.prevent="toggleFavorite(car)" 
                        class="car-favorite-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" 
                       class="h-5 w-5" 
                       :fill="car.isFavorite ? '#ff6b6b' : 'none'" 
                       viewBox="0 0 24 24" 
                       stroke="currentColor" 
                       stroke-width="2">
                    <path stroke-linecap="round" 
                          stroke-linejoin="round" 
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    
    <div v-if="pagination && pagination.links && pagination.links.length > 3" class="mt-8">
      <pagination :links="pagination.links" @page-changed="changePage"></pagination>
    </div>

    <div v-if="loading" class="loading-overlay">
      <div class="loading-spinner"></div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    initialCars: {
      type: Array,
      default: () => []
    },
    pagination: {
      type: Object,
      default: null
    },
    isAuthenticated: {
      type: Boolean,
      default: false
    },
    csrfToken: {
      type: String,
      required: true
    }
  },
  
  data() {
    return {
      cars: [],
      loading: false,
      defaultImageUrl: '/images/default-car.svg'
    }
  },
  
  created() {
    // Initialize cars with the provided initial cars
    this.cars = JSON.parse(JSON.stringify(this.initialCars)) || [];
    console.log('Initial cars data:', this.cars);
    
    // Process car data to ensure proper paths
    this.processCarImages();
  },
  
  methods: {
    processCarImages() {
      this.cars.forEach(car => {
        // Extract the image path
        let imagePath = car.imageUrl || '';
        console.log(`Car ${car.id} (${car.make} ${car.model}) - Original image path: ${imagePath}`);
        
        // Handle cases where imageUrl is empty or null
        if (!imagePath || imagePath.includes('default-car')) {
          car.imageStatus = 'error';
          console.log(`No valid image for car ${car.id}`);
          return;
        }
        
        // Clean up any double paths
        if (imagePath.includes('/storage/storage/')) {
          imagePath = imagePath.replace('/storage/storage/', '/storage/');
        }
        
        // Make sure path starts with /storage/
        if (!imagePath.startsWith('/') && !imagePath.startsWith('http')) {
          imagePath = `/storage/${imagePath.replace(/^storage\//, '')}`;
        }
        
        // Always add a cache-busting parameter
        car.finalImageUrl = `${imagePath}?v=${Date.now()}`;
        car.imageStatus = 'success';
        
        console.log(`Final image URL for car ${car.id}: ${car.finalImageUrl}`);
      });
    },
    
    handleImageError(car) {
      console.log(`Image error for car ${car.id}`);
      car.imageStatus = 'error';
    },
    
    carUrl(car) {
      return `/cars/${car.id}`;
    },
    
    formatNumber(number) {
      return new Intl.NumberFormat().format(number);
    },
    
    async toggleFavorite(car) {
      try {
        const response = await fetch(`/favorites/${car.id}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': this.csrfToken,
            'Accept': 'application/json'
          },
          credentials: 'include'
        });
        
        if (response.ok) {
          // Toggle the favorite status locally
          car.isFavorite = !car.isFavorite;
        }
      } catch (error) {
        console.error('Error toggling favorite:', error);
      }
    },
    
    async changePage(page) {
      this.loading = true;
      
      try {
        const response = await fetch(`/cars?page=${page}`, {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Fetched page data:', data);
        
        if (data.cars && Array.isArray(data.cars)) {
          this.cars = data.cars;
          this.pagination = data.pagination;
          
          // Process car images after loading
          this.processCarImages();
        }
      } catch (error) {
        console.error('Error fetching cars:', error);
      } finally {
        this.loading = false;
      }
    },

    getStatusDisplay(status) {
      const statusMap = {
        'available': 'متوفرة للبيع في اليمن',
        'at_customs': 'متوفرة في المنافذ الجمركية',
        'in_transit': 'قيد الشحن إلى اليمن',
        'purchased': 'تم شراؤها مؤخراً من المزاد',
        'sold': 'تم البيع'
      };
      
      return statusMap[status] || status;
    },

    getStatusBadgeClass(status) {
      const badgeMap = {
        'available': 'bg-green-100 text-green-800',
        'at_customs': 'bg-blue-100 text-blue-800',
        'in_transit': 'bg-yellow-100 text-yellow-800',
        'purchased': 'bg-purple-100 text-purple-800',
        'sold': 'bg-gray-100 text-gray-800'
      };
      
      return badgeMap[status] || 'bg-gray-100 text-gray-800';
    }
  }
}
</script>

<style scoped>
/* Grid Layout */
.car-grid {
  display: grid;
  grid-template-columns: repeat(1, 1fr); /* Default for mobile */
  gap: 1.5rem; /* Gap between cards */
}

@media (min-width: 640px) { /* Small screens */
  .car-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 768px) { /* Medium screens */
  .car-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (min-width: 1024px) { /* Large screens */
  .car-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

/* Car Item and Card */
.car-item {
  width: 100%;
  break-inside: avoid;
  overflow: hidden;
  border-radius: 0.75rem; /* More rounded corners */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08); /* Softer shadow */
  transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
}

.car-item:hover {
  transform: translateY(-0.5rem); /* Lift effect */
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15); /* Stronger shadow on hover */
}

.car-card {
  display: block;
  position: relative;
  height: 220px;
  width: 100%;
  border-radius: 0.75rem;
  overflow: hidden;
  background-color: #ffffff; /* White background */
  display: flex;
  flex-direction: column;
}

.car-image-container {
  width: 100%;
  height: 100%;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #e5e7eb;
}

.car-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1;
  transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth zoom */
}

.car-item:hover .car-image {
  transform: scale(1.08); /* Slightly more zoom */
}

.car-placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  background-color: #f3f4f6;
}

/* Overlay for text */
.car-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(to top, rgba(17, 24, 39, 0.95), rgba(17, 24, 39, 0.75) 60%, transparent); /* Darker, more solid gradient */
  color: white;
  padding: 1rem;
  width: 100%;
  z-index: 2;
  transition: padding 0.3s ease-out; /* Smooth padding transition */
}

.car-item:hover .car-overlay {
  padding-bottom: 1.5rem; /* Slightly expand overlay on hover */
}

.car-title {
  font-weight: 700; /* Bold */
  font-size: 1.125rem; /* text-lg */
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  width: 100%;
  display: block;
  margin-bottom: 0.25rem; /* Space below title */
}

.car-price {
  font-weight: 800; /* Extra bold */
  font-size: 1.5rem; /* text-2xl */
  color: #fbbf24; /* Tailwind yellow-400 */
  text-shadow: 1px 1px 2px rgba(0,0,0,0.5); /* Slight text shadow for pop */
}

.car-details {
  font-size: 0.75rem; /* text-xs */
  opacity: 0.9;
  margin-top: 0.75rem;
  display: flex;
  justify-content: space-between;
  align-items: flex-end; /* Align items to bottom for a cleaner look */
  width: 100%;
}

.car-specs {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem; /* Gap between spec badges */
}

.car-year, .car-mileage, .car-location {
  display: inline-flex;
  align-items: center;
  background-color: rgba(255, 255, 255, 0.2); /* Slightly more opaque background */
  padding: 0.25rem 0.625rem; /* Tighter padding */
  border-radius: 0.375rem; /* Rounded corners */
  font-size: 0.6875rem; /* Slightly smaller font for specs */
  color: rgba(255, 255, 255, 0.9);
}

.car-specs svg {
    margin-right: 0.25rem; /* Adjust icon spacing */
    color: rgba(255, 255, 255, 0.7);
}

.car-favorite-btn {
  background-color: rgba(255, 255, 255, 0.25); /* More prominent background */
  border-radius: 50%;
  width: 2.25rem; /* Larger button */
  height: 2.25rem;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease, transform 0.2s ease;
  flex-shrink: 0; /* Prevent shrinking */
  margin-left: 0.5rem; /* Space from specs */
}

.car-favorite-btn:hover {
  background-color: rgba(255, 255, 255, 0.4);
  transform: scale(1.1); /* Pop effect on hover */
}

.car-favorite-btn svg {
    stroke-width: 1.5; /* Slightly thinner stroke */
}

/* Featured Badge */
.car-badge {
  position: absolute;
  top: 0.75rem; /* Adjusted position */
  left: 0;
  background: #f59e0b; /* Tailwind amber-500 */
  color: #1a202c; /* Dark text for contrast */
  font-weight: 700;
  font-size: 0.75rem; /* text-xs */
  padding: 0.25rem 0.75rem;
  border-radius: 0 0.375rem 0.375rem 0; /* More rounded edge */
  z-index: 3;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  letter-spacing: 0.05em; /* Slight letter spacing */
}

/* Car Status Badge */
.car-status-badge {
  position: absolute;
  top: 0.75rem;
  right: 0;
  font-weight: 600;
  font-size: 0.625rem; /* text-xs */
  padding: 0.25rem 0.5rem;
  border-radius: 0.375rem 0 0 0.375rem;
  z-index: 3;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  letter-spacing: 0.05em;
}

/* Loading Overlay */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.85); /* Slightly less transparent */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.loading-spinner {
  width: 3.5rem; /* Larger spinner */
  height: 3.5rem;
  border: 4px solid #e0e7ff; /* Lighter border */
  border-top: 4px solid #3b82f6; /* Tailwind blue-500 */
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>