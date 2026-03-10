<template>
  <div class="book-list">
    <div v-if="loading">Loading books...</div>
    <div v-else>
      <div v-if="books.length === 0">No books found.</div>
      <ul>
        <li v-for="book in books" :key="book.id" class="book-item">
          <h3>{{ book.title }} <span v-if="book.release_year">({{ book.release_year }})</span></h3>
          <p><strong>Author:</strong> {{ book.author || 'Unknown' }}</p>
          <p>{{ book.description || 'No description' }}</p>
          <p v-if="book.tags.length">
            <strong>Tags:</strong>
            <span v-for="tag in book.tags" :key="tag">{{ tag }}</span>
          </p>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import api from "@/api/axios";

export default {
  name: "BookList",
  setup() {
    const books = ref([]);
    const loading = ref(true);

    const fetchBooks = async () => {
      try {
        const response = await api.get("/books");
        books.value = response.data.data; // BookResource zwraca kolekcję pod 'data'
      } catch (err) {
        console.error("Failed to fetch books:", err);
      } finally {
        loading.value = false;
      }
    };

    onMounted(fetchBooks);

    return { books, loading };
  },
};
</script>

<style scoped>
.book-list {
  padding: 1rem;
}
.book-item {
  border-bottom: 1px solid #ccc;
  padding: 0.5rem 0;
}
.book-item h3 {
  margin: 0;
}
.book-item span {
  margin-left: 0.5rem;
  font-size: 0.9rem;
  color: #666;
}
</style>