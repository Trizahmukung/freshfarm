<template>
  <div>
    <div class="row">
      <div class="col-sm-7">
        <div class="card">
          <div class="card-body">
            <h4 class="not-margin">Create New Product</h4>
            <div v-if="errors.length > 0" class="alert alert-danger">
              <ul class="mb-0">
                <li v-for="(error, idx) in errors" :key="idx">{{ error[0] }}</li>
              </ul>
            </div>
            <form @submit.prevent="saveProduct">
              <div class="form-group">
                <label>Farm</label>
                <select name="farm_id" class="form-select" v-model="formData.farm_id" :disabled="loading_farms">
                  <option value="">Select Farm</option>
                  <option v-for="farm in farms" :key="farm.id" :value="farm.id">{{ farm.name }}</option>
                </select>
                <div v-if="loading_farms" class="text-muted">Loading farms...</div>
                <div v-if="errors.farm_id"><span class="text-danger" role="alert">{{errors.farm_id[0]}}</span></div>
              </div>
              <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-select" v-model="formData.category_id" :disabled="loading_categories">
                  <option value="">Select Category</option>
                  <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
                <div v-if="loading_categories" class="text-muted">Loading categories...</div>
                <div v-if="errors.category_id"><span class="text-danger" role="alert">{{errors.category_id[0]}}</span></div>
              </div>

              <div class="form-group">
                <label>Product Name</label>
                <input type="text" v-model="formData.name" class="form-control" placeholder="Enter product name">
                <div v-if="errors.name"><span class="text-danger" role="alert">{{errors.name[0]}}</span></div>
              </div>
              <div class="form-group">
                <label>Slug</label>
                <input type="text" v-model="formData.slug" class="form-control" placeholder="e.g., product-name">
                <div v-if="errors.slug"><span class="text-danger" role="alert">{{errors.slug[0]}}</span></div>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea v-model="formData.description" class="form-control" rows="4" placeholder="Enter product description"></textarea>
                <div v-if="errors.description"><span class="text-danger" role="alert">{{errors.description[0]}}</span></div>
              </div>

              <div class="form-group">
                <label>Price</label>
                <input type="number" v-model="formData.price" class="form-control" placeholder="Enter price" step="0.01">
                <div v-if="errors.price"><span class="text-danger" role="alert">{{errors.price[0]}}</span></div>
              </div>
              <div class="form-group">
                <label>Unit</label>
                <input type="text" v-model="formData.unit" class="form-control" placeholder="e.g., kg, dozen, piece">
                <div v-if="errors.unit"><span class="text-danger" role="alert">{{errors.unit[0]}}</span></div>
              </div>
              <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" v-model="formData.stock_quantity" class="form-control" placeholder="Enter stock quantity">
                <div v-if="errors.stock_quantity"><span class="text-danger" role="alert">{{errors.stock_quantity[0]}}</span></div>
              </div>
              <div class="form-group">
                <label>Harvest Date</label>
                <input type="date" v-model="formData.harvest_date" class="form-control">
                <div v-if="errors.harvest_date"><span class="text-danger" role="alert">{{errors.harvest_date[0]}}</span></div>
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="is_available_check" v-model="formData.is_available">
                <label class="form-check-label" for="is_available_check">Available for Sale</label>
              </div>

              <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit">
                <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>
                {{ loading_submit ? 'Loading..' : 'Save Product' }}
              </button>
              <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" @click="resetForm" :disabled="loading_submit">
                Reset
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

---

<script>
import Network from "../../network-class"; // Assuming this is your API network class

export default {
  name: 'productCreate',
  data: () => ({
    loading_submit: false,
    loading_farms: false,
    loading_categories: false,
    errors: [],
    farms: [],
    categories: [],
    formData: {
      farm_id: '',
      category_id: '',
      name: '',
      slug: '',
      description: '',
      price: 0,
      unit: '',
      stock_quantity: 0,
      harvest_date: '',
      is_available: true,
    },
  }),
  created() {
    this.getFarms();
    this.getCategories();
  },
  methods: {
    async getFarms() {
      this.loading_farms = true;
      const data = await Network.get('/api/farms');
      this.farms = data.farms || data.data || [];
      this.loading_farms = false;
    },
    async getCategories() {
      this.loading_categories = true;
      const data = await Network.get('/api/categories');
      this.categories = data.categories || data.data || [];
      this.loading_categories = false;
    },
    async saveProduct() {
      this.loading_submit = true;
      this.errors = [];
      const url = '/api/product'; // Adjust this API endpoint as needed
      try {
        const data = await Network.store(url, this.formData);
        if (data.error) {
          this.errors = data.error;
        } else {
          // Assuming the API returns the created product data
          alert('Product created successfully!');
          this.$router.push('/products/' + data.data.id); // Redirect to the new product page
        }
      } catch (e) {
        // Handle network or other errors
        console.error('An error occurred:', e);
        this.errors = [['Something went wrong. Please try again.']];
      } finally {
        this.loading_submit = false;
      }
    },
    resetForm() {
      this.formData = {
        farm_id: '',
        category_id: '',
        name: '',
        slug: '',
        description: '',
        price: 0,
        unit: '',
        stock_quantity: 0,
        harvest_date: '',
        is_available: true,
      };
      this.errors = [];
    },
  },
};
</script>

<style scoped>
.form-group {
  margin-bottom: 1rem;
}
.form-check {
  margin-top: 1rem;
}
</style>