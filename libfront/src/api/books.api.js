import apiClient from './axios.js';

export const booksApi = {
  getBooks(params) {
    return apiClient.get('/books', { params });
  },
  addBook(bookData) {
    return apiClient.post('/books', bookData);
  }
};