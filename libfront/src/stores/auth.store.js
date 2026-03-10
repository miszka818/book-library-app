import { defineStore } from "pinia"
import api from "@/api/axios"

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem("token") || null,
    isAuthenticated: !!localStorage.getItem("token")
  }),
  actions: {
    async login(email, password) {
      const response = await api.post("/login", { email, password })
      this.token = response.data.token
      localStorage.setItem("token", this.token)
      this.isAuthenticated = true
      await this.fetchUser()
    },
    async fetchUser() {
      try {
        const response = await api.get("/user")
        this.user = response.data
      } catch (error) {
        this.logout()
      }
    },
    logout() {
      this.user = null
      this.token = null
      this.isAuthenticated = false
      localStorage.removeItem("token")
    }
  }
})