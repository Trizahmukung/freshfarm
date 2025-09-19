<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
                <template>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="not-margin">Add New Review</h4>
                            <div v-if="errors.length > 0" class="alert alert-danger">
                                <ul class="mb-0">
                                    <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                                </ul>
                            </div>
                            <form action="#" @submit.prevent="save">
                                <div class="form-group">
                                    <label>Order ID</label>
                                    <input type="text" name="order_id" class="form-control" v-model="formData.order_id" placeholder="Enter Order ID">
                                </div>
                                <div class="form-group">
                                    <label>Product ID</label>
                                    <input type="text" name="product_id" class="form-control" v-model="formData.product_id" placeholder="Enter Product ID">
                                </div>
                                <div class="form-group">
                                    <label>Farm ID</label>
                                    <input type="text" name="farm_id" class="form-control" v-model="formData.farm_id" placeholder="Enter Farm ID">
                                </div>
                                <div class="form-group">
                                    <label>User ID</label>
                                    <input type="text" name="user_id" class="form-control" v-model="formData.user_id" placeholder="Enter User ID">
                                </div>
                                <div class="form-group">
                                    <label>Rating (1-5)</label>
                                    <input type="number" name="rating" class="form-control" v-model="formData.rating" placeholder="Enter rating (1-5)">
                                </div>
                                <div class="form-group">
                                    <label>Comment</label>
                                    <textarea name="comment" class="form-control" v-model="formData.comment" placeholder="Enter your review comments"></textarea>
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
        name: 'ReviewCreate',
        data: () => ({
            loading_submit: false,
            errors: [],
            formData: {
                order_id: '',
                product_id: '',
                farm_id: '',
                user_id: '',
                rating: '',
                comment: '',
            },
        }),
        methods: {
            save: async function () {
                this.loading_submit = true;
                this.errors = [];
                // The URL for the reviews API endpoint
                var url = '/api/reviews';
                const data = await Network.store(url, this.formData);
                if (data.error) { 
                    this.errors = data.error; 
                    this.loading_submit = false; 
                }
                else { 
                    // Redirect to the newly created review page
                    this.$router.push('/reviews/' + data.data.id); 
                }
            },
            resetForm: function () {
                this.formData = {
                    order_id: '',
                    product_id: '',
                    farm_id: '',
                    user_id: '',
                    rating: '',
                    comment: '',
                };
                this.errors = [];
            },
        },
    };
</script>