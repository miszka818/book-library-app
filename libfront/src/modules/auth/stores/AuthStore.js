import { defineStore } from "pinia";
import api from "@/api/axios";
import router from "@/router";
import { ref } from "vue";

export const useAuthStore = defineStore("auth", () => {
  const user = ref(null);
  const token = ref(localStorage.getItem("token") || "");
  const errors = ref({});

  if (token.value) {
    api.defaults.headers.common["Authorization"] = `Bearer ${token.value}`;
  }

  const register = async (formData) => {
    errors.value = {};
    try {
      const response = await api.post("/register", formData);
      token.value = response.data.token;
      user.value = response.data.user;
      localStorage.setItem("token", token.value);
      api.defaults.headers.common["Authorization"] = `Bearer ${token.value}`;
      router.push("/books");
    } catch (err) {
      if (err.response && err.response.status === 422) {
        errors.value = err.response.data.errors;
      }
      console.error(err);
    }
  };

  const login = async (formData) => {
    errors.value = {};
    try {
      const response = await api.post("/login", formData);
      token.value = response.data.token;
      localStorage.setItem("token", token.value);
      api.defaults.headers.common["Authorization"] = `Bearer ${token.value}`;

      const me = await api.get("/user");
      user.value = me.data;

      router.push("/books");
    } catch (err) {
      if (err.response && err.response.status === 422) {
        errors.value = err.response.data.errors;
      }
      console.error(err);
    }
  };

  const logout = async () => {
    try {
      await api.post("/logout");
    } catch (err) {
      console.error(err);
    } finally {
      token.value = "";
      user.value = null;
      localStorage.removeItem("token");
      delete api.defaults.headers.common["Authorization"];
      router.push("/login");
    }
  };

  return { user, token, errors, register, login, logout };
});