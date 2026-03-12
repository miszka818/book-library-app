import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { booksApi } from '@/api/books.api.js';

export const useBooksStore = defineStore('books', () => {
  const catalog = ref([]);
  const currentBook = ref(null);
  const isLoading = ref(false);
  const error = ref(null);

  const normalizeTags = (book) => {
    if (book && book.tags) {
      book.tags = book.tags.map(t => typeof t === 'string' ? { name: t } : t);
    }
    return book;
  };

  const fetchCatalog = async (params = {}) => {
    isLoading.value = true;
    error.value = null;
    try {
      const response = await booksApi.getBooks(params);
      catalog.value = response.data.data || response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Błąd podczas pobierania katalogu.';
    } finally {
      isLoading.value = false;
    }
  };

  const fetchBook = async (id) => {
    isLoading.value = true;
    error.value = null;
    currentBook.value = null;
    try {
      const response = await booksApi.getBook(id);
      currentBook.value = response.data.data || response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Błąd podczas pobierania książki.';
    } finally {
      isLoading.value = false;
    }
  };

  const addBook = async (bookData) => {
  };

  const availableTags = computed(() => {
    const tags = new Set();
    catalog.value.forEach(book => {
      if (book.tags) {
        book.tags.forEach(tag => tags.add(tag.name));
      }
    });
    return Array.from(tags);
  });

  return { catalog, currentBook, isLoading, error, fetchCatalog, fetchBook, addBook, availableTags };
});