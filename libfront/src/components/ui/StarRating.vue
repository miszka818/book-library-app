<template>
  <div class="flex items-center h-[50px] gap-1 text-primary">
    <span 
      v-for="star in 5" 
      :key="star"
      @click="$emit('update:modelValue', star)"
      class="material-symbols-outlined cursor-pointer transition-transform hover:scale-110"
      :style="star <= modelValue ? 'font-variation-settings: \'FILL\' 1' : 'font-variation-settings: \'FILL\' 0'"
    >
      star
    </span>
  </div>
</template>

<script setup>
defineProps({
  modelValue: { type: Number, default: 0 }
});
defineEmits(['update:modelValue']);
</script>