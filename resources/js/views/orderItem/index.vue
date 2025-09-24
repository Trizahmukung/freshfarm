<template>
    <div>
        <loading-message v-if="loading"></loading-message>
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-10">
                        <h4>Order Items</h4>
                    </div>
                    <div class="col-sm-2">
                        <router-link to="/orderitem/create" class="btn btn-sm btn-warning mb-2">
                            <i class="fa fa-plus"></i> Add Order Item
                        </router-link>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product ID</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="orderitem in orderitems" :key="orderitem.id">
                                <td>{{ orderitem.order_id }}</td>
                                <td>{{ orderitem.product_id }}</td>
                                <td>{{ orderitem.quantity }}</td>
                                <td>{{ orderitem.unit_price }}</td>
                                <td>
                                    <router-link :to="'/orderitem/' + orderitem.id" class="btn btn-sm btn-warning">
                                        <i class="fa fa-eye"></i> View
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="btn-group custom-pagination">
                    <button :class="current_page == link.url ? 'btn btn-sm active-page' : 'btn btn-sm'"
                        v-for="(link, index) in links" @click="getData(link.url)" :disabled="link.url == null">
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
        name: 'OrderItemIndex',
        created() {
            this.getData(window.location.origin + '/api/orderitem?page=1');
        },
        beforeCreate() {
            this.loading = true;
        },
        data: () => ({
            orderitems: [],
            links: [],
            current_page: null,
            loading: false,
        }),
        methods: {
            getData: async function (url) {
                const data = await Network.get(url);
                this.orderitems = data.data;
                this.links = data.meta.links;
                this.current_page = url;
                this.loading = false;
            },
        },
    };
</script>