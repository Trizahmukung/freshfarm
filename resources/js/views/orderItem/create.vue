<template>
    <div>
        <div class="row">
            <div class="col-sm-5">
                <template>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="not-margin">Add New Order Item</h4>
                            <div v-if="errors.length > 0" class="alert alert-danger">
                                <ul class="mb-0">
                                    <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                                </ul>
                            </div>
                            <form action="#" @submit.prevent="save">
                                <div class="form-group">
                                    <label>Order ID</label>
                                    <input type="number" name="order_id" class="form-control" v-model="formData.order_id" placeholder="Enter order ID">
                                </div>
                                <div class="form-group">
                                    <label>Product ID</label>
                                    <input type="number" name="product_id" class="form-control" v-model="formData.product_id" placeholder="Enter product ID">
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" name="quantity" class="form-control" v-model="formData.quantity" placeholder="Enter quantity">
                                </div>
                                <div class="form-group">
                                    <label>Unit Price</label>
                                    <input type="number" step="0.01" name="unit_price" class="form-control" v-model="formData.unit_price" placeholder="Enter unit price">
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
        name: 'OrderItemCreate',
        data: () => ({
            loading_submit: false,
            errors: [],
            formData: {
                order_id: '',
                product_id: '',
                quantity: '',
                unit_price: '',
            },
        }),
        methods: {
            save: async function () {
                this.loading_submit = true;
                this.errors = [];
                var url = '/api/orderitem';
                const data = await Network.store(url, this.formData);
                if (data.error) {
                    this.errors = data.error;
                    this.loading_submit = false;
                }
                else {
                    // You might want to redirect to a different page or show a success message
                    // For example, redirect to the new order item's detail page or the orders list
                    this.$router.push('/order/' + this.formData.order_id);
                }
            },
            resetForm: function () {
                this.formData = {
                    order_id: '',
                    product_id: '',
                    quantity: '',
                    unit_price: '',
                };
                this.errors = [];
            },
        },
    };
</script>