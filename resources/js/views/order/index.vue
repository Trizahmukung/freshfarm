<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-10">
              <h4>Orders</h4></div><div class="col-sm-2"><router-link to="/orders/create" class="btn btn-sm btn-warning mb-2"><i class="fa fa-plus"></i> Add Order</router-link></div></div>
              <div class="table-responsive">
          

              <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Farm ID</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Scheduled Delivery Time</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in orders" :key="order.id">
                <td>{{ order.id }}</td>
                <td>{{ order.farm_id }}</td>
                <td>{{ order.status }}</td>
                <td>{{ order.total_amount }}</td>
                <td>{{ order.scheduled_delivery_time }}</td>
                <td>
                    <div class="btn-group">
                        <router-link :to="'/orders/'+order.id" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i> View</router-link>
                        <router-link :to="'/orders/'+order.id+'/edit'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</router-link>
                    </div>
                </td>
              </tr>
            </tbody>
          </table>

          </div>


          <div class="btn-group custom-pagination">
            <button :class="current_page == link.url?'btn btn-sm active-page':'btn btn-sm'" v-for="(link, index) in links" :key="index" @click="getData(link.url)" :disabled="link.url==null"><span v-html="link.label"></span></button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Network from "../../network-class";
    export default {
        name:'orderIndex',
        created(){
           this.getData(window.location.origin+'/api/orders?page=1');
        },
        beforeCreate(){
          this.loading=true;
        },
      data:() => ({
        orders:[],
        links:[],
        current_page:null,
      }),
      methods: {
          getData: async function (url) {
              const data = await Network.get(url);
              this.orders=data.data;
              this.links=data.meta.links;
              this.current_page=url;
              this.loading=false;
          },
        },
    };
</script>