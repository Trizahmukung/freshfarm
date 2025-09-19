<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="not-margin">Categories List</h4>
                            <router-link to="/category/create" class="btn btn-sm btn-primary">
                                <i class="fa fa-plus"></i> Add New Category
                            </router-link>
                        </div>
                        
                        <div v-if="loading" class="text-center">
                            <i class="fas fa-circle-notch fa-spin"></i> Loading...
                        </div>
                        
                        <div v-else-if="categories.length === 0" class="alert alert-info">
                            No categories found.
                        </div>
                        
                        <div v-else>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(category, index) in categories" :key="category.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ category.name }}</td>
                                        <td>{{ category.description || 'No description' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <router-link :to="'/category/' + category.id" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i> View
                                                </router-link>
                                                <router-link :to="'/category/' + category.id + '/edit'" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i> Edit
                                                </router-link>
                                                <button @click="deleteCategory(category)" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
        name: 'CategoryIndex',
        data: () => ({
            loading: false,
            categories: [],
        }),
        created() {
            this.getData();
        },
        methods: {
            getData: async function () {
                this.loading = true;
                try {
                    const data = await Network.get('/api/category');
                    this.categories = data.data || [];
                } catch (e) {
                    console.error("Error fetching categories:", e);
                    this.categories = [];
                } finally {
                    this.loading = false;
                }
            },
            deleteCategory: async function (category) {
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
                    try {
                        await Network.delete('/api/category/' + category.id);
                        this.$swal.fire(
                            'Deleted!',
                            'The category has been deleted.',
                            'success'
                        );
                        // Refresh the list
                        this.getData();
                    } catch (e) {
                        console.error("Error deleting category:", e);
                        this.$swal.fire(
                            'Error!',
                            'An error occurred while deleting the category.',
                            'error'
                        );
                    }
                }
            },
        },
    };
</script>