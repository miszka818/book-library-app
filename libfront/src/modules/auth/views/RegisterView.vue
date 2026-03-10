<template>
  <div class="register-view">
    <RegisterForm />
  </div>
</template>

<script>
import RegisterForm from "../components/RegisterForm.vue"

export default {
  name: "RegisterView",
  components: {
    RegisterForm
  }
}
</script>

<style scoped>
.register-view {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: #f5f5f5;
}
</style>