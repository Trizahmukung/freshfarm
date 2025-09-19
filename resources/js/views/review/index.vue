<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-10">
                  <h4>Reviews</h4>
                </div>
                <div class="col-sm-2">
                  <router-link to="/reviews/create" class="btn btn-sm btn-warning mb-2"><i class="fa fa-plus"></i> Add Review</router-link>
                </div>
              </div>
              <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Product ID</th>
                <th>Farm ID</th>
                <th>User ID</th>
                <th>Rating</th>
                <th>Comment</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="review in reviews" :key="review.id">
                <td>{{ review.order_id }}</td>
                <td>{{ review.product_id }}</td>
                <td>{{ review.farm_id }}</td>
                <td>{{ review.user_id }}</td>
                <td>{{ review.rating }}</td>
                <td>{{ review.comment }}</td>
                <td><router-link :to="'/reviews/' + review.id" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i> View</router-link></td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="btn-group custom-pagination">
            <button :class="current_page == link.url ? 'btn btn-sm active-page' : 'btn btn-sm'" v-for="(link, index) in links" :key="index" @click="getData(link.url)" :disabled="link.url == null">
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
        name:'reviewIndex',
        created(){
           this.getData(window.location.origin+'/api/reviews?page=1');
        },
        beforeCreate(){
          this.loading=true;
        },
      data:() => ({
        reviews:[],
        links:[],
        current_page:null,
        loading: true,
      }),
      methods: {
          getData: async function (url) {
              const data = await Network.get(url);
              this.reviews = data.data;
              this.links = data.meta.links;
              this.current_page = url;
              this.loading = false;
          },
        },
    };
</script>