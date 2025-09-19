<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <h4>Review Details</h4>
              <table class="table table-bordered">
                <tbody>
                  <tr><th>Order ID</th><td>{{ review.order_id }}</td></tr>
                  <tr><th>Product ID</th><td>{{ review.product_id }}</td></tr>
                  <tr><th>Farm ID</th><td>{{ review.farm_id }}</td></tr>
                  <tr><th>User ID</th><td>{{ review.user_id }}</td></tr>
                  <tr><th>Rating</th><td>{{ review.rating }}</td></tr>
                  <tr><th>Comment</th><td>{{ review.comment }}</td></tr>
                </tbody>
              </table>
              <form action="#" @submit.prevent="deleteData(review)">
                <div class="btn-group mt-2">
                  <router-link :to="'/reviews/' + review.id + '/edit'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</router-link>
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
        name: 'reviewShow',
        created() {
            this.id = this.$route.params.id;
            this.getData();
        },
        beforeCreate() {
            this.loading = true;
        },
        data: () => ({
            id: '',
            review: {},
            loading: true,
        }),
        methods: {
          getData: async function () {
            var url='/api/reviews/'+this.id;
            const data = await Network.get(url);
            this.review=data.data;
            this.loading=false;
          },
          deleteData: async function (review) {
            const isConfirmed = await this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });
            if (isConfirmed.isConfirmed) {
                var url = '/api/reviews/' + this.id;
                await Network.delete(url);
                this.$router.push('/reviews');
                this.$swal.fire(
                    'Deleted!',
                    'Your review has been deleted.',
                    'success'
                );
            }
          }
        },
    };
</script>