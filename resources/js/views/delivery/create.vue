<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
                <div class="card">
                    <div class="card-body">
                        <h4 class="not-margin">Add New Delivery</h4>
                        <div v-if="errors.length > 0" class="alert alert-danger">
                            <ul class="mb-0">
                                <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                            </ul>
                        </div>
                        <form action="#" @submit.prevent="save">
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
                                <textarea name="notes" class="form-control" v-model="formData.notes" placeholder="Enter any special notes"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Estimated Delivery Time</label>
                                <input type="datetime-local" name="estimated_delivery_time" class="form-control" v-model="formData.estimated_delivery_time">
                            </div>
                            <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit"> 
                                <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span> 
                                {{ loading_submit ? 'Loading..' : 'Save' }}
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

<script>
    import axios from 'axios';
    import Network from "../../network-class";
    export default {
        name: 'DeliveryCreate',
        data: () => ({
            loading_submit: false,
            errors: [],
            formData: {
                order_id: '',
                driver_id: '',
                status: 'pending',
                notes: '',
                estimated_delivery_time: '',
                actual_delivery_time: null, // This field won't be in the create form
            },
            orders: [], // Will store a list of available orders
            drivers: [], // Will store a list of available drivers
        }),
        methods: {
            // Function to save the new delivery record
            save: async function () {
                this.loading_submit = true;
                this.errors = [];
                var url = '/api/delivery';
                try {
                    const response = await Network.store(url, this.formData);
                    if (response.data) {
                        this.$router.push('/delivery/' + response.data.id); 
                    } else if (response.error) {
                        this.errors = response.error;
                    }
                } catch (e) {
                    this.errors = e.response.data.errors;
                } finally {
                    this.loading_submit = false;
                }
            },
            // Function to reset the form fields
            resetForm: function () {
                this.formData = {
                    order_id: '',
                    driver_id: '',
                    status: 'pending',
                    notes: '',
                    estimated_delivery_time: '',
                    actual_delivery_time: null,
                };
                this.errors = [];
            },
            // Function to fetch orders and drivers
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
        },
        mounted() {
            this.fetchInitialData();
        }
    };
</script>

