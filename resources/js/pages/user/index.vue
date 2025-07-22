<template>
    <div class="container">
        <h3 class="text-center mt-4">User List</h3>
        <router-link :to="{ name: 'user.create' }" class="btn btn-success text-end">Create</router-link>
        <div class="container mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody v-if="users.length > 0">
                    <tr v-for="(item, index) in users" :key="index">
                        <th scope="row">{{ (currentPage - 1) * perPage + index + 1 }}</th>
                        <td>{{ item.name }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.role }}</td>
                        <td>
                            <!-- <button @click="editUser(item.id)" class="btn btn-primary btn-sm mx-1">Edit</button> -->
                            <button @click="deleteUser(item.id)" class="btn btn-danger btn-sm mx-0">Delete</button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td :colspan="6" class="no-data">No data found</td>
                    </tr>
                </tbody>
            </table>
            <Pagination :currentPage="currentPage" :totalPages="totalPages" @page-changed="fetchUsers" />
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    name: 'UserList',
    data() {
        return {
            users: [],
            currentPage: 1,
            perPage: 5,
            totalPages: 0,
            loading: false,
        };
    },
    methods: {
        async fetchUsers(page = 1) {
            try {
                const response = await axios.get(`/users`, {
                    params: { page, perPage: this.perPage }
                });
                this.users = response.data.data;
                this.currentPage = response.data.currentPage;
                this.totalPages = response.data.totalPages;
            } catch (error) {
                console.error("Failed to fetch users:", error.message);
            }
        },
        editUser(userId) {
            this.$router.push({ name: 'user.edit', params: { id: userId } });
        },
        deleteUser(userId) {
            this.loading = true;
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/user/delete/${userId}`)
                        .then((response) => {
                            if (response.status === 200) {
                                this.users = this.users.filter(user => user.id !== userId);
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Deleted',
                                    text: 'User has been deleted successfully.',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    toast: true,
                                });
                            }
                        })
                        .catch((error) => {
                            console.error('Delete error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete user.',
                            });
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                } else {
                    this.loading = false;
                }
            });
        },
    },
    created() {
        this.fetchUsers();
    },
};

</script>

<style scoped>
.no-data {
    text-align: center;
    vertical-align: middle;
    height: 20px;
}
</style>