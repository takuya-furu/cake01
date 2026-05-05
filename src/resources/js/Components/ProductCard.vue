<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  product: { type: Object, required: true },
})
</script>

<template>
  <Link :href="`/products/${product.id}`" class="group block">
    <div class="aspect-square overflow-hidden bg-stone-100">
      <img
        v-if="product.image_url"
        :src="product.image_url"
        :alt="product.name"
        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
        loading="lazy"
      />
      <div v-else class="w-full h-full flex items-center justify-center text-stone-300 text-sm">
        No Image
      </div>
    </div>
    <div class="mt-3 space-y-1 px-1">
      <p class="text-xs text-stone-400 tracking-wider">{{ product.category }}</p>
      <p class="font-light text-stone-800 text-sm">{{ product.name }}</p>
      <p class="text-sm text-stone-600">¥{{ Number(product.price).toLocaleString() }}</p>
    </div>
  </Link>
</template>
