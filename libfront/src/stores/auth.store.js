import { defineStore } from 'pinia';
import { ref } from 'vue';
import { authApi } from '@/api/auth.api.js';

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null);
  const isLoading = ref(false);
  const error = ref(null);

  const login = async (email, password) => {
    isLoading.value = true;
    error.value = null;
    try {
      const response = await authApi.login({ email, password });
      const { user: userData, token } = response.data;
      
      localStorage.setItem('token', token);
      user.value = userData;
      return true; 
    } catch (err) {
      if (err.response?.data?.errors) {
         error.value = err.response.data.errors.email?.[0] || 'Błąd logowania.';
      } else {
         error.value = err.response?.data?.message || 'Wystąpił nieoczekiwany błąd.';
      }
      return false; 
    } finally {
      isLoading.value = false;
    }
  };

  const register = async (userData) => {
    isLoading.value = true;
    error.value = null;
    try {
      const response = await authApi.register(userData);
      const { user: newUserData, token } = response.data;
      
      localStorage.setItem('token', token);
      user.value = newUserData;
      return true;
    } catch (err) {
      if (err.response?.data?.errors) {
         const firstErrorKey = Object.keys(err.response.data.errors)[0];
         error.value = err.response.data.errors[firstErrorKey][0];
      } else {
         error.value = err.response?.data?.message || 'Wystąpił błąd podczas rejestracji.';
      }
      return false; 
    } finally {
      isLoading.value = false;
    }
  };

  const getUser = async () => {
    if (!localStorage.getItem('token')) return;
    try {
      const response = await authApi.fetchUser();
      user.value = response.data;
    } catch (err) {
      localStorage.removeItem('token');
    }
  };

  const logout = async () => {
    try {
      await authApi.logout();
    } catch (err) {
      console.error(err);
    } finally {
      localStorage.removeItem('token');
      user.value = null;
    }
  };

  return { user, isLoading, error, login, register, getUser, logout };
});