import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { libraryApi } from '@/api/library.api.js';

export const useLibraryStore = defineStore('library', () => {
  const userBooks = ref([]);
  const isLoading = ref(false);
  const error = ref(null);

  const fetchLibrary = async () => {
    isLoading.value = true;
    error.value = null;
    try {
      const response = await libraryApi.getUserBooks();
      const data = response.data.data || response.data;
      
      userBooks.value = data.map(item => {
        if (item.book && item.book.tags) {
          item.book.tags = item.book.tags.map(t => typeof t === 'string' ? { name: t } : t);
        }
        return item;
      });
    } catch (err) {
      error.value = err.response?.data?.message || 'Błąd podczas pobierania biblioteki.';
      console.error(err);
    } finally {
      isLoading.value = false;
    }
  };

  const addFromCatalog = async (bookId) => {
    try {
      await libraryApi.addToLibrary({ book_id: bookId, status: 'To Read' });
      await fetchLibrary(); 
      return true;
    } catch (err) {
      console.error('Nie udało się dodać książki:', err);
      return false;
    }
  };

  const removeBook = async (userBookId) => {
    try {
      await libraryApi.removeUserBook(userBookId);
      userBooks.value = userBooks.value.filter(item => item.id !== userBookId);
      return true;
    } catch (err) {
      console.error('Nie udało się usunąć książki:', err);
      return false;
    }
  };

  const totalBooks = computed(() => userBooks.value.length);
  const currentlyReading = computed(() => userBooks.value.filter(item => item.status === 'Currently Reading'));
  const finished = computed(() => userBooks.value.filter(item => item.status === 'Finished'));
  const toRead = computed(() => userBooks.value.filter(item => item.status === 'To Read'));

  const recentlyAdded = computed(() => {
    return [...userBooks.value]
      .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
      .slice(0, 5);
  });

  return { 
    userBooks, isLoading, error, fetchLibrary, addFromCatalog, removeBook,
    totalBooks, currentlyReading, finished, toRead, recentlyAdded 
  };
});