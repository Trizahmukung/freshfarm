<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
                <div class="card">
                    <div class="card-body">
                        <h4 class="not-margin">Update Product</h4>
                        <form action="#" @submit.prevent="update">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" v-model="formData.name">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" class="form-control" v-model="formData.description">
                            </div>
                            <div class="form-group">
                                <label>Farm ID</label>
                                <input type="number" name="farm_id" class="form-control" v-model="formData.farm_id">
                            </div>
                            <div class="form-group">
                                <label>Category ID</label>
                                <input type="number" name="category_id" class="form-control" v-model="formData.category_id">
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="price" class="form-control" v-model="formData.price">
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" name="unit" class="form-control" v-model="formData.unit">
                            </div>
                            <div class="form-group">
                                <label>Stock Quantity</label>
                                <input type="number" name="stock_quantity" class="form-control" v-model="formData.stock_quantity">
                            </div>
                            <div class="form-group">
                                <label>Harvest Date</label>
                                <input type="date" name="harvest_date" class="form-control" v-model="formData.harvest_date">
                            </div>
                            <div class="form-group">
                                <label>Is Available</label>
                                <input type="checkbox" name="is_available" v-model="formData.is_available">
                            </div>
                            <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit">
                                <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>{{loading_submit ? 'Loading..' : 'Update'}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Network from "../../network-class";
    export default {
        name: 'productEdit',
        created() {
           this.id = this.$route.params.id;
           this.getData();
        },
        data:() => ({
            loading_submit: false,
            id: '',
            errors: [],
            formData: {
                farm_id: '',
                category_id: '',
                name: '',
                slug: '',
                description: '',
                price: '',
                unit: '',
                stock_quantity: '',
                harvest_date: '',
                is_available: false,
            },
            product: {},
        }),
        methods: {
            getData: async function () {
                var url = '/api/product/' + this.id;
                const data = await Network.get(url);
                this.product = data.data;
                this.formData = data.data;
            },
            update: async function (event) {
                this.loading_submit = true;
                var url = '/api/product/' + this.id;
                const data = await Network.update(url, this.formData);
                if (data.error) {
                    this.errors = data.error;
                    this.loading_submit = false;
                } else {
                    this.$router.push('/product/' + data.data.id);
                }
            },
        },
    };
</script>