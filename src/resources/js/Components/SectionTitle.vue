<script setup>
defineProps({
  en: { type: String, required: true },
  ja: { type: String, required: true },
})
</script>

<template>
  <div class="text-center">
    <p class="text-xs tracking-[0.4em] text-stone-400 mb-2">{{ en }}</p>
    <h2 class="text-2xl font-light tracking-wider text-stone-800">{{ ja }}</h2>
    <div class="mt-4 w-8 h-px bg-stone-300 mx-auto" />
  </div>
</template>
