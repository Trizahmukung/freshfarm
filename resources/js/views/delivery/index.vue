<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-10">
              <h4>Deliveries</h4></div><div class="col-sm-2"><router-link to="/delivery/create" class="btn btn-sm btn-warning mb-2"><i class="fa fa-plus"></i> Add Delivery</router-link></div></div>
              <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Driver ID</th>
                <th>Status</th>
                <th>Estimated Delivery</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="delivery in deliveries" :key="delivery.id">
                <td>{{ delivery.order_id }}</td>
                <td>{{ delivery.driver_id }}</td>
                <td>{{ delivery.status }}</td>
                <td>{{ delivery.estimated_delivery_time }}</td>
                <td>
                  <router-link :to="'/delivery/' + delivery.id" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i> View</router-link>
                </td>
              </tr>
            </tbody>
          </table>
          </div>

          <div class="btn-group custom-pagination">
            <button :class="current_page == link.url ? 'btn btn-sm active-page' : 'btn btn-sm'" v-for="(link, index) in links" :key="index" @click="getData(link.url)" :disabled="link.url == null"><span v-html="link.label"></span></button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Network from "../../network-class";
    export default {
        name: 'DeliveryIndex',
        created() {
           this.getData(window.location.origin + '/api/delivery?page=1');
        },
        beforeCreate() {
          this.loading = true;
        },
        data: () => ({
          deliveries: [],
          links: [],
          current_page: null,
          loading: false,
        }),
        methods: {
          getData: async function (url) {
              if (!url) {
                  return; // Prevents fetching if URL is null (for prev/next buttons)
              }
              this.loading = true;
              try {
                  const data = await Network.get(url);
                  this.deliveries = data.data;
                  this.links = data.meta.links;
                  this.current_page = url;
              } catch (error) {
                  console.error("Error fetching deliveries:", error);
              } finally {
                  this.loading = false;
              }
          },
        },
    };
</script>