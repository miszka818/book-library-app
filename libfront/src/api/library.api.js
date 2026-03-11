import apiClient from './axios.js';

export const libraryApi = {
  getUserBooks() {
    return apiClient.get('/user-books');
  },
  addToLibrary(data) {
    return apiClient.post('/user-books', data);
  }
};