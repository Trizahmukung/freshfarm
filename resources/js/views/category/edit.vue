<template>
    <div>
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="not-margin">Update Category</h4>
                            <router-link :to="'/category/' + id" class="btn btn-sm btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back to Details
                            </router-link>
                        </div>
                        
                        <div v-if="loading" class="text-center py-4">
                            <i class="fas fa-circle-notch fa-spin"></i> Loading category data...
                        </div>
                        
                        <div v-else>
                            <div v-if="errors.length > 0" class="alert alert-danger">
                                <ul class="mb-0">
                                    <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                                </ul>
                            </div>
                            
                            <form action="#" @submit.prevent="update" enctype="multipart/form-data">
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
                                        {{ loading_submit ? 'Updating...' : 'Update' }}
                                    </button>
                                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" @click="resetForm" :disabled="loading_submit">
                                        Reset
                                    </button>
                                    <router-link :to="'/category/' + id" class="btn btn-sm btn-outline-secondary mt-2 ml-2">
                                        Cancel
                                    </router-link>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Network from "../../network-class";

    export default {
        name: 'CategoryEdit',
        data: () => ({
            loading: false,
            loading_submit: false,
            id: '',
            errors: [],
            formData: {
                name: '',
                description: '',
            },
            originalData: {
                name: '',
                description: '',
            },
        }),
        created() {
            this.id = this.$route.params.id;
            if (this.id) {
                this.getData();
            } else {
                this.$router.push('/category');
            }
        },
        methods: {
            getData: async function () {
                this.loading = true;
                this.errors = [];
                
                try {
                    var url = '/api/category/' + this.id;
                    const data = await Network.get(url);
                    if (data && data.data) {
                        this.formData = {
                            name: data.data.name || '',
                            description: data.data.description || '',
                        };
                        // Store original data for reset functionality
                        this.originalData = { ...this.formData };
                    } else {
                        this.$swal.fire({
                            title: 'Not Found',
                            text: 'Category not found.',
                            icon: 'error'
                        }).then(() => {
                            this.$router.push('/category');
                        });
                    }
                } catch (e) {
                    console.error("Error fetching category:", e);
                    this.$swal.fire({
                        title: 'Error',
                        text: 'Failed to load category data.',
                        icon: 'error'
                    }).then(() => {
                        this.$router.push('/category');
                    });
                } finally {
                    this.loading = false;
                }
            },
            update: async function (event) {
                this.loading_submit = true;
                this.errors = [];
                
                // Basic validation
                if (!this.formData.name.trim()) {
                    this.errors = [["Category name is required."]];
                    this.loading_submit = false;
                    return;
                }
                
                var url = '/api/category/' + this.id;
                const form_data_to_send = new FormData();
                
                for (const key in this.formData) {
                    if (this.formData[key] !== null && this.formData[key] !== undefined) {
                        form_data_to_send.append(key, this.formData[key]);
                    }
                }
                
                try {
                    const data = await Network.update(url, form_data_to_send);
                    if (data.error) {
                        this.errors = data.error;
                    } else {
                        // Show success message
                        this.$swal.fire({
                            title: 'Success!',
                            text: 'Category updated successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        this.$router.push('/category/' + data.data.id);
                    }
                } catch (e) {
                    console.error("Error updating category:", e);
                    this.errors = [["An error occurred while updating. Please try again."]];
                } finally {
                    this.loading_submit = false;
                }
            },
            resetForm: function() {
                this.formData = { ...this.originalData };
                this.errors = [];
            }
        },
        watch: {
            '$route.params.id': function(newId) {
                this.id = newId;
                if (this.id) {
                    this.getData();
                }
            }
        }
    };
</script>