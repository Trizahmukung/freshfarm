<template>
    <div>
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="not-margin">Update Order Item</h4>
                        <div v-if="errors.length > 0" class="alert alert-danger">
                            <ul class="mb-0">
                                <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                            </ul>
                        </div>
                        <form action="#" @submit.prevent="update">
                            <div class="form-group">
                                <label>Order ID</label>
                                <input type="number" name="order_id" class="form-control" v-model="formData.order_id">
                            </div>
                            <div class="form-group">
                                <label>Product ID</label>
                                <input type="number" name="product_id" class="form-control" v-model="formData.product_id">
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="quantity" class="form-control" v-model="formData.quantity">
                            </div>
                            <div class="form-group">
                                <label>Unit Price</label>
                                <input type="number" step="0.01" name="unit_price" class="form-control" v-model="formData.unit_price">
                            </div>
                            <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit">
                                <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>{{ loading_submit ? 'Loading..' : 'Update' }}
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
        name:'OrderItemEdit',
        created(){
            this.id = this.$route.params.id;
            this.getData();
        },
        data:() => ({
            loading_submit: false,
            id: '',
            errors: [],
            formData: {
                order_id: '',
                product_id: '',
                quantity: '',
                unit_price: '',
            },
            orderitem: [],
        }),
        methods: {
            getData: async function () {
                var url = '/api/orderitem/' + this.id;
                const data = await Network.get(url);
                this.orderitem = data.data;
                this.formData = data.data;
            },
            update: async function (event) {
                this.loading_submit = true;
                var url = '/api/orderitem/' + this.id;
                const data = await Network.update(url, this.formData);
                if(data.error){
                    this.errors = data.error;
                    this.loading_submit = false;
                }
                else {
                    this.$router.push('/orderitem/' + data.data.id);
                }
            },
        },
    };
</script>