<template>
    <div v-if="isAuthenticated" class="d-flex" id="wrapper">
        <div class="bg-dark border-end" id="sidebar-wrapper">
            <div class="sidebar-heading text-white px-3 py-4">My App</div>
            <div class="list-group list-group-flush">
                <router-link class="list-group-item list-group-item-action bg-dark text-white" to="/">
                    Dashboard
                </router-link>
                <router-link class="list-group-item list-group-item-action bg-dark text-white" :to="{ name: 'user.index' }">
                    Users
                </router-link>
                <button class="list-group-item list-group-item-action bg-dark text-white text-start" @click="logout">
                    Logout
                </button>
            </div>
        </div>
        <div id="page-content-wrapper" class="w-100">
            <router-view />
        </div>
    </div>
    <div v-else>
        <router-view />
    </div>
</template>

<script>
export default {
    name: 'App',
    data() {
        return {
            token: localStorage.getItem('token')
        };
    },
    computed: {
        isAuthenticated() {
            return !!this.token;
        }
    },
    methods: {
        logout() {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
    }
};
</script>

<style>
#wrapper {
    display: flex;
    flex-direction: row;
}

#sidebar-wrapper {
    min-width: 250px;
    max-width: 250px;
    height: 100vh;
    position: fixed;
}

#page-content-wrapper {
    margin-left: 250px;
    padding: 1rem;
}
</style>
