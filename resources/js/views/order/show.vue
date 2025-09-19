<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-5">
          <div class="card">
            <div class="card-body">
              <h4>Order Details</h4>
              <table class="table table-bordered">
                <tbody>
                  <tr><th>Farm ID</th><td>{{ order.farm_id }}</td></tr>
                  <tr><th>Status</th><td>{{ order.status }}</td></tr>
                  <tr><th>Notes</th><td>{{ order.notes }}</td></tr>
                  <tr><th>Subtotal</th><td>{{ order.subtotal }}</td></tr>
                  <tr><th>Tax Amount</th><td>{{ order.tax_amount }}</td></tr>
                  <tr><th>Delivery Fee</th><td>{{ order.delivery_fee }}</td></tr>
                  <tr><th>Total Amount</th><td>{{ order.total_amount }}</td></tr>
                  <tr><th>Fulfillment Method</th><td>{{ order.fulfillment_method }}</td></tr>
                  <tr><th>Delivery Address</th><td>{{ order.delivery_address }}</td></tr>
                  <tr><th>Delivery Lat</th><td>{{ order.delivery_lat }}</td></tr>
                  <tr><th>Delivery Lng</th><td>{{ order.delivery_lng }}</td></tr>
                  <tr><th>Scheduled Pickup Time</th><td>{{ order.scheduled_pickup_time }}</td></tr>
                  <tr><th>Scheduled Delivery Time</th><td>{{ order.scheduled_delivery_time }}</td></tr>
                </tbody>
              </table>
              <form action="#" @submit.prevent="deleteData(order)">
                <div class="btn-group mt-2">
                  <router-link :to="'/orders/' + order.id + '/edit'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</router-link>
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
        name: 'orderShow',
        created() {
            this.id = this.$route.params.id;
            this.getData();
        },
        beforeCreate() {
            this.loading = true;
        },
        data: () => ({
            id: '',
            order: {},
            loading: true,
        }),
        methods: {
          getData: async function () {
            var url='/api/orders/'+this.id;
            const data = await Network.get(url);
            this.order = data.data;
            this.loading = false;
          },
            deleteData: async function (order) {
                const isConfirmed = await this.$swal.fire({
                  title: 'Are you sure?',
                  text: 'You will not be able to recover this order!',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                });
                if (isConfirmed.isConfirmed) {
                    var url = '/api/orders/' + this.id;
                    await Network.delete(url);
                    this.$router.push('/orders');
                }
            },
        },
    };
</script>