<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h4>Delivery Details</h4>
              <table class="table table-bordered">
                <tbody>
                  <tr><th>Order ID</th><td>{{ delivery.order_id }}</td></tr>
                  <tr><th>Driver ID</th><td>{{ delivery.driver_id }}</td></tr>
                  <tr><th>Status</th><td>{{ delivery.status }}</td></tr>
                  <tr><th>Notes</th><td>{{ delivery.notes }}</td></tr>
                  <tr><th>Estimated Delivery Time</th><td>{{ delivery.estimated_delivery_time }}</td></tr>
                  <tr><th>Actual Delivery Time</th><td>{{ delivery.actual_delivery_time }}</td></tr>
                </tbody>
              </table>
              <form action="#" @submit.prevent="deleteData(delivery)">
                <div class="btn-group mt-2">
                  <router-link :to="'/delivery/' + delivery.id + '/edit'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</router-link>
                  <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                </div>
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
        name: 'DeliveryShow',
        created() {
            this.id = this.$route.params.id;
            this.getData();
        },
        beforeCreate() {
            this.loading = true;
        },
        data: () => ({
            id: '',
            delivery: {},
            loading: true,
        }),
        methods: {
          // Fetches the delivery data from the API
          getData: async function () {
            var url = '/api/delivery/' + this.id;
            try {
              const data = await Network.get(url);
              this.delivery = data.data;
            } catch (error) {
              console.error("Error fetching delivery data:", error);
            } finally {
              this.loading = false;
            }
          },

          // Handles the deletion of the delivery record
          deleteData: async function (delivery) {
              // Using a simple browser confirm for demonstration. 
              // You can replace this with a more advanced confirmation dialog like SweetAlert2.
              const isConfirmed = confirm("Are you sure you want to delete this delivery record?");

              if (isConfirmed) {
                  var url = '/api/delivery/' + this.id;
                  try {
                      await Network.delete(url);
                      this.$router.push('/delivery'); // Redirect to the delivery list page after deletion
                  } catch (error) {
                      console.error("Error deleting delivery record:", error);
                  }
              }
          },
        },
    };
</script>