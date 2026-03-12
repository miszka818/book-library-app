<template>
  <MainLayout>
    <div class="p-4 md:p-8 max-w-5xl mx-auto flex flex-col gap-8">
      
      <div v-if="libraryStore.isLoading" class="flex justify-center py-20">
        <span class="material-symbols-outlined animate-spin text-4xl text-primary">progress_activity</span>
      </div>

      <div v-else class="flex flex-col gap-10">

        <section>
          <h2 class="font-serif text-xl font-bold mb-4">Quick Actions</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <RouterLink to="/books/add" class="flex items-center gap-4 p-4 rounded-2xl border-2 border-primary/10 hover:border-primary hover:bg-primary/5 transition-all group cursor-pointer bg-white dark:bg-slate-900 shadow-sm">
              <div class="p-3 bg-primary/10 text-primary rounded-xl group-hover:bg-primary group-hover:text-white transition-colors">
                <span class="material-symbols-outlined">add_box</span>
              </div>
              <div class="text-left">
                <p class="font-bold text-sm">Add New Book</p>
                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-tight">Manual entry</p>
              </div>
            </RouterLink>
            
            <RouterLink to="/catalog" class="flex items-center gap-4 p-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 hover:border-primary/20 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all group cursor-pointer bg-white dark:bg-slate-900 shadow-sm">
              <div class="p-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                <span class="material-symbols-outlined">explore</span>
              </div>
              <div class="text-left">
                <p class="font-bold text-sm">Browse Catalog</p>
                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-tight">Discover seeded books</p>
              </div>
            </RouterLink>
          </div>
        </section>

        <section v-if="libraryStore.currentlyReading.length > 0">
          <div class="flex items-center justify-between mb-4">
            <h2 class="font-serif text-xl font-bold">Currently Reading</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div 
              v-for="item in libraryStore.currentlyReading" 
              :key="item.id"
              class="bg-white dark:bg-slate-900 p-5 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-md transition-shadow"
            >
              <div class="flex justify-between items-start">
                <span v-if="item.book.tags && item.book.tags.length > 0" class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold uppercase rounded-md tracking-wider">
                  {{ item.book.tags[0].name }}
                </span>
                <span v-else class="px-2 py-1 bg-slate-100 text-slate-500 text-[10px] font-bold uppercase rounded-md tracking-wider">Book</span>
                
                <button class="text-slate-400 hover:text-primary"><span class="material-symbols-outlined">edit</span></button>
              </div>
              <h3 class="text-lg font-bold mt-4 leading-tight">{{ item.book.title }}</h3>
              <p class="text-slate-500 text-sm italic mt-1">{{ item.book.author || 'Unknown Author' }}</p>
              
              <div class="mt-4 pt-4 border-t border-slate-50 dark:border-slate-800/50">
                <div class="flex justify-between text-xs font-bold text-slate-500 uppercase">
                  <span>My Rating</span>
                  <span v-if="item.rating > 0" class="text-amber-400 flex items-center">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1">star</span> {{ item.rating }}/5
                  </span>
                  <span v-else class="text-slate-300 flex items-center">
                    <span class="material-symbols-outlined text-sm">star</span> None
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section>
          <h2 class="font-serif text-xl font-bold mb-4">Recently Added</h2>
          
          <div v-if="libraryStore.recentlyAdded.length === 0" class="bg-white dark:bg-slate-900 p-8 rounded-2xl text-center border border-slate-100 dark:border-slate-800">
            <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">auto_stories</span>
            <p class="text-slate-500 text-sm">Your library is empty. Start by adding a new book!</p>
          </div>

          <div v-else class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse min-w-[400px]">
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                  <tr 
                    v-for="item in libraryStore.recentlyAdded" 
                    :key="item.id"
                    class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors"
                  >
                    <td class="px-4 py-3 sm:px-6 sm:py-4">
                      <div class="flex items-center gap-3 sm:gap-4">
                        <div class="w-10 h-10 shrink-0 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-bold font-serif uppercase">
                          {{ item.book.title.substring(0, 2) }}
                        </div>
                        <div class="min-w-0">
                          <p class="font-bold text-sm truncate">{{ item.book.title }}</p>
                          <p class="text-xs text-slate-500 truncate">{{ item.book.author || 'Unknown' }}</p>
                        </div>
                      </div>
                    </td>
                    <td class="px-4 py-3 sm:px-6 sm:py-4 text-right">
                      <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded-lg text-[10px] font-bold text-slate-600 dark:text-slate-400 whitespace-nowrap">
                        {{ item.status || 'To Read' }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <section>
          <h2 class="font-serif text-xl font-bold mb-4">Your Progress</h2>
          <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            
            <div class="bg-white dark:bg-slate-900 p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col items-center text-center">
              <div class="p-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 rounded-lg mb-2 sm:mb-3">
                <span class="material-symbols-outlined">book</span>
              </div>
              <p class="text-slate-500 text-xs sm:text-sm font-medium">Total Books</p>
              <p class="text-2xl sm:text-3xl font-bold font-serif mt-1">{{ libraryStore.totalBooks }}</p>
            </div>
            
            <div class="bg-white dark:bg-slate-900 p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col items-center text-center">
              <div class="p-2 bg-amber-50 dark:bg-amber-900/30 text-amber-600 rounded-lg mb-2 sm:mb-3">
                <span class="material-symbols-outlined">auto_stories</span>
              </div>
              <p class="text-slate-500 text-xs sm:text-sm font-medium">Reading</p>
              <p class="text-2xl sm:text-3xl font-bold font-serif mt-1">{{ libraryStore.currentlyReading.length }}</p>
            </div>
            
            <div class="bg-white dark:bg-slate-900 p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col items-center text-center">
              <div class="p-2 bg-green-50 dark:bg-green-900/30 text-green-600 rounded-lg mb-2 sm:mb-3">
                <span class="material-symbols-outlined">task_alt</span>
              </div>
              <p class="text-slate-500 text-xs sm:text-sm font-medium">Finished</p>
              <p class="text-2xl sm:text-3xl font-bold font-serif mt-1">{{ libraryStore.finished.length }}</p>
            </div>
            
            <div class="bg-white dark:bg-slate-900 p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col items-center text-center">
              <div class="p-2 bg-purple-50 dark:bg-purple-900/30 text-purple-600 rounded-lg mb-2 sm:mb-3">
                <span class="material-symbols-outlined">bookmark</span>
              </div>
              <p class="text-slate-500 text-xs sm:text-sm font-medium">To Read</p>
              <p class="text-2xl sm:text-3xl font-bold font-serif mt-1">{{ libraryStore.toRead.length }}</p>
            </div>

          </div>
        </section>

      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { onMounted } from 'vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { useLibraryStore } from '@/stores/library.store.js';

const libraryStore = useLibraryStore();

onMounted(() => {
  libraryStore.fetchLibrary();
});
</script>