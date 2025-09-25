<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-10">
              <h4>Products</h4></div><div class="col-sm-2"><router-link to="/product/create" class="btn btn-sm btn-warning mb-2"><i class="fa fa-plus"></i> Add product</router-link></div></div>
              <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products">
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.stock_quantity }}</td>
                <td><router-link :to="'/product/' + product.id" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i> View</router-link></td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="btn-group custom-pagination">
            <button :class="current_page == link.url?'btn btn-sm active-page':'btn btn-sm'" v-for="(link, index) in links" @click="getData(link.url)" :disabled="link.url==null"><span v-html="link.label"></span></button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    import Network from "../../network-class";
    export default {
        name:'productIndex',
        created(){
           this.getData(window.location.origin+'/api/product?page=1');
        },
        beforeCreate(){
          this.loading=true;
        },
      data:() => ({
        products:[],
        links:[],
        current_page:null,
        loading: true,
      }),
      methods: {
          getData: async function (url) {
              const data = await Network.get(url);
              this.products=data.data;
              this.links=data.meta.links;
              this.current_page=url;
              this.loading=false;
          },
        },
    };
</script>