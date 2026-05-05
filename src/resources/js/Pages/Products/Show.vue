<script setup>
import AppLayout from '@/Components/AppLayout.vue'
import ProductCard from '@/Components/ProductCard.vue'
import SectionTitle from '@/Components/SectionTitle.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  product: { type: Object, required: true },
  related: { type: Array,  default: () => [] },
  meta:    { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppLayout :meta="meta">
    <div class="max-w-5xl mx-auto px-6 py-20">

      <!-- パンくず -->
      <nav class="flex items-center gap-2 text-xs text-stone-400 mb-10">
        <Link href="/" class="hover:text-stone-600 transition">HOME</Link>
        <span>/</span>
        <Link href="/products" class="hover:text-stone-600 transition">CAKE</Link>
        <span>/</span>
        <span class="text-stone-600">{{ product.name }}</span>
      </nav>

      <div class="grid md:grid-cols-2 gap-12">
        <!-- 画像 -->
        <div class="aspect-square bg-stone-100 overflow-hidden">
          <img
            v-if="product.image_url"
            :src="product.image_url"
            :alt="product.name"
            class="w-full h-full object-cover"
          />
          <div v-else class="w-full h-full flex items-center justify-center text-stone-300 text-sm">
            No Image
          </div>
        </div>

        <!-- 詳細 -->
        <div class="flex flex-col justify-center space-y-6">
          <div class="space-y-1">
            <p class="text-xs text-stone-400 tracking-widest">{{ product.category }}</p>
            <h1 class="text-2xl font-light text-stone-800 tracking-wider">{{ product.name }}</h1>
            <span
              v-if="product.is_seasonal"
              class="inline-block mt-1 text-xs text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 tracking-wider"
            >
              季節限定
            </span>
          </div>
          <p class="text-2xl font-light text-stone-700">¥{{ Number(product.price).toLocaleString() }}</p>
          <p v-if="product.description" class="text-stone-600 text-sm leading-loose font-light">
            {{ product.description }}
          </p>
          <div class="pt-4 border-t border-stone-100">
            <Link
              href="/products"
              class="text-xs tracking-widest text-stone-500 hover:text-stone-800 transition"
            >
              ← 一覧に戻る
            </Link>
          </div>
        </div>
      </div>

      <!-- 関連商品 -->
      <div v-if="related.length" class="mt-24">
        <SectionTitle en="RELATED" ja="同じカテゴリの商品" />
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
          <ProductCard v-for="p in related" :key="p.id" :product="p" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
