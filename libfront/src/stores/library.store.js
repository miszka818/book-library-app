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
      userBooks.value = response.data.data || response.data; 
    } catch (err) {
      error.value = err.response?.data?.message || 'Błąd podczas pobierania biblioteki.';
      console.error(err);
    } finally {
      isLoading.value = false;
    }
  };
  
  const totalBooks = computed(() => userBooks.value.length);
  
  const currentlyReading = computed(() => 
    userBooks.value.filter(item => item.status === 'Currently Reading')
  );
  
  const finished = computed(() => 
    userBooks.value.filter(item => item.status === 'Finished')
  );
  
  const toRead = computed(() => 
    userBooks.value.filter(item => item.status === 'To Read')
  );

  const recentlyAdded = computed(() => {
    return [...userBooks.value]
      .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
      .slice(0, 5);
  });

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

  return { 
    userBooks, isLoading, error, fetchLibrary, addFromCatalog,
    totalBooks, currentlyReading, finished, toRead, recentlyAdded 
  };
});