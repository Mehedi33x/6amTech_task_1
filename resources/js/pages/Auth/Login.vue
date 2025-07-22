<template>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
      <h3 class="text-center mb-4">Login</h3>
      <form @submit.prevent="login">
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input
            v-model="email"
            type="email"
            class="form-control"
            id="email"
            placeholder="Enter your email"
            required
          />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input
            v-model="password"
            type="password"
            class="form-control"
            id="password"
            placeholder="Enter your password"
            required
          />
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <p v-if="error" class="text-danger text-center mt-3">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: '',
      error: ''
    };
  },
  methods: {
    async login() {
      try {
        const res = await axios.post('/login', {
          email: this.email,
          password: this.password
        });
        localStorage.setItem('token', res.data.token);
            localStorage.setItem('user', JSON.stringify(res.data.user));
        this.$router.push('/');
      } catch (err) {
        this.error = 'Invalid credentials';
      }
    }
  }
};
</script>

<style scoped>
body {
  background-color: #f8f9fa;
}

.card {
  border-radius: 1rem;
}
</style>
