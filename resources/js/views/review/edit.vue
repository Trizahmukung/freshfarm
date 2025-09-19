<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
                <div class="card">
                    <div class="card-body">
                        <h4 class="not-margin">Update Review</h4>
                        <div v-if="errors.length > 0" class="alert alert-danger">
                            <ul class="mb-0">
                                <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                            </ul>
                        </div>
                        <form action="#" @submit.prevent="update">
                            <div class="form-group">
                                <label>Order ID</label>
                                <input type="text" name="order_id" class="form-control" v-model="formData.order_id">
                            </div>
                            <div class="form-group">
                                <label>Product ID</label>
                                <input type="text" name="product_id" class="form-control" v-model="formData.product_id">
                            </div>
                            <div class="form-group">
                                <label>Farm ID</label>
                                <input type="text" name="farm_id" class="form-control" v-model="formData.farm_id">
                            </div>
                            <div class="form-group">
                                <label>User ID</label>
                                <input type="text" name="user_id" class="form-control" v-model="formData.user_id">
                            </div>
                            <div class="form-group">
                                <label>Rating (1-5)</label>
                                <input type="number" name="rating" class="form-control" v-model="formData.rating">
                            </div>
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea name="comment" class="form-control" v-model="formData.comment"></textarea>
                            </div>
                            <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit">
                                <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>
                                {{loading_submit ? 'Loading..' : 'Update'}}
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
        name:'reviewEdit',
        created(){
           this.id=this.$route.params.id;
           this.getData();
        },
      data:() => ({
        loading_submit:false,
        id:'',
        errors:[],
        formData: {
              order_id: '',
              product_id: '',
              farm_id: '',
              user_id: '',
              rating: '',
              comment: '',
            },
          review:[],
      }),
      methods: {
        getData: async function () {
            var url='/api/reviews/'+this.id;
            const data = await Network.get(url);
            this.review=data.data;
            this.formData=data.data;
          },
          update: async function (event) {
            this.loading_submit=true;
            var url='/api/reviews/'+this.id;
            const data = await Network.update(url, this.formData);
            if(data.error){
                this.errors=data.error; 
                this.loading_submit=false;
            } else {
                this.$router.push('/reviews/'+data.data.id);
            }
          },
        },
    };
    </script>