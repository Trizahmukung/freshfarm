<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="not-margin">Add New Category</h4>
                            <router-link to="/category" class="btn btn-sm btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </router-link>
                        </div>
                        
                        <div v-if="errors.length > 0" class="alert alert-danger">
                            <ul class="mb-0">
                                <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                            </ul>
                        </div>
                        
                        <form action="#" @submit.prevent="save" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    class="form-control" 
                                    v-model="formData.name" 
                                    placeholder="Enter category name"
                                    required
                                >
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                <textarea 
                                    name="description" 
                                    class="form-control" 
                                    v-model="formData.description" 
                                    placeholder="Enter description"
                                    rows="3"
                                ></textarea>
                            </div>
                            
                            <div class="form-group">
                                <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit"> 
                                    <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span> 
                                    {{ loading_submit ? 'Loading..' : 'Save' }}
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" @click="resetForm" :disabled="loading_submit">
                                    Reset
                                </button>
                                <router-link to="/category" class="btn btn-sm btn-outline-secondary mt-2 ml-2">
                                    Cancel
                                </router-link>
                            </div>
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
        name: 'CategoryCreate',
        data: () => ({
            loading_submit: false,
            errors: [],
            formData: {
                name: '',
                description: '',
            },
        }),
        methods: {
            save: async function () {
                this.loading_submit = true;
                this.errors = [];
                
                // Basic validation
                if (!this.formData.name.trim()) {
                    this.errors = [["Category name is required."]];
                    this.loading_submit = false;
                    return;
                }
                
                var url = '/api/category';

                // Create FormData to handle file uploads
                const form_data_to_send = new FormData();
                for (const key in this.formData) {
                    if (this.formData[key] !== null && this.formData[key] !== undefined) {
                        form_data_to_send.append(key, this.formData[key]);
                    }
                }

                try {
                    const data = await Network.store(url, form_data_to_send);
                    if (data.error) { 
                        this.errors = data.error; 
                    } else { 
                        // Show success message
                        this.$swal.fire({
                            title: 'Success!',
                            text: 'Category created successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        this.$router.push('/category/' + data.data.id); 
                    }
                } catch (e) {
                    console.error("Error saving category:", e);
                    // Handle network or other errors here
                    this.errors = [["An error occurred while saving. Please try again."]];
                } finally {
                    this.loading_submit = false;
                }
            },
            resetForm: function () {
                this.formData = {
                    name: '',
                    description: '',
                };
                this.errors = [];
            },
        },
    };
</script>