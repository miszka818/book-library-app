<template>
  <div class="books-view">
    <h1>All Books</h1>
    <BookList />
  </div>
</template>

<script>
import BookList from "../components/BookList.vue";

export default {
  name: "BooksView",
  components: { BookList },
};
</script>

<style scoped>
.books-view {
  padding: 1rem;
}
</style>