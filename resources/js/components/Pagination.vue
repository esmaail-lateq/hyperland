<template>
  <div class="flex justify-center mt-4">
    <nav class="inline-flex rounded-md shadow">
      <!-- Previous Page Link -->
      <button 
        @click="changePage(currentPage - 1)" 
        :disabled="!hasPreviousPage"
        :class="[
          'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium',
          hasPreviousPage ? 'text-gray-500 hover:bg-gray-50' : 'text-gray-200 cursor-not-allowed'
        ]"
      >
        <span class="sr-only">Previous</span>
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
      </button>

      <!-- Page Number Links -->
      <template v-for="(link, index) in visiblePageLinks" :key="index">
        <button 
          @click="changePage(link.page)" 
          :disabled="link.active || link.url === null"
          :class="[
            'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium',
            link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:bg-gray-50',
            !link.url ? 'text-gray-200 cursor-not-allowed' : ''
          ]"
        >
          {{ link.label }}
        </button>
      </template>

      <!-- Next Page Link -->
      <button 
        @click="changePage(currentPage + 1)" 
        :disabled="!hasNextPage"
        :class="[
          'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium',
          hasNextPage ? 'text-gray-500 hover:bg-gray-50' : 'text-gray-200 cursor-not-allowed'
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
      return !lastLink.active;
    },
    
    visiblePageLinks() {
      // Process links to display a reasonable number of pages
      // Filter out prev/next links and keep numbered pages
      return this.links.filter(link => 
        link.label !== '&laquo; Previous' && 
        link.label !== 'Next &raquo;'
      ).map(link => {
        return {
          label: link.label,
          url: link.url,
          active: link.active,
          page: link.url ? parseInt(link.label) : null
        };
      });
    }
  },
  
  methods: {
    changePage(page) {
      if (page && page > 0) {
        this.$emit('page-changed', page);
      }
    }
  }
};
</script> 