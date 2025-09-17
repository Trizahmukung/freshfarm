<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-10">
              <h4>Products</h4></div><div class="col-sm-2"><router-link to="/product/create" class="btn btn-sm btn-warning mb-2"><i class="fa fa-plus"></i> Add product</router-link></div></div>
              <div class="table-responsive only-desktop">
          

              <!-- table goes heres -->
              <!-- table goes heres -->
              <!-- table goes heres -->
              <!-- table goes heres -->

          </div>


          <div class="btn-group custom-pagination">
            <button :class="current_page == link.url?'btn btn-sm active-page':'btn btn-sm'" v-for="(link, index) in links" @click="getData(link.url)" :disabled="link.url==null"><span v-html="link.label"></span></button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    import axios from 'axios';
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