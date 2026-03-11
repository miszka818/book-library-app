<template>
  <label class="flex flex-col w-full">
    <div class="flex justify-between items-center pb-2 px-1" v-if="label || $slots.labelRight">
      <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal font-display">
        {{ label }}
      </p>
      <slot name="labelRight" /> 
    </div>
    
    <div class="relative flex w-full items-stretch">
      <span 
        v-if="iconLeft" 
        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl pointer-events-none"
      >
        {{ iconLeft }}
      </span>

      <input 
        :type="inputType"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder"
        :required="required"
        class="form-input flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:border-primary h-14 placeholder:text-slate-400 dark:placeholder:text-slate-500 text-base font-normal transition-all"
        :class="{ 
          'pr-12': isPassword, 
          'pl-12': iconLeft,
          'pl-4': !iconLeft
        }"
      />
      
      <div 
        v-if="isPassword" 
        @click="togglePassword"
        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 flex items-center justify-center cursor-pointer hover:text-primary transition-colors"
      >
        <span class="material-symbols-outlined text-xl">
          {{ showPassword ? 'visibility_off' : 'visibility' }}
        </span>
      </div>
    </div>
  </label>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  modelValue: String,
  label: String,
  type: { type: String, default: 'text' },
  placeholder: String,
  required: { type: Boolean, default: false },
  iconLeft: { type: String, default: '' }
});

defineEmits(['update:modelValue']);

const showPassword = ref(false);
const isPassword = computed(() => props.type === 'password');
const inputType = computed(() => (isPassword.value && showPassword.value ? 'text' : props.type));

const togglePassword = () => {
  if (isPassword.value) {
    showPassword.value = !showPassword.value;
  }
};
</script>