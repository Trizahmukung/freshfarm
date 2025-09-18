<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <h4>Farm Details</h4>
              
              <table class="table table-bordered">
                <tbody>
                  <tr><th>Name</th><td>{{ farm.name }}</td></tr>
                  <tr><th>Description</th><td>{{ farm.description }}</td></tr>
                  <tr><th>Address</th><td>{{ farm.address }}</td></tr>
                  <tr><th>Latitude</th><td>{{ farm.latitude }}</td></tr>
                  <tr><th>Longitude</th><td>{{ farm.longitude }}</td></tr>
                  <tr><th>Verification Status</th><td>{{ farm.verification_status }}</td></tr>
                </tbody>
              </table>

              <form action="#" @submit.prevent="deleteData(farm)" >
              <div class="btn-group mt-2">
                <router-link :to="'/farm/'+farm.id+'/edit'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</router-link>
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
    import axios from 'axios'
    export default {
        name:'farmShow',
        created(){
          this.id=this.$route.params.id;
          this.getData();
        },
        beforeCreate(){
          this.loading=true;
        },
        data:() => ({
        id:'',
        farm:[],
      }),
      methods: {
          getData: async function () {
            var url='/api/farm/'+this.id;
            const data = await Network.get(url);
            this.farm=data.data;
            this.loading=false;
          },
          deleteData: async function (farm) {
            const isConfirmed = await this.$swal.fire();
            if(isConfirmed.isConfirmed){
              var url='/api/farm/'+this.id;
              await Network.delete(url);
              this.$router.push('/farm');
            }

          },
        },
    };
    </script>