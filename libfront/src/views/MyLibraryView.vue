<template>
  <MainLayout>
    <main class="max-w-[1440px] mx-auto px-4 md:px-6 py-8 flex flex-col lg:flex-row gap-8 flex-1 w-full">
      
      <div v-if="libraryStore.isLoading" class="flex justify-center items-center w-full py-20">
        <span class="material-symbols-outlined animate-spin text-4xl text-primary">progress_activity</span>
      </div>

      <template v-else>
        <aside class="w-full lg:w-64 shrink-0 flex flex-col gap-8">
          
          <div class="relative group">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">search</span>
            <input 
              v-model="searchQuery"
              type="text" 
              placeholder="Search your collection..." 
              class="w-full pl-10 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all outline-none"
            />
          </div>

          <div>
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Status</h3>
              <button @click="selectedStatus = []" v-if="selectedStatus.length" class="text-[10px] text-primary font-bold hover:underline">Clear</button>
            </div>
            <div class="flex flex-col gap-2">
              <label class="flex items-center gap-3 px-3 py-2 rounded-lg cursor-pointer group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                <input type="checkbox" value="Currently Reading" v-model="selectedStatus" class="rounded border-slate-300 text-primary focus:ring-primary/20 w-4 h-4" />
                <span class="text-sm text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Reading</span>
                <span class="ml-auto text-xs text-slate-400 font-medium">{{ libraryStore.currentlyReading.length }}</span>
              </label>
              <label class="flex items-center gap-3 px-3 py-2 rounded-lg cursor-pointer group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                <input type="checkbox" value="To Read" v-model="selectedStatus" class="rounded border-slate-300 text-primary focus:ring-primary/20 w-4 h-4" />
                <span class="text-sm text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">To Read</span>
                <span class="ml-auto text-xs text-slate-400 font-medium">{{ libraryStore.toRead.length }}</span>
              </label>
              <label class="flex items-center gap-3 px-3 py-2 rounded-lg cursor-pointer group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                <input type="checkbox" value="Finished" v-model="selectedStatus" class="rounded border-slate-300 text-primary focus:ring-primary/20 w-4 h-4" />
                <span class="text-sm text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Finished</span>
                <span class="ml-auto text-xs text-slate-400 font-medium">{{ libraryStore.finished.length }}</span>
              </label>
            </div>
          </div>

          <div v-if="uniqueTags.length > 0">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tags</h3>
              <button @click="selectedTags = []" v-if="selectedTags.length" class="text-[10px] text-primary font-bold hover:underline">Clear</button>
            </div>
            <div class="flex flex-wrap gap-2">
              <button 
                v-for="tag in uniqueTags" :key="tag"
                @click="toggleTag(tag)"
                :class="selectedTags.includes(tag) ? 'bg-primary text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-primary/10 hover:text-primary'"
                class="px-3 py-1.5 text-xs rounded-lg font-medium transition-colors"
              >
                {{ tag }}
              </button>
            </div>
          </div>
        </aside>

        <section class="flex-1 min-w-0 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm flex flex-col">
          <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <h2 class="text-2xl font-serif font-bold tracking-tight">My Collection</h2>
              <p class="text-sm text-slate-500 mt-1">{{ filteredBooks.length }} titles found</p>
            </div>
            <div class="flex items-center gap-3">
              <RouterLink to="/books/add" class="bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 transition-colors shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-sm">add</span>
                Add Book
              </RouterLink>
            </div>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
              <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                  <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Title</th>
                  <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</th>
                  <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Tags</th>
                  <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Rating</th>
                  <th class="px-6 py-4"></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                
                <tr v-if="paginatedBooks.length === 0">
                  <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                    No books match your current filters.
                  </td>
                </tr>

                <tr 
                  v-for="item in paginatedBooks" :key="item.id"
                  class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors"
                >
                  <td class="px-6 py-4">
                    <RouterLink :to="'/catalog/' + item.book.id" class="block">
                      <div class="font-serif text-lg text-slate-900 dark:text-white font-bold group-hover:text-primary transition-colors line-clamp-1">{{ item.book.title }}</div>
                      <div class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">{{ item.book.author || 'Unknown' }}</div>
                    </RouterLink>
                  </td>
                  
                  <td class="px-6 py-4">
                    <span 
                      :class="{
                        'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400': item.status === 'Currently Reading',
                        'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400': item.status === 'Finished',
                        'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400': item.status === 'To Read' || !item.status
                      }"
                      class="px-3 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider whitespace-nowrap"
                    >
                      {{ item.status === 'Currently Reading' ? 'Reading' : (item.status || 'To Read') }}
                    </span>
                  </td>
                  
                  <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1">
                      <span 
                        v-for="tag in item.book.tags?.slice(0,2)" :key="tag.id"
                        class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-[10px] font-bold text-slate-500 rounded uppercase"
                      >
                        {{ tag.name }}
                      </span>
                      <span 
                        v-if="item.book.tags?.length > 2" 
                        class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-[10px] font-bold text-slate-500 rounded uppercase cursor-help"
                        :title="item.book.tags.slice(2).map(t => t.name).join(', ')"
                      >
                        +{{ item.book.tags.length - 2 }}
                      </span>
                    </div>
                  </td>
                  
                  <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center text-amber-400" v-if="item.rating > 0">
                      <span 
                        v-for="star in 5" :key="star"
                        class="material-symbols-outlined text-base"
                        :style="star <= item.rating ? 'font-variation-settings: \'FILL\' 1' : 'font-variation-settings: \'FILL\' 0; color: #cbd5e1'"
                      >
                        star
                      </span>
                    </div>
                    <div v-else class="text-xs text-slate-400 italic">No rating</div>
                  </td>
                  
                  <td class="px-6 py-4 text-right flex items-center justify-end gap-1">
                    <button 
                      @click="toggleFavorite(item)"
                      class="p-2 rounded-lg transition-colors"
                      :class="isFavorite(item) ? 'text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20' : 'text-slate-400 hover:text-amber-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
                      title="Toggle Favorite"
                    >
                      <span class="material-symbols-outlined" :style="isFavorite(item) ? 'font-variation-settings: \'FILL\' 1' : ''">star</span>
                    </button>
                    <button @click="handleRemove(item.id, item.book.title)" class="p-2 text-slate-400 hover:text-red-500 rounded-lg transition-colors" title="Remove from library">
                      <span class="material-symbols-outlined">delete</span>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div v-if="filteredBooks.length > itemsPerPage" class="p-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between mt-auto">
            <p class="text-sm text-slate-500 hidden sm:block">Showing page {{ currentPage }} of {{ totalPages }}</p>
            <div class="flex gap-2 ml-auto">
              <button @click="currentPage--" :disabled="currentPage === 1" class="p-2 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors disabled:opacity-50"><span class="material-symbols-outlined">chevron_left</span></button>
              <button @click="currentPage++" :disabled="currentPage === totalPages" class="p-2 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors disabled:opacity-50"><span class="material-symbols-outlined">chevron_right</span></button>
            </div>
          </div>
        </section>
      </template>

    </main>
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { useLibraryStore } from '@/stores/library.store.js';

const libraryStore = useLibraryStore();

onMounted(() => {
  libraryStore.fetchLibrary();
});

const searchQuery = ref('');
const selectedStatus = ref([]);
const selectedTags = ref([]);
const currentPage = ref(1);
const itemsPerPage = 10;

const uniqueTags = computed(() => {
  const tags = new Set();
  libraryStore.userBooks.forEach(item => {
    if (item.book && item.book.tags) {
      item.book.tags.forEach(tag => tags.add(tag.name));
    }
  });
  return Array.from(tags).sort();
});

const toggleTag = (tag) => {
  if (selectedTags.value.includes(tag)) {
    selectedTags.value = selectedTags.value.filter(t => t !== tag);
  } else {
    selectedTags.value.push(tag);
  }
};

// Sprawdzanie i przełączanie ulubionych (tylko w UI na ten moment)
const isFavorite = (item) => {
  return item.groups && item.groups.some(g => g.name === 'Favorites');
};

const toggleFavorite = (item) => {
  if (isFavorite(item)) {
    item.groups = item.groups.filter(g => g.name !== 'Favorites');
  } else {
    if(!item.groups) item.groups = [];
    item.groups.push({ name: 'Favorites' });
  }
};

const filteredBooks = computed(() => {
  return libraryStore.userBooks.filter(item => {
    if (searchQuery.value) {
      const query = searchQuery.value.toLowerCase();
      const titleMatch = item.book.title.toLowerCase().includes(query);
      const authorMatch = (item.book.author || '').toLowerCase().includes(query);
      if (!titleMatch && !authorMatch) return false;
    }
    if (selectedStatus.value.length > 0) {
      if (!selectedStatus.value.includes(item.status)) return false;
    }
    if (selectedTags.value.length > 0) {
      const bookTags = item.book.tags?.map(t => t.name) || [];
      const hasMatchingTag = selectedTags.value.some(tag => bookTags.includes(tag));
      if (!hasMatchingTag) return false;
    }
    return true;
  });
});

const paginatedBooks = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredBooks.value.slice(start, start + itemsPerPage);
});

const totalPages = computed(() => Math.ceil(filteredBooks.value.length / itemsPerPage) || 1);

watch([searchQuery, selectedStatus, selectedTags], () => { currentPage.value = 1; });

const handleRemove = async (id, title) => {
  if (confirm(`Are you sure you want to remove "${title}" from your library?`)) {
    await libraryStore.removeBook(id);
  }
};
</script>