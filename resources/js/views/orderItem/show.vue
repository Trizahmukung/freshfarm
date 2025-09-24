<template>
    <div>
        <loading-message v-if="loading"></loading-message>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Order Item Details</h4>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Order ID</th>
                                    <td>{{ orderitem.order_id }}</td>
                                </tr>
                                <tr>
                                    <th>Product ID</th>
                                    <td>{{ orderitem.product_id }}</td>
                                </tr>
                                <tr>
                                    <th>Quantity</th>
                                    <td>{{ orderitem.quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Unit Price</th>
                                    <td>{{ orderitem.unit_price }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <form action="#" @submit.prevent="deleteData(orderitem)">
                            <div class="btn-group mt-2">
                                <router-link :to="'/orderitem/' + orderitem.id + '/edit'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</router-link>
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
        name: 'OrderItemShow',
        created() {
            this.id = this.$route.params.id;
            this.getData();
        },
        beforeCreate() {
            this.loading = true;
        },
        data: () => ({
            id: '',
            orderitem: {},
            loading: true,
        }),
        methods: {
            getData: async function () {
                var url = '/api/orderitem/' + this.id;
                const data = await Network.get(url);
                this.orderitem = data.data;
                this.loading = false;
            },
            deleteData: async function (orderitem) {
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
                    var url = '/api/orderitem/' + this.id;
                    await Network.delete(url);
                    this.$router.push('/orderitems'); // Redirect to a list of order items
                    this.$swal.fire(
                        'Deleted!',
                        'The order item has been deleted.',
                        'success'
                    );
                }
            },
        },
    };
</script>