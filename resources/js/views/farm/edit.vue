<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
                <div class="card">
                    <div class="card-body">
                        <h4 class="not-margin">Update farm</h4>
                        
                        <!-- Error display section -->
                        <div v-if="errors.length > 0" class="alert alert-danger">
                            <ul class="mb-0">
                                <li v-for="(error, index) in errors" :key="index">{{ error[0] }}</li>
                            </ul>
                        </div>
                        
                        <form action="#" @submit.prevent="update">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" v-model="formData.name" placeholder="Enter farm name">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" v-model="formData.description" placeholder="Enter description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" v-model="formData.address" placeholder="Enter address">
                            </div>
                            <div class="form-group">
                                <label>Latitude</label>
                                <input type="text" name="latitude" class="form-control" v-model="formData.latitude" placeholder="Enter latitude">
                            </div>
                            <div class="form-group">
                                <label>Longitude</label>
                                <input type="text" name="longitude" class="form-control" v-model="formData.longitude" placeholder="Enter longitude">
                            </div>
                            <div class="form-group">
                                <label>Verification Status</label>
                                <select name="verification_status" class="form-control" v-model="formData.verification_status">
                                    <option value="pending">Pending</option>
                                    <option value="verified">Verified</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            
                            <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit">
                                <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span> 
                                {{loading_submit ? 'Loading..' : 'Update'}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Network from "../../network-class";

export default {
    name: 'farmEdit',
    created() {
        this.id = this.$route.params.id;
        this.getData();
    },
    data: () => ({
        loading_submit: false,
        id: '',
        errors: [],
        formData: {
            name: '',
            description: '',
            address: '',
            latitude: '',
            longitude: '',
            verification_status: 'pending',
        },
        farm: [],
    }),
    methods: {
        getData: async function () {
            try {
                var url = '/api/farm/' + this.id;
                const data = await Network.get(url);
                this.farm = data.data;
                
                // Properly assign data to formData to maintain reactivity
                this.formData = {
                    name: data.data.name || '',
                    description: data.data.description || '',
                    address: data.data.address || '',
                    latitude: data.data.latitude || '',
                    longitude: data.data.longitude || '',
                    verification_status: data.data.verification_status || 'pending',
                };
            } catch (error) {
                console.error('Error fetching farm data:', error);
                this.errors = ['Failed to load farm data'];
            }
        },
        update: async function (event) {
            this.loading_submit = true;
            this.errors = []; // Clear previous errors
            
            try {
                var url = '/api/farm/' + this.id;
                const data = await Network.update(url, this.formData);
                
                if (data.error) {
                    this.errors = data.error;
                    this.loading_submit = false;
                } else {
                    this.$router.push('/farm/' + data.data.id);
                }
            } catch (error) {
                console.error('Error updating farm:', error);
                this.errors = ['Failed to update farm'];
                this.loading_submit = false;
            }
        },
    },
};
</script>