<template>
  <div>
    <loading-message v-if="loading"></loading-message>
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-10">
            <h4>Farms</h4>
          </div>
          <div class="col-sm-2">
            <router-link to="/farm/create" class="btn btn-sm btn-warning mb-2">
              <i class="fa fa-plus"></i> Add farm
            </router-link>
          </div>
        </div>
        
        <div class="table-responsive only-desktop">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <!-- <th>Description</th> -->
                <th>Address</th>
                <!-- <th>Coordinates</th> -->
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="farms.length === 0 && !loading">
                <td colspan="7" class="text-center text-muted">
                  No farms found. <router-link to="/farm/create">Add your first farm</router-link>
                </td>
              </tr>
              <tr v-for="(farm, index) in farms" :key="farm.id">
                <td>{{ getRowNumber(index) }}</td>
                <td>
                  <strong>{{ farm.name }}</strong>
                </td>
                <!-- <td>
                  <span v-if="farm.description" :title="farm.description">
                    {{ truncateText(farm.description, 50) }}
                  </span>
                  <span v-else class="text-muted">No description</span>
                </td> -->
                <td>
                  <span v-if="farm.address" :title="farm.address">
                    {{ truncateText(farm.address, 40) }}
                  </span>
                  <span v-else class="text-muted">No address</span>
                </td>
                <!-- <td>
                  <small v-if="farm.latitude && farm.longitude">
                    {{ parseFloat(farm.latitude).toFixed(4) }}, 
                    {{ parseFloat(farm.longitude).toFixed(4) }}
                  </small>
                  <span v-else class="text-muted">No coordinates</span>
                </td> -->
                <td>
                  <span>
                    {{farm.verification_status }}
                  </span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    <router-link 
                      :to="'/farm/' + farm.id" 
                      class="btn btn-outline-primary btn-sm"
                      title="View"
                    >
                      <i class="fa fa-eye"></i>
                    </router-link>
                    <router-link 
                      :to="'/farm/' + farm.id + '/edit'" 
                      class="btn btn-outline-secondary btn-sm"
                      title="Edit"
                    >
                      <i class="fa fa-edit"></i>
                    </router-link>
                    <button 
                      @click="confirmDelete(farm)" 
                      class="btn btn-outline-danger btn-sm"
                      title="Delete"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Mobile responsive cards for smaller screens -->
        <div class="d-block d-lg-none">
          <div v-if="farms.length === 0 && !loading" class="alert alert-info text-center">
            No farms found. <router-link to="/farm/create">Add your first farm</router-link>
          </div>
          <div v-for="farm in farms" :key="'mobile-' + farm.id" class="card mb-3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="card-title mb-0">{{ farm.name }}</h6>
                <span :class="getStatusBadgeClass(farm.verification_status)">
                  {{ getStatusLabel(farm.verification_status) }}
                </span>
              </div>
              
              <p v-if="farm.description" class="card-text text-muted small">
                {{ truncateText(farm.description, 80) }}
              </p>
              
              <div v-if="farm.address" class="mb-2">
                <small class="text-muted">
                  <i class="fa fa-map-marker"></i> {{ farm.address }}
                </small>
              </div>
              
              <div v-if="farm.latitude && farm.longitude" class="mb-2">
                <small class="text-muted">
                  <i class="fa fa-globe"></i> 
                  {{ parseFloat(farm.latitude).toFixed(4) }}, {{ parseFloat(farm.longitude).toFixed(4) }}
                </small>
              </div>
              
              <div class="btn-group btn-group-sm w-100" role="group">
                <router-link :to="'/farm/' + farm.id" class="btn btn-outline-primary">
                  <i class="fa fa-eye"></i> View
                </router-link>
                <router-link :to="'/farm/' + farm.id + '/edit'" class="btn btn-outline-secondary">
                  <i class="fa fa-edit"></i> Edit
                </router-link>
                <button @click="confirmDelete(farm)" class="btn btn-outline-danger">
                  <i class="fa fa-trash"></i> Delete
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Pagination -->
        <div class="btn-group custom-pagination">
          <button 
            v-for="(link, index) in links" 
            :key="index"
            :class="current_page == link.url ? 'btn btn-sm active-page' : 'btn btn-sm'" 
            @click="getData(link.url)" 
            :disabled="link.url == null"
          >
            <span v-html="link.label"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Network from "../../network-class";

export default {
  name: 'farmIndex',
  
  created() {
    this.getData(window.location.origin + '/api/farm?page=1');
  },
  
  beforeCreate() {
    this.loading = true;
  },
  
  data: () => ({
    farms: [],
    links: [],
    current_page: null,
    loading: false
  }),
  
  methods: {
    getData: async function (url) {
      this.loading = true;
      try {
        const data = await Network.get(url);
        this.farms = data.data;
        this.links = data.meta.links;
        this.current_page = url;
      } catch (error) {
        console.error('Error fetching farms:', error);
        // You might want to show a toast notification or error message here
      } finally {
        this.loading = false;
      }
    },
    
    getRowNumber(index) {
      // Calculate row number based on current page and items per page
      const currentPageFromUrl = this.getCurrentPageNumber();
      const itemsPerPage = 15; // Adjust based on your pagination settings
      return (currentPageFromUrl - 1) * itemsPerPage + index + 1;
    },
    
    getCurrentPageNumber() {
      if (!this.current_page) return 1;
      const urlParams = new URLSearchParams(this.current_page.split('?')[1]);
      return parseInt(urlParams.get('page')) || 1;
    },
    
    truncateText(text, maxLength) {
      if (!text) return '';
      return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
    },
    
    getStatusLabel(status) {
      const labels = {
        'pending': 'Pending',
        'verified': 'Verified',
        'rejected': 'Rejected',
        'suspended': 'Suspended'
      };
      return labels[status] || status;
    },
    
    getStatusBadgeClass(status) {
      const classes = {
        'pending': 'badge badge-warning',
        'verified': 'badge badge-success', 
        'rejected': 'badge badge-danger',
        'suspended': 'badge badge-secondary'
      };
      return classes[status] || 'badge badge-secondary';
    },
    
    confirmDelete(farm) {
      if (confirm(`Are you sure you want to delete "${farm.name}"? This action cannot be undone.`)) {
        this.deleteFarm(farm.id);
      }
    },
    
    deleteFarm: async function (farmId) {
      try {
        await Network.delete(`${window.location.origin}/api/farm/${farmId}`);
        // Refresh the current page after deletion
        this.getData(this.current_page);
        // You might want to show a success message here
      } catch (error) {
        console.error('Error deleting farm:', error);
        alert('Failed to delete farm. Please try again.');
      }
    }
  }
};
</script>

<style scoped>
.active-page {
  background-color: #007bff;
  color: white;
}

.custom-pagination .btn {
  margin-right: 2px;
}

.table th {
  border-top: none;
  font-weight: 600;
}

.badge {
  font-size: 0.75em;
}

.btn-group-sm > .btn {
  padding: 0.25rem 0.5rem;
}

@media (max-width: 991.98px) {
  .only-desktop {
    display: none;
  }
}

@media (min-width: 992px) {
  .d-block.d-lg-none {
    display: none !important;
  }
}
</style>