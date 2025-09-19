<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
                <div class="card">
                    <div class="card-body">
                        <h4 class="not-margin">Update Delivery</h4>
                        <div v-if="errors.length > 0" class="alert alert-danger">
                            <ul class="mb-0">
                                <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                            </ul>
                        </div>
                        <form action="#" @submit.prevent="update">
                            <div class="form-group">
                                <label>Order ID</label>
                                <select name="order_id" class="form-control" v-model="formData.order_id">
                                    <option v-for="order in orders" :key="order.id" :value="order.id">{{ order.id }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Driver ID</label>
                                <select name="driver_id" class="form-control" v-model="formData.driver_id">
                                    <option v-for="driver in drivers" :key="driver.id" :value="driver.id">{{ driver.id }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" v-model="formData.status">
                                    <option value="pending">Pending</option>
                                    <option value="in_transit">In Transit</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control" v-model="formData.notes"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Estimated Delivery Time</label>
                                <input type="datetime-local" name="estimated_delivery_time" class="form-control" v-model="formData.estimated_delivery_time">
                            </div>
                            <div class="form-group">
                                <label>Actual Delivery Time</label>
                                <input type="datetime-local" name="actual_delivery_time" class="form-control" v-model="formData.actual_delivery_time">
                            </div>
                            <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit">
                                <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>
                                {{ loading_submit ? 'Loading..' : 'Update' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Network from "../../network-class";
    export default {
        name: 'DeliveryEdit',
        created() {
           this.id = this.$route.params.id;
           this.getData();
           this.fetchInitialData();
        },
        data: () => ({
          loading_submit: false,
          id: '',
          errors: [],
          formData: {
              order_id: '',
              driver_id: '',
              status: '',
              notes: '',
              estimated_delivery_time: '',
              actual_delivery_time: '',
          },
          orders: [],
          drivers: [],
        }),
        methods: {
          // Fetches the specific delivery data to be edited
          getData: async function () {
              var url = '/api/delivery/' + this.id;
              try {
                  const data = await Network.get(url);
                  this.formData = data.data;
                  // Handle date-time formatting for input fields
                  if (this.formData.estimated_delivery_time) {
                      this.formData.estimated_delivery_time = this.formatDateForInput(this.formData.estimated_delivery_time);
                  }
                  if (this.formData.actual_delivery_time) {
                      this.formData.actual_delivery_time = this.formatDateForInput(this.formData.actual_delivery_time);
                  }
              } catch (error) {
                  console.error("Error fetching delivery data:", error);
              }
          },

          // Fetches the lists of orders and drivers for the dropdowns
          fetchInitialData: async function () {
              try {
                  const ordersResponse = await axios.get('/api/orders');
                  this.orders = ordersResponse.data.data;
                  const driversResponse = await axios.get('/api/drivers');
                  this.drivers = driversResponse.data.data;
              } catch (error) {
                  console.error("Error fetching initial data:", error);
              }
          },
          
          // Helper function to format date-time strings for datetime-local input
          formatDateForInput(dateString) {
              const date = new Date(dateString);
              const year = date.getFullYear();
              const month = (date.getMonth() + 1).toString().padStart(2, '0');
              const day = date.getDate().toString().padStart(2, '0');
              const hours = date.getHours().toString().padStart(2, '0');
              const minutes = date.getMinutes().toString().padStart(2, '0');
              return `${year}-${month}-${day}T${hours}:${minutes}`;
          },

          // Sends the updated data to the API
          update: async function () {
            this.loading_submit = true;
            this.errors = [];
            var url = '/api/delivery/' + this.id;
            try {
                const data = await Network.update(url, this.formData);
                if (data.error) {
                    this.errors = data.error;
                } else {
                    this.$router.push('/delivery/' + data.data.id);
                }
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading_submit = false;
            }
          },
        },
    };
</script>

