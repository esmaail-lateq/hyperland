<template>
  <div class="flex justify-center mt-8">
    <nav class="inline-flex rounded-lg shadow-md bg-white overflow-hidden">
      <button 
        @click="changePage(currentPage - 1)" 
        :disabled="!hasPreviousPage"
        :class="[
          'relative inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium transition-all duration-300 ease-in-out',
          hasPreviousPage ? 'text-gray-600 hover:bg-gray-100' : 'text-gray-400 cursor-not-allowed'
        ]"
      >
        <span class="sr-only">Previous</span>
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
      </button>

      <template v-for="(link, index) in visiblePageLinks" :key="index">
        <button 
          @click="changePage(link.page)" 
          :disabled="link.active || link.url === null"
          :class="[
            'relative inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium transition-all duration-300 ease-in-out',
            link.active ? 'bg-blue-600 text-white shadow-inner' : 'text-gray-700 hover:bg-gray-100',
            !link.url ? 'text-gray-400 cursor-not-allowed' : ''
          ]"
        >
          {{ link.label }}
        </button>
      </template>

      <button 
        @click="changePage(currentPage + 1)" 
        :disabled="!hasNextPage"
        :class="[
          'relative inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium transition-all duration-300 ease-in-out',
          hasNextPage ? 'text-gray-600 hover:bg-gray-100' : 'text-gray-400 cursor-not-allowed'
        ]"
      >
        <span class="sr-only">Next</span>
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
      </button>
    </nav>
  </div>
</template>

<script>
export default {
  props: {
    links: {
      type: Array,
      required: true
    }
  },
  
  computed: {
    currentPage() {
      // Find the active page from links
      const activePage = this.links.find(link => link.active);
      return activePage ? parseInt(activePage.label) : 1;
    },
    
    hasPreviousPage() {
      return this.currentPage > 1;
    },
    
    hasNextPage() {
      const lastLink = this.links[this.links.length - 1];
      // This logic assumes the last link is always 'Next' and if it's active, there are no more pages.
      // Or, if the URL is null, there's no next page.
      const nextLink = this.links.find(link => link.label === 'Next &raquo;');
      return nextLink && nextLink.url !== null; // Check if 'Next' link exists and has a URL
    },
    
    visiblePageLinks() {
      // Process links to display a reasonable number of pages
      // Filter out prev/next links and keep numbered pages
      const numberedLinks = this.links.filter(link => 
        link.label !== '&laquo; Previous' && 
        link.label !== 'Next &raquo;' && 
        !isNaN(parseInt(link.label)) // Ensure it's a number
      ).map(link => {
        return {
          label: link.label,
          url: link.url,
          active: link.active,
          page: link.url ? parseInt(link.label) : null
        };
      });

      // Implement a more robust visible links logic (e.g., showing ellipsis)
      const maxVisiblePages = 7; // Max number of page buttons to show (e.g., 1, 2, ..., 7, 8)
      const totalPages = numberedLinks.length;
      const currentPageIndex = numberedLinks.findIndex(link => link.active);
      const currentPage = currentPageIndex !== -1 ? numberedLinks[currentPageIndex].page : 1;

      if (totalPages <= maxVisiblePages) {
        return numberedLinks;
      }

      let start = Math.max(0, currentPageIndex - Math.floor(maxVisiblePages / 2));
      let end = Math.min(totalPages - 1, start + maxVisiblePages - 1);

      if (end - start + 1 < maxVisiblePages) {
          start = Math.max(0, totalPages - maxVisiblePages);
      }

      const visible = numberedLinks.slice(start, end + 1);

      // Add ellipsis if needed
      if (start > 0) {
          if (visible[0].page > 2) {
              visible.unshift({ label: '...', url: null, active: false, page: null });
          }
          visible.unshift(numberedLinks[0]); // Always show first page
      }

      if (end < totalPages - 1) {
          if (visible[visible.length - 1].page < totalPages - 1) {
              visible.push({ label: '...', url: null, active: false, page: null });
          }
          visible.push(numberedLinks[totalPages - 1]); // Always show last page
      }

      return visible;
    }
  },
  
  methods: {
    changePage(page) {
      // Check if page is a number or a URL
      if (typeof page === 'number' && page > 0) {
        this.$emit('page-changed', page);
      } else if (typeof page === 'string' && page.includes('page=')) {
        // Extract page number from URL if it's a full URL
        const urlParams = new URLSearchParams(new URL(page).search);
        const pageNumber = urlParams.get('page');
        if (pageNumber) {
            this.$emit('page-changed', parseInt(pageNumber));
        }
      }
    }
  }
};
</script>

<style scoped>
/* Base styles for pagination container */
.flex {
  display: flex;
}

.justify-center {
  justify-content: center;
}

.mt-8 {
  margin-top: 2rem;
}

/* Navigation Container */
.rounded-lg {
  border-radius: 0.5rem;
}

.shadow-md {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.bg-white {
  background-color: #ffffff;
}

.overflow-hidden {
  overflow: hidden;
}

/* Button Base Styles */
button {
  position: relative;
  display: inline-flex;
  align-items: center;
  padding-left: 1rem;
  padding-right: 1rem;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  border: 1px solid transparent; /* Consistent border */
  font-size: 0.875rem; /* text-sm */
  font-weight: 500; /* font-medium */
  transition-property: all; /* All properties for smooth transitions */
  transition-duration: 300ms;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); /* ease-in-out */
  outline: none; /* Remove default focus outline */
}

button:focus {
  z-index: 10; /* Bring active/focused button to front */
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5); /* Custom focus ring (Tailwind blue-500 with opacity) */
}

/* Disabled Button Styles */
button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Previous/Next Button Specifics */
.px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}
.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

/* Previous/Next active state */
.text-gray-600 {
    color: #4b5563;
}
.hover\:bg-gray-100:hover {
    background-color: #f3f4f6;
}
.text-gray-400 {
    color: #9ca3af;
}

/* Active Page Button */
.bg-blue-600 {
  background-color: #2563eb; /* Darker blue for active */
}
.text-white {
  color: #ffffff;
}
.shadow-inner {
  box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06); /* Subtle inner shadow for active */
}

/* Inactive Page Button */
.text-gray-700 {
  color: #374151;
}

/* SR Only for accessibility */
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
</style>