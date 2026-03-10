<template>
  <div>
    <h2>Test API Ping</h2>
    <p v-if="loading">Ładowanie...</p>
    <p v-else>{{ message }}</p>
    <p v-if="error" style="color:red">{{ error }}</p>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
  setup() {
    const message = ref('');
    const loading = ref(true);
    const error = ref('');

    onMounted(async () => {
      try {
        const res = await fetch('http://127.0.0.1:8000/api/ping');
        if (!res.ok) throw new Error('Błąd połączenia z API');
        const data = await res.json();
        message.value = data.message;
      } catch (err) {
        error.value = err.message;
      } finally {
        loading.value = false;
      }
    });

    return { message, loading, error };
  }
};
</script>