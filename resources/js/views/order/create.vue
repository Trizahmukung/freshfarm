<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
                <template>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="not-margin">Add New Order</h4>
                            <div v-if="errors.length > 0" class="alert alert-danger">
                                <ul class="mb-0">
                                    <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                                </ul>
                            </div>
                            <form action="#" @submit.prevent="save">
                                <div class="form-group">
                                    <label>Farm ID</label>
                                    <input type="number" name="farm_id" class="form-control" v-model="formData.farm_id" placeholder="Enter Farm ID">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <input type="text" name="status" class="form-control" v-model="formData.status" placeholder="Enter status">
                                </div>
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea name="notes" class="form-control" v-model="formData.notes" placeholder="Enter notes"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Subtotal</label>
                                    <input type="number" name="subtotal" class="form-control" v-model="formData.subtotal" placeholder="Enter subtotal">
                                </div>
                                <div class="form-group">
                                    <label>Tax Amount</label>
                                    <input type="number" name="tax_amount" class="form-control" v-model="formData.tax_amount" placeholder="Enter tax amount">
                                </div>
                                <div class="form-group">
                                    <label>Delivery Fee</label>
                                    <input type="number" name="delivery_fee" class="form-control" v-model="formData.delivery_fee" placeholder="Enter delivery fee">
                                </div>
                                <div class="form-group">
                                    <label>Total Amount</label>
                                    <input type="number" name="total_amount" class="form-control" v-model="formData.total_amount" placeholder="Enter total amount">
                                </div>
                                <div class="form-group">
                                    <label>Fulfillment Method</label>
                                    <input type="text" name="fulfillment_method" class="form-control" v-model="formData.fulfillment_method" placeholder="Enter fulfillment method">
                                </div>
                                <div class="form-group">
                                    <label>Delivery Address</label>
                                    <input type="text" name="delivery_address" class="form-control" v-model="formData.delivery_address" placeholder="Enter delivery address">
                                </div>
                                <div class="form-group">
                                    <label>Delivery Latitude</label>
                                    <input type="text" name="delivery_lat" class="form-control" v-model="formData.delivery_lat" placeholder="Enter delivery latitude">
                                </div>
                                <div class="form-group">
                                    <label>Delivery Longitude</label>
                                    <input type="text" name="delivery_lng" class="form-control" v-model="formData.delivery_lng" placeholder="Enter delivery longitude">
                                </div>
                                <div class="form-group">
                                    <label>Scheduled Pickup Time</label>
                                    <input type="datetime-local" name="scheduled_pickup_time" class="form-control" v-model="formData.scheduled_pickup_time">
                                </div>
                                <div class="form-group">
                                    <label>Scheduled Delivery Time</label>
                                    <input type="datetime-local" name="scheduled_delivery_time" class="form-control" v-model="formData.scheduled_delivery_time">
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
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Network from "../../network-class";
    export default {
        name: 'OrderCreate',
        data: () => ({
            loading_submit: false,
            errors: [],
            formData: {
                farm_id: '',
                status: '',
                notes: '',
                subtotal: '',
                tax_amount: '',
                delivery_fee: '',
                total_amount: '',
                fulfillment_method: '',
                delivery_address: '',
                delivery_lat: '',
                delivery_lng: '',
                scheduled_pickup_time: '',
                scheduled_delivery_time: '',
            },
        }),
        methods: {
            save: async function () {
                this.loading_submit = true;
                this.errors = [];
                var url = '/api/orders';
                const data = await Network.store(url, this.formData);
                if (data.error) { 
                    this.errors = data.error; 
                    this.loading_submit = false; 
                }
                else { 
                    this.$router.push('/orders/' + data.data.id); 
                }
            },
            resetForm: function () {
                this.formData = {
                    farm_id: '',
                    status: '',
                    notes: '',
                    subtotal: '',
                    tax_amount: '',
                    delivery_fee: '',
                    total_amount: '',
                    fulfillment_method: '',
                    delivery_address: '',
                    delivery_lat: '',
                    delivery_lng: '',
                    scheduled_pickup_time: '',
                    scheduled_delivery_time: '',
                };
                this.errors = [];
            },
        },
    };
</script>