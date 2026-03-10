import { ref } from "vue"
import { useAuthStore } from "@/stores/auth.store"

export function useAuth() {
  const authStore = useAuthStore()
  const error = ref(null)
  const loading = ref(false)

  const login = async (email, password) => {
    loading.value = true
    error.value = null
    try {
      await authStore.login(email, password)
    } catch (err) {
      error.value = err.response?.data?.message || "Błąd logowania"
    } finally {
      loading.value = false
    }
  }

  const logout = () => authStore.logout()

  return { login, logout, error, loading, user: authStore.user, isAuthenticated: authStore.isAuthenticated }
}