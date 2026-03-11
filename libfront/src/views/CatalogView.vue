<template>
  <MainLayout>
    <main class="mx-auto flex w-full max-w-7xl flex-1 flex-col p-4 md:p-8">
      
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
        <div class="flex flex-col gap-2">
          <h1 class="text-4xl font-black tracking-tight text-slate-900 dark:text-slate-100 font-serif">Book Catalog</h1>
          <p class="text-slate-500 dark:text-slate-400 text-lg">Explore and manage your personal collection of {{ booksStore.catalog.length }} titles.</p>
        </div>
        
        <div class="flex items-center gap-3">
          <div class="flex h-11 items-center bg-slate-100 dark:bg-slate-800 p-1 rounded-xl shadow-inner">
            <button 
              @click="viewMode = 'grid'"
              :class="viewMode === 'grid' ? 'bg-white dark:bg-slate-700 shadow-sm text-primary font-bold' : 'text-slate-500 dark:text-slate-400 hover:text-primary font-medium'"
              class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-colors"
            >
              <span class="material-symbols-outlined text-lg">grid_view</span> Grid
            </button>
            <button 
              @click="viewMode = 'list'"
              :class="viewMode === 'list' ? 'bg-white dark:bg-slate-700 shadow-sm text-primary font-bold' : 'text-slate-500 dark:text-slate-400 hover:text-primary font-medium'"
              class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-colors"
            >
              <span class="material-symbols-outlined text-lg">list</span> List
            </button>
          </div>
          
          <RouterLink to="/books/add" class="flex h-11 items-center gap-2 bg-primary text-white px-6 rounded-xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined">add</span> Add New
          </RouterLink>
        </div>
      </div>

      <div class="flex flex-col gap-4 mb-8">
        <div class="flex border-b border-slate-200 dark:border-slate-800 gap-8 overflow-x-auto pb-px no-scrollbar">
          <button 
            @click="selectedFilter = null"
            :class="!selectedFilter ? 'border-primary text-primary font-bold' : 'border-transparent text-slate-500 hover:text-primary font-medium'"
            class="flex items-center justify-center border-b-2 pb-4 transition-colors whitespace-nowrap"
          >All Books</button>
          
          <button 
            v-for="tag in booksStore.availableTags" :key="tag"
            @click="selectedFilter = tag"
            :class="selectedFilter === tag ? 'border-primary text-primary font-bold' : 'border-transparent text-slate-500 hover:text-primary font-medium'"
            class="flex items-center justify-center border-b-2 pb-4 transition-colors whitespace-nowrap"
          >
            {{ tag }}
          </button>
        </div>
      </div>

      <div v-if="booksStore.isLoading" class="flex justify-center py-20">
        <span class="material-symbols-outlined animate-spin text-4xl text-primary">progress_activity</span>
      </div>

      <div v-else-if="viewMode === 'grid'" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-6">
        <div 
          v-for="book in paginatedBooks" :key="book.id"
          class="group flex flex-col p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
        >
          <div class="flex items-center justify-center mb-2">
            <span v-if="book.tags && book.tags.length" class="px-2 py-0.5 rounded bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider text-center">
              {{ book.tags[0].name }}
            </span>
            <span v-else class="px-2 py-0.5 rounded bg-slate-100 text-slate-500 text-[10px] font-bold uppercase tracking-wider text-center">
              Book
            </span>
          </div>
          
          <div class="flex flex-col items-center text-center gap-1 py-2 sm:py-4">
            <h3 class="font-bold text-sm sm:text-lg text-slate-900 dark:text-slate-100 line-clamp-2" :title="book.title">
              {{ book.title }}
            </h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 truncate w-full">
              {{ book.author || 'Unknown' }}
            </p>
            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 sm:mt-2">
              Pub: {{ book.release_year || 'N/A' }}
            </p>
          </div>
          
          <div class="mt-auto flex justify-center w-full pt-2">
            <button 
              @click="addToMyBooks(book.id)" 
              class="w-full bg-primary text-white py-2 rounded-lg font-bold text-xs shadow-lg shadow-primary/20 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity"
            >
              Add
            </button>
          </div>
        </div>
      </div>

      <div v-else class="flex flex-col gap-6">
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
          <div class="flex flex-col">
            
            <div 
              v-for="book in paginatedBooks" :key="book.id"
              class="group flex flex-col p-8 border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors"
            >
              <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div class="flex-1">
                  <div class="flex flex-wrap items-center gap-3 mb-3">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-slate-100 font-serif">{{ book.title }}</h3>
                    <span v-for="tag in book.tags" :key="tag.id" class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">{{ tag.name }}</span>
                  </div>
                  <p class="text-xl text-slate-600 dark:text-slate-300 font-medium mb-4">{{ book.author || 'Unknown' }}</p>
                  <p class="text-slate-500 dark:text-slate-400 text-base leading-relaxed max-w-4xl line-clamp-3">
                    {{ book.description || 'No description available for this title.' }}
                  </p>
                </div>
                <div class="flex shrink-0 gap-3">
                  <button @click="addToMyBooks(book.id)" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-lg">add_circle</span> Add to My Books
                  </button>
                </div>
              </div>
              
              <div class="flex flex-wrap items-center gap-x-12 gap-y-4 mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
                <div class="flex flex-col">
                  <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Published</span>
                  <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ book.release_year || 'Unknown' }}</span>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div v-if="filteredBooks.length > itemsPerPage" class="flex items-center justify-between mt-12 py-6 border-t border-slate-200 dark:border-slate-800">
        <p class="text-sm text-slate-500">Showing page {{ currentPage }} of {{ totalPages }}</p>
        <div class="flex items-center gap-2">
          <button 
            @click="currentPage--"
            :disabled="currentPage === 1"
            class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-100 disabled:opacity-50 transition-colors"
          >
            <span class="material-symbols-outlined">chevron_left</span>
          </button>
          
          <button 
            @click="currentPage++"
            :disabled="currentPage === totalPages"
            class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-100 disabled:opacity-50 transition-colors"
          >
            <span class="material-symbols-outlined">chevron_right</span>
          </button>
        </div>
      </div>

    </main>
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { useBooksStore } from '@/stores/books.store.js';
import { useLibraryStore } from '@/stores/library.store.js';

const booksStore = useBooksStore();
const libraryStore = useLibraryStore();

const viewMode = ref('grid');
const selectedFilter = ref(null);

const currentPage = ref(1);
const itemsPerPage = 12;

const filteredBooks = computed(() => {
  if (!selectedFilter.value) return booksStore.catalog;
  
  return booksStore.catalog.filter(book => 
    book.tags && book.tags.some(t => t.name === selectedFilter.value)
  );
});

const paginatedBooks = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredBooks.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredBooks.value.length / itemsPerPage));

watch(selectedFilter, () => {
  currentPage.value = 1;
});

const addToMyBooks = async (bookId) => {
  const success = await libraryStore.addFromCatalog(bookId);
  if (success) {
    alert("Book added to your library successfully!");
  }
};

onMounted(() => {
  booksStore.fetchCatalog();
});
</script>