<template>
  <MainLayout>
    <div class="p-4 md:p-8 max-w-3xl mx-auto">
      
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 mt-2">
        <div>
          <h1 class="font-serif text-2xl font-bold">Add New Book</h1>
          <p class="text-sm text-slate-500 mt-1">Expand your personal collection</p>
        </div>
        <button @click="$router.back()" class="text-slate-500 hover:text-primary flex items-center gap-2 text-sm font-bold transition-colors w-fit">
          <span class="material-symbols-outlined text-lg">arrow_back</span> Back
        </button>
      </div>

      <div class="bg-white dark:bg-slate-900 p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
        <div v-if="booksStore.error" class="bg-red-100 border border-red-500 text-red-700 p-3 rounded-xl text-sm mb-6">
          {{ booksStore.error }}
        </div>

        <form id="addBookForm" @submit.prevent="submitForm" class="space-y-8">
          
          <section class="space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-widest text-primary mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">1. Book Details</h3>
            
            <div class="flex flex-col gap-2">
              <label class="text-sm font-semibold">Title (Required)</label>
              <input v-model="form.title" type="text" required placeholder="Enter book title" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-2 focus:ring-primary/20 p-3 outline-none transition-all"/>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold">Author</label>
                <input v-model="form.author" type="text" placeholder="Enter author name" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-2 focus:ring-primary/20 p-3 outline-none transition-all"/>
              </div>
              <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold">Release Year</label>
                <input v-model.number="form.release_year" type="number" placeholder="YYYY" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-2 focus:ring-primary/20 p-3 outline-none transition-all"/>
              </div>
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-sm font-semibold">Description</label>
              <textarea v-model="form.description" rows="3" placeholder="Enter book description" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-2 focus:ring-primary/20 p-3 outline-none transition-all resize-none"></textarea>
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-sm font-semibold">Tags</label>
              <TagInput v-model="form.tags" />
            </div>
          </section>

          <section class="space-y-4 pt-4">
            <h3 class="text-xs font-bold uppercase tracking-widest text-primary mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">2. Personal Info</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold">My Library Status</label>
                <select v-model="form.status" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-2 focus:ring-primary/20 p-3 outline-none transition-all cursor-pointer">
                  <option value="To Read">To Read</option>
                  <option value="Currently Reading">Currently Reading</option>
                  <option value="Finished">Finished</option>
                </select>
              </div>
              
              <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold">My Rating</label>
                <StarRating v-model="form.rating" />
              </div>
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-sm font-semibold">Personal Notes</label>
              <textarea v-model="form.notes" rows="2" placeholder="Write your thoughts..." class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-2 focus:ring-primary/20 p-3 outline-none transition-all resize-none"></textarea>
            </div>
          </section>

          <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-100 dark:border-slate-800">
            <button 
              @click="submitForm"
              :disabled="booksStore.isLoading"
              class="w-full sm:w-auto flex-1 bg-primary text-white font-bold py-3 px-6 rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 disabled:opacity-70 flex justify-center items-center gap-2 order-1 sm:order-2"
            >
              <span v-if="booksStore.isLoading" class="material-symbols-outlined animate-spin">progress_activity</span>
              Save to Library
            </button>
            <button 
              @click.prevent="$router.back()"
              class="w-full sm:w-auto flex-none bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-semibold py-3 px-6 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-all order-2 sm:order-1"
            >
              Cancel
            </button>
          </div>

        </form>
      </div>

    </div>
  </MainLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useBooksStore } from '@/stores/books.store.js';
import MainLayout from '@/layouts/MainLayout.vue';
import TagInput from '@/components/ui/TagInput.vue';
import StarRating from '@/components/ui/StarRating.vue';

const router = useRouter();
const booksStore = useBooksStore();

const form = reactive({
  title: '',
  author: '',
  release_year: null,
  description: '',
  tags: [],
  status: 'To Read',
  rating: 0,
  notes: ''
});

const submitForm = async () => {
  if (!form.title) {
    alert("Title is required!");
    return;
  }
  const result = await booksStore.addBook(form);
  if (result) {
    router.push('/');
  }
};
</script>