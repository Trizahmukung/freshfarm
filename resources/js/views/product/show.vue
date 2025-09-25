<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <h4>Product Details</h4>
              <table class="table table-bordered">
                <tbody>
                  <tr><th>Name</th><td>{{ product.name }}</td></tr>
                  <tr><th>Description</th><td>{{ product.description }}</td></tr>
                  <tr><th>Farm ID</th><td>{{ product.farm_id }}</td></tr>
                  <tr><th>Category ID</th><td>{{ product.category_id }}</td></tr>
                  <tr><th>Slug</th><td>{{ product.slug }}</td></tr>
                  <tr><th>Price</th><td>{{ product.price }}</td></tr>
                  <tr><th>Unit</th><td>{{ product.unit }}</td></tr>
                  <tr><th>Stock Quantity</th><td>{{ product.stock_quantity }}</td></tr>
                  <tr><th>Harvest Date</th><td>{{ product.harvest_date }}</td></tr>
                  <tr><th>Is Available</th><td>{{ product.is_available }}</td></tr>
                </tbody>
              </table>
              <form action="#" @submit.prevent="deleteData(product)">
                <div class="btn-group mt-2">
                  <router-link :to="'/product/' + product.id + '/edit'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</router-link>
                  <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          </div>
      </div>
    </div>
</template>

<script>
    import Network from "../../network-class";
    export default {
        name: 'productShow',
        components: {},
        created() {
            this.id = this.$route.params.id;
            this.getData();
        },
        beforeCreate() {
            this.loading = true;
        },
        data: () => ({
            id: '',
            product: {},
            loading: true,
        }),
        methods: {
          getData: async function () {
            var url='/api/product/'+this.id;
            const data = await Network.get(url);
            this.product = data.data;
            this.loading = false;
          },
            deleteData: async function (product) {
                const isConfirmed = await this.$swal.fire();
                if (isConfirmed.isConfirmed) {
                    var url = '/api/product/' + this.id;
                    await Network.delete(url);
                    this.$router.push('/product');
                }
            }
        },
    };
</script>