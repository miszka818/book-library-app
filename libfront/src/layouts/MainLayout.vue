<template>
  <div class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex">
    
    <div 
      v-if="isMobileMenuOpen" 
      @click="isMobileMenuOpen = false" 
      class="fixed inset-0 bg-slate-900/50 z-40 md:hidden"
    ></div>

    <aside :class="[
      'w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col fixed h-full z-50 transition-transform duration-300 ease-in-out',
      isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
    ]">
      <div class="p-6 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
          <div class="bg-primary rounded-lg p-2 text-white flex items-center justify-center">
            <span class="material-symbols-outlined">auto_stories</span>
          </div>
          <div>
            <h1 class="font-serif text-xl font-bold leading-none">Private Library</h1>
            <p class="text-[10px] text-slate-500 font-medium tracking-wide uppercase">Your Collection</p>
          </div>
        </div>
        <button @click="isMobileMenuOpen = false" class="md:hidden text-slate-500 hover:text-primary">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      
      <nav class="flex-1 px-4 space-y-1">
        <RouterLink to="/" @click="isMobileMenuOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors" :class="[ $route.path === '/' ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' ]">
          <span class="material-symbols-outlined">dashboard</span>
          <span>Dashboard</span>
        </RouterLink>
        <RouterLink to="/catalog" @click="isMobileMenuOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
          <span class="material-symbols-outlined">menu_book</span>
          <span>Catalog</span>
        </RouterLink>
        
        <div class="pt-6 pb-2 px-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Account</div>
        <RouterLink to="/profile" @click="isMobileMenuOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
          <span class="material-symbols-outlined">account_circle</span>
          <span>Profile</span>
        </RouterLink>
      </nav>
      
      <div class="p-4 border-t border-slate-200 dark:border-slate-800">
        <button @click="handleLogout" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 font-medium transition-colors">
          <span class="material-symbols-outlined">logout</span>
          <span>Sign Out</span>
        </button>
      </div>
    </aside>

    <main class="flex-1 flex flex-col min-h-screen transition-all md:ml-64 w-full">
      <header class="h-16 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-4 md:px-8 flex items-center justify-between sticky top-0 z-10 w-full">
        <div class="flex items-center flex-1 gap-4 max-w-xl">
          <button @click="isMobileMenuOpen = true" class="md:hidden p-2 -ml-2 text-slate-500 hover:text-primary">
            <span class="material-symbols-outlined">menu</span>
          </button>
          
          <div class="relative group flex-1 hidden sm:block">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">search</span>
            <input type="text" placeholder="Search your library..." class="w-full bg-slate-100 dark:bg-slate-800 border-none rounded-xl py-2 pl-10 pr-4 focus:ring-2 focus:ring-primary/20 text-sm transition-all outline-none" />
          </div>
        </div>
        
        <div class="flex items-center gap-4">
          <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
              <p class="text-sm font-bold leading-none">{{ authStore.user?.name || 'User' }}</p>
              <p class="text-[10px] text-slate-500 uppercase font-bold mt-1">Reader</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold border-2 border-primary/30">
              {{ authStore.user?.name?.charAt(0) || 'U' }}
            </div>
          </div>
        </div>
      </header>

      <div class="flex-1 overflow-x-hidden">
        <slot />
      </div>
    </main>

  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth.store.js';

const router = useRouter();
const authStore = useAuthStore();

const isMobileMenuOpen = ref(false);

const handleLogout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>