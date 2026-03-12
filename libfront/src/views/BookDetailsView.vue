<template>
  <MainLayout>
    <main class="flex-1 flex justify-center py-8">
      
      <div v-if="booksStore.isLoading || !book" class="flex justify-center items-center w-full py-20">
        <span class="material-symbols-outlined animate-spin text-4xl text-primary">progress_activity</span>
      </div>

      <div v-else class="max-w-5xl w-full px-6 flex flex-col gap-8">
        
        <div class="flex flex-wrap gap-2 text-sm text-slate-500 mb-2">
          <RouterLink to="/catalog" class="hover:text-primary transition-colors">Catalog</RouterLink>
          <span>/</span>
          <span v-if="book.tags && book.tags.length" class="hover:text-primary transition-colors">{{ book.tags[0].name }}</span>
          <span v-if="book.tags && book.tags.length">/</span>
          <span class="text-slate-900 dark:text-white font-medium">{{ book.title }}</span>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start gap-6">
          <div class="flex-1">
            <h1 class="text-4xl md:text-5xl font-serif font-extrabold text-slate-900 dark:text-white leading-tight mb-2">
              {{ book.title }}
            </h1>
            <div class="flex flex-wrap items-center gap-4 mt-4">
              <p class="text-xl text-primary font-medium">{{ book.author || 'Unknown Author' }}</p>
              <span class="h-1 w-1 bg-slate-300 rounded-full"></span>
              <p class="text-slate-500">First Published: {{ book.release_year || 'Unknown' }}</p>
            </div>
          </div>
          
          <div class="flex gap-3 mt-4 md:mt-0">
            <button 
              @click="addToMyBooks"
              :disabled="isAdding"
              class="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-70"
            >
              <span v-if="isAdding" class="material-symbols-outlined animate-spin">progress_activity</span>
              <span v-else class="material-symbols-outlined">library_add</span>
              Add to My Library
            </button>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
          
          <div class="lg:col-span-2 flex flex-col gap-8">
            <div class="bg-white dark:bg-slate-900/50 p-8 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
              <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 border-b border-slate-100 dark:border-slate-800 pb-2">Description</h3>
              <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-lg mb-8">
                {{ book.description || 'No description available for this title.' }}
              </p>
              
              <div v-if="book.tags && book.tags.length" class="flex flex-wrap gap-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                <span 
                  v-for="tag in book.tags" :key="tag.id"
                  class="px-4 py-1.5 bg-slate-100 dark:bg-slate-800 rounded-full text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 transition-colors"
                >
                  {{ tag.name }}
                </span>
              </div>
            </div>
          </div>

          <div class="flex flex-col gap-8">
            <div class="bg-white dark:bg-slate-900/50 p-8 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col items-center justify-center text-center">
              <h3 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-6 border-b border-slate-100 dark:border-slate-800 pb-4 w-full">Community Rating</h3>
              
              <div class="text-6xl font-serif font-bold text-slate-900 dark:text-white mb-2">
                {{ book.average_rating ? Number(book.average_rating).toFixed(1) : '4.5' }}
              </div>
              
              <div class="flex text-amber-400 mb-2">
                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1">star</span>
                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1">star</span>
                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1">star</span>
                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1">star</span>
                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1">star_half</span>
              </div>
              
              <p class="text-sm text-slate-500 font-medium">Based on user libraries</p>
            </div>
            
            <button @click="$router.push('/catalog')" class="w-full py-3 text-primary font-bold text-sm border-2 border-primary/20 rounded-xl hover:bg-primary/5 transition-colors flex items-center justify-center gap-2">
              <span class="material-symbols-outlined text-lg">arrow_back</span>
              Back to Catalog
            </button>
          </div>

        </div>
      </div>
    </main>
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import MainLayout from '@/layouts/MainLayout.vue';
import { useBooksStore } from '@/stores/books.store.js';
import { useLibraryStore } from '@/stores/library.store.js';

const route = useRoute();
const router = useRouter();
const booksStore = useBooksStore();
const libraryStore = useLibraryStore();

const isAdding = ref(false);

const book = computed(() => booksStore.currentBook);

onMounted(() => {
  const bookId = route.params.id;
  booksStore.fetchBook(bookId);
});

const addToMyBooks = async () => {
  if (!book.value) return;
  
  isAdding.value = true;
  const success = await libraryStore.addFromCatalog(book.value.id);
  isAdding.value = false;
  
  if (success) {
    router.push('/');
  }
};
</script>