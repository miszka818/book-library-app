import { createRouter, createWebHistory } from "vue-router"
import LoginView from "@/modules/auth/views/LoginView.vue"
import RegisterView from "@/modules/auth/views/RegisterView.vue"
import BooksView from "@/modules/books/views/BooksView.vue";

const routes = [
  { path: "/login", component: LoginView },
  { path: "/register", component: RegisterView },
  { path: "/books", component: BooksView, meta: { requiresAuth: true } },
  { path: "/", redirect: "/books" },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem("token");
  if (to.meta.requiresAuth && !isAuthenticated) {
    next("/login");
  } else {
    next();
  }
});

export default router