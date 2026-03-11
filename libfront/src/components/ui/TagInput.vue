<template>
  <div class="flex flex-col gap-2 w-full">
    <div class="flex gap-2">
      <div class="relative flex-1">
        <input 
          v-model="newTag"
          @keydown.enter.prevent="addTag"
          type="text" 
          placeholder="Add a tag and press Enter"
          class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-1 focus:ring-primary p-3"
        />
      </div>
      <button 
        @click.prevent="addTag"
        class="bg-primary/10 text-primary hover:bg-primary/20 px-4 rounded-lg flex items-center justify-center transition-colors"
      >
        <span class="material-symbols-outlined">add</span>
      </button>
    </div>

    <div class="flex flex-wrap gap-2 mt-2" v-if="modelValue.length > 0">
      <span 
        v-for="tag in modelValue" 
        :key="tag"
        class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-primary/10 text-primary text-sm font-medium"
      >
        {{ tag }} 
        <button @click.prevent="removeTag(tag)" class="material-symbols-outlined text-sm hover:text-red-500 transition-colors">close</button>
      </span>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  modelValue: { type: Array, default: () => [] }
});
const emit = defineEmits(['update:modelValue']);

const newTag = ref('');

const addTag = () => {
  const tag = newTag.value.trim();
  if (tag && !props.modelValue.includes(tag)) {
    emit('update:modelValue', [...props.modelValue, tag]);
  }
  newTag.value = '';
};

const removeTag = (tagToRemove) => {
  emit('update:modelValue', props.modelValue.filter(t => t !== tagToRemove));
};
</script>