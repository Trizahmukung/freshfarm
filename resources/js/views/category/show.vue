<template>
    <div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Category Details</h4>
                            <router-link to="/category" class="btn btn-sm btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </router-link>
                        </div>
                        
                        <div v-if="loading" class="text-center py-4">
                            <i class="fas fa-circle-notch fa-spin"></i> Loading category details...
                        </div>
                        
                        <div v-else-if="!category.id" class="alert alert-warning">
                            Category not found.
                        </div>
                        
                        <div v-else>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%">ID</th>
                                        <td>{{ category.id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ category.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ category.description || 'No description provided' }}</td>
                                    </tr>
                                    <tr v-if="category.created_at">
                                        <th>Created At</th>
                                        <td>{{ formatDate(category.created_at) }}</td>
                                    </tr>
                                    <tr v-if="category.updated_at">
                                        <th>Updated At</th>
                                        <td>{{ formatDate(category.updated_at) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="btn-group mt-3">
                                <router-link :to="'/category/' + category.id + '/edit'" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </router-link>
                                <button @click="deleteData(category)" class="btn btn-sm btn-danger" :disabled="deleting">
                                    <span v-if="deleting"><i class="fas fa-circle-notch fa-spin"></i></span>
                                    <i v-else class="fa fa-trash"></i> 
                                    {{ deleting ? 'Deleting...' : 'Delete' }}
                                </button>
                                <router-link to="/category" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-list"></i> View All
                                </router-link>
                            </div>
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
        name: 'CategoryShow',
        data: () => ({
            id: '',
            category: {},
            loading: false,
            deleting: false,
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
                var url = '/api/category/' + this.id;
                try {
                    const data = await Network.get(url);
                    if (data && data.data) {
                        this.category = data.data;
                    } else {
                        this.category = {};
                        this.$swal.fire({
                            title: 'Not Found',
                            text: 'Category not found.',
                            icon: 'error'
                        });
                    }
                } catch (e) {
                    console.error("Error fetching category:", e);
                    this.category = {};
                    this.$swal.fire({
                        title: 'Error',
                        text: 'Failed to load category details.',
                        icon: 'error'
                    }).then(() => {
                        this.$router.push('/category');
                    });
                } finally {
                    this.loading = false;
                }
            },
            deleteData: async function (category) {
                const isConfirmed = await this.$swal.fire({
                    title: 'Are you sure?',
                    text: `You will not be able to recover "${category.name}"!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                });
                
                if (isConfirmed.isConfirmed) {
                    this.deleting = true;
                    try {
                        var url = '/api/category/' + this.id;
                        await Network.delete(url);
                        this.$swal.fire(
                            'Deleted!',
                            'The category has been deleted.',
                            'success'
                        );
                        this.$router.push('/category');
                    } catch (e) {
                        console.error("Error deleting category:", e);
                        this.$swal.fire(
                            'Error!',
                            'An error occurred while deleting the category.',
                            'error'
                        );
                    } finally {
                        this.deleting = false;
                    }
                }
            },
            formatDate: function(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
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