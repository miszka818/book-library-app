<template>
  <AuthLayout>
    <div class="w-full max-w-[480px] space-y-8">
      
      <div class="flex flex-col items-center pt-4">
        <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
          <span class="material-symbols-outlined text-primary text-4xl">library_books</span>
        </div>
        <h1 class="text-slate-900 dark:text-slate-100 tracking-tight text-[32px] font-bold leading-tight text-center pb-2">
          Join Private Library
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-base font-normal leading-normal text-center max-w-xs">
          Create an account to start organizing your personal collection
        </p>
      </div>

      <form @submit.prevent="handleRegister" class="flex flex-col gap-4 w-full">
        
        <div v-if="authStore.error" class="bg-red-100 border border-red-500 text-red-700 p-3 rounded-xl text-sm text-center">
          {{ authStore.error }}
        </div>

        <BaseInput 
          v-model="form.name"
          label="Full Name"
          iconLeft="person"
          placeholder="John Doe"
          required
        />

        <BaseInput 
          v-model="form.email"
          label="Email Address"
          type="email"
          iconLeft="mail"
          placeholder="example@email.com"
          required
        />

        <BaseInput 
          v-model="form.password"
          label="Password"
          type="password"
          iconLeft="lock"
          placeholder="••••••••"
          required
        />

        <BaseInput 
          v-model="form.password_confirmation"
          label="Confirm Password"
          type="password"
          iconLeft="lock_reset"
          placeholder="••••••••"
          required
        />

        <div class="pt-4">
          <BaseButton type="submit" :loading="authStore.isLoading">
            <span>Register</span>
            <span class="material-symbols-outlined text-lg">arrow_forward</span>
          </BaseButton>
        </div>
      </form>

      <div class="flex flex-col items-center mt-4">
        <p class="text-slate-600 dark:text-slate-400 text-base font-normal">
          Already have an account? 
          <RouterLink to="/login" class="text-primary font-bold hover:underline ml-1">
            Login
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
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const handleRegister = async () => {
  const success = await authStore.register({
    name: form.name,
    email: form.email,
    password: form.password,
    password_confirmation: form.password_confirmation
  });
  
  if (success) {
    router.push('/'); 
  }
};
</script>