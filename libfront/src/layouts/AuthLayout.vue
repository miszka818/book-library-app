<template>
  <div class="relative flex h-auto min-h-screen w-full flex-col bg-background-light dark:bg-background-dark group/design-root overflow-x-hidden">
    
    <div class="flex items-center bg-transparent p-4 pb-2 justify-between">
      <button @click="$router.back()" class="text-slate-900 dark:text-slate-100 flex size-12 shrink-0 items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors">
        <span class="material-symbols-outlined text-2xl">arrow_back</span>
      </button>
      <h2 class="text-slate-900 dark:text-slate-100 text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-12 font-display">
        Private Library
      </h2>
    </div>

    <div class="flex-1 flex flex-col items-center justify-center px-4 py-8">
      <slot />
    </div>
    
  </div>
</template>