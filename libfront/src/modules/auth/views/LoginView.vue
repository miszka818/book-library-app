<template>
  <div class="login-view">
    <LoginForm />
  </div>
</template>

<script>
import LoginForm from "../components/LoginForm.vue"

export default {
  name: "LoginView",
  components: {
    LoginForm
  }
}
</script>

<style scoped>
.login-view {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: #f5f5f5;
}
</style>