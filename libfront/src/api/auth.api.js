import apiClient from './axios';

export const authApi = {
  login(credentials) {
    return apiClient.post('/login', credentials);
  },
  register(data) {
    return apiClient.post('/register', data);
  },
  logout() {
    return apiClient.post('/logout');
  },
  fetchUser() {
    return apiClient.get('/user');
  }
};