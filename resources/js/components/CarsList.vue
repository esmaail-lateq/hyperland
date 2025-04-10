<template>
  <div class="w-full">
    <div class="w-full mx-auto">
      <div class="car-grid">
        <div v-for="car in cars" :key="car.id" class="car-item">
          <a :href="carUrl(car)" class="car-card">
            <div v-if="car.is_featured" class="car-badge">BEST</div>
            
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
    }
  }
}
</script>

<style scoped>
.car-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}

@media (max-width: 1024px) {
  .car-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 768px) {
  .car-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 640px) {
  .car-grid {
    grid-template-columns: repeat(1, 1fr);
  }
}

.car-item {
  width: 100%;
  break-inside: avoid;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.car-card {
  display: block;
  position: relative;
  height: 220px;
  width: 100%;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  background-color: #f3f4f6;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.car-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
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
  transition: transform 0.5s ease;
}

.car-card:hover .car-image {
  transform: scale(1.1);
}

.car-default-image {
  width: 80px;
  height: 80px;
  opacity: 0.4;
  z-index: 1;
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

.car-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.5) 60%, transparent);
  color: white;
  padding: 16px;
  width: 100%;
  z-index: 2;
}

.car-title {
  font-weight: bold;
  font-size: 16px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  width: 100%;
  display: block;
}

.car-price {
  font-weight: bold;
  font-size: 18px;
  color: #FFD700;
  margin-top: 4px;
}

.car-details {
  font-size: 12px;
  opacity: 0.9;
  margin-top: 8px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

.car-specs {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.car-year, .car-mileage, .car-location {
  display: inline-flex;
  align-items: center;
  background-color: rgba(255, 255, 255, 0.15);
  padding: 2px 6px;
  border-radius: 4px;
  font-size: 11px;
}

.car-favorite-btn {
  background-color: rgba(255, 255, 255, 0.15);
  border-radius: 50%;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s;
}

.car-favorite-btn:hover {
  background-color: rgba(255, 255, 255, 0.25);
}

.car-badge {
  position: absolute;
  top: 12px;
  left: 0;
  background: #FFD700;
  color: black;
  font-weight: bold;
  font-size: 12px;
  padding: 4px 8px;
  border-radius: 0 4px 4px 0;
  z-index: 3;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #3498db;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style> 