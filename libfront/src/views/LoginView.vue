<template>
  <AuthLayout>
    <div class="w-full max-w-[440px] space-y-8">
      
      <div class="flex flex-col items-center">
        <div class="w-20 h-20 bg-primary rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-primary/20">
          <span class="material-symbols-outlined text-white text-4xl">local_library</span>
        </div>
        <h1 class="font-serif text-slate-900 dark:text-slate-100 tracking-tight text-[40px] font-bold leading-tight text-center pb-2">
          Sign In
        </h1>
        <p class="text-slate-500 dark:text-slate-400 font-display text-center">
          Welcome back to your personal collection
        </p>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-4 mt-8">
        
        <div v-if="authStore.error" class="bg-red-100 border border-red-500 text-red-700 p-3 rounded-xl text-sm text-center">
          {{ authStore.error }}
        </div>

        <div class="flex flex-col gap-2">
          <BaseInput 
            v-model="form.email"
            label="Email Address"
            type="email"
            placeholder="name@example.com"
            required
          />
        </div>

        <div class="flex flex-col gap-2">
          <BaseInput 
            v-model="form.password"
            label="Password"
            type="password"
            placeholder="Enter your password"
            required
          >
            <template #labelRight>
              <RouterLink to="/forgot-password" class="text-primary text-sm font-semibold hover:underline decoration-2 underline-offset-4">
                Forgot Password?
              </RouterLink>
            </template>
          </BaseInput>
        </div>

        <div class="pt-4">
          <BaseButton type="submit" :loading="authStore.isLoading">
            <span>Sign In</span>
            <span class="material-symbols-outlined text-lg">login</span>
          </BaseButton>
        </div>
      </form>

      <div class="flex items-center justify-center gap-4 py-4">
        <div class="h-[1px] flex-1 bg-slate-200 dark:bg-slate-800"></div>
        <span class="text-slate-400 text-xs font-medium uppercase tracking-widest">or</span>
        <div class="h-[1px] flex-1 bg-slate-200 dark:bg-slate-800"></div>
      </div>

      <div class="text-center">
        <p class="text-slate-600 dark:text-slate-400 font-display">
          Don't have an account? 
          <RouterLink to="/register" class="text-primary font-bold hover:underline decoration-2 underline-offset-4 ml-1">
            Sign Up
          </RouterLink>
        </p>
      </div>
      
    </div>
  </AuthLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth.store';
import AuthLayout from '@/layouts/AuthLayout.vue';
import BaseInput from '@/components/ui/BaseInput.vue';
import BaseButton from '@/components/ui/BaseButton.vue';

const router = useRouter();
const authStore = useAuthStore();

const form = reactive({
  email: '',
  password: ''
});

const handleLogin = async () => {
  const success = await authStore.login(form.email, form.password);
  
  if (success) {
    router.push('/'); 
  }
};
</script>