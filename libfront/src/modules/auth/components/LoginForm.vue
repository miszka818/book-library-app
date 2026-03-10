<template>
  <form @submit.prevent="submit">
    <div>
      <label>Email</label>
      <input v-model="form.email" type="email" />
      <div class="error" v-if="errors.email">{{ errors.email[0] }}</div>
    </div>
    <div>
      <label>Password</label>
      <input v-model="form.password" type="password" />
      <div class="error" v-if="errors.password">{{ errors.password[0] }}</div>
    </div>
    <button type="submit">Login</button>
  </form>
</template>

<script>
import { reactive } from "vue";
import { useAuthStore } from "../stores/AuthStore";

export default {
  setup() {
    const auth = useAuthStore();
    const form = reactive({
      email: "",
      password: "",
    });

    const submit = () => {
      auth.login(form);
    };

    return { form, submit, errors: auth.errors };
  },
};
</script>

<style scoped>
.login-form {
  max-width: 400px;
  margin: 100px auto;
  padding: 2rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  background: #fff;
}

.form-group {
  margin-bottom: 1rem;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.25rem;
}

input {
  width: 100%;
  padding: 0.5rem;
  box-sizing: border-box;
}

button {
  width: 100%;
  padding: 0.75rem;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button[disabled] {
  opacity: 0.6;
  cursor: not-allowed;
}

.error {
  color: red;
  margin-bottom: 1rem;
}
</style>