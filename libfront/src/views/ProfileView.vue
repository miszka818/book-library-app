<template>
  <MainLayout>
    <main class="flex-1 max-w-4xl mx-auto w-full px-4 py-8 lg:py-12 space-y-8">
      
      <section class="flex flex-col md:flex-row items-center md:items-end gap-6 pb-10 border-b border-slate-200 dark:border-slate-800">
        <div class="size-32 rounded-full border-4 border-white dark:border-slate-800 shadow-xl bg-primary/20 text-primary flex items-center justify-center text-5xl font-bold font-serif">
          {{ authStore.user?.name?.charAt(0) || 'U' }}
        </div>
        
        <div class="flex-1 text-center md:text-left space-y-2">
          <div class="flex flex-col md:flex-row md:items-center gap-3 justify-center md:justify-start">
            <h2 class="text-3xl font-serif font-bold text-slate-900 dark:text-slate-100">{{ authStore.user?.name || 'User' }}</h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider border border-primary/20 w-fit mx-auto md:mx-0">
              Reader
            </span>
          </div>
          <p class="text-slate-500 dark:text-slate-400 font-medium flex items-center justify-center md:justify-start gap-2">
            <span class="material-symbols-outlined text-[18px]">calendar_today</span>
            Member since {{ memberSince }}
          </p>
        </div>
      </section>

      <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
          <div class="size-12 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
            <span class="material-symbols-outlined">library_books</span>
          </div>
          <div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Books</p>
            <p class="text-2xl font-bold font-serif text-slate-900 dark:text-slate-100">{{ libraryStore.totalBooks }}</p>
          </div>
        </div>
        
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
          <div class="size-12 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
            <span class="material-symbols-outlined">auto_stories</span>
          </div>
          <div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Books Read</p>
            <p class="text-2xl font-bold font-serif text-slate-900 dark:text-slate-100">{{ libraryStore.finished.length }}</p>
          </div>
        </div>
        
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
          <div class="size-12 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center">
            <span class="material-symbols-outlined">history</span>
          </div>
          <div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Days Active</p>
            <p class="text-2xl font-bold font-serif text-slate-900 dark:text-slate-100">{{ daysActive }}</p>
          </div>
        </div>
      </section>

      <section class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
          <div>
            <h3 class="text-lg font-serif font-bold text-slate-900 dark:text-slate-100">Account Details</h3>
            <p class="text-xs text-slate-500 mt-1">Your core profile information.</p>
          </div>
          <span class="material-symbols-outlined text-slate-400">manage_accounts</span>
        </div>
        
        <div class="p-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Full Name</label>
              <div class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 p-3">
                {{ authStore.user?.name }}
              </div>
            </div>
            <div class="space-y-2">
              <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email Address</label>
              <div class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 p-3">
                {{ authStore.user?.email }}
              </div>
            </div>
          </div>
        </div>
      </section>

    </main>
  </MainLayout>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { useAuthStore } from '@/stores/auth.store.js';
import { useLibraryStore } from '@/stores/library.store.js';

const authStore = useAuthStore();
const libraryStore = useLibraryStore();

onMounted(() => {
  if (libraryStore.userBooks.length === 0) {
    libraryStore.fetchLibrary();
  }
});

const memberSince = computed(() => {
  if (!authStore.user?.created_at) return 'Unknown';
  const date = new Date(authStore.user.created_at);
  return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
});

const daysActive = computed(() => {
  if (!authStore.user?.created_at) return 0;
  const createdAt = new Date(authStore.user.created_at);
  const now = new Date();
  
  const differenceInTime = now.getTime() - createdAt.getTime();
  
  const differenceInDays = Math.floor(differenceInTime / (1000 * 3600 * 24));
  
  return differenceInDays === 0 ? 1 : differenceInDays;
});
</script>