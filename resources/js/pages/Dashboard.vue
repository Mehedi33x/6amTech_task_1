<template>
  <div>
    <h1 class="mt-4">Dashboard</h1>
    <h5>Welcome, {{ user.name }}</h5>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Dashboard',
  data() {
    return {
      user: {}
    };
  },
  async created() {
    try {
      const token = localStorage.getItem('token');
      const res = await axios.get('/user', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      this.user = res.data;
    } catch {
      this.$router.push('/login');
    }
  }
};
</script>
