<template>
  <button 
    :disabled="loading"
    class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-primary/25 transition-all active:scale-[0.98] flex items-center justify-center gap-2"
    :class="{ 'opacity-75 cursor-not-allowed': loading }"
  >
    <span v-if="loading" class="material-symbols-outlined animate-spin">progress_activity</span>
    <slot v-else />
  </button>
</template>

<script setup>
defineProps({
  loading: { type: Boolean, default: false }
});
</script>