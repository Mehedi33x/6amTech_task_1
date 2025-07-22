<template>
  <div class="container d-flex flex-column justify-content-center align-items-center vh-100 text-center">
    <h1 class="display-1 fw-bold text-danger">404</h1>
    <h2 class="mb-4 text-muted">Oops! Page Not Found</h2>
    <p class="mb-4 text-secondary">
      The page you’re looking for doesn’t exist or you don’t have permission to view it.
    </p>
    <router-link to="/" class="btn btn-primary btn-lg">
      <i class="fas fa-home me-2"></i>Back to Dashboard
    </router-link>
  </div>
</template>

<script>
export default {
  name: "NotFound"
};
</script>
