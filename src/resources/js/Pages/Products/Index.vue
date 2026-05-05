<script setup>
import AppLayout from '@/Components/AppLayout.vue'
import ProductCard from '@/Components/ProductCard.vue'
import SectionTitle from '@/Components/SectionTitle.vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  products:   { type: Object, required: true },
  categories: { type: Array,  default: () => [] },
  filters:    { type: Object, default: () => ({}) },
  meta:       { type: Object, default: () => ({}) },
})

const filterByCategory = (slug) => {
  router.get('/products', slug ? { category: slug } : {}, { preserveState: true })
}
</script>

<template>
  <AppLayout :meta="meta">
    <div class="max-w-7xl mx-auto px-6 py-20">
      <SectionTitle en="CAKE" ja="ケーキ一覧" />

      <!-- カテゴリフィルター -->
      <div class="flex flex-wrap justify-center gap-3 mt-10">
        <button
          class="text-xs tracking-widest px-5 py-2 border transition"
          :class="!filters.category
            ? 'border-stone-800 bg-stone-800 text-white'
            : 'border-stone-300 text-stone-600 hover:border-stone-800'"
          @click="filterByCategory(null)"
        >
          ALL
        </button>
        <button
          v-for="cat in categories"
          :key="cat.id"
          class="text-xs tracking-widest px-5 py-2 border transition"
          :class="filters.category === cat.slug
            ? 'border-stone-800 bg-stone-800 text-white'
            : 'border-stone-300 text-stone-600 hover:border-stone-800'"
          @click="filterByCategory(cat.slug)"
        >
          {{ cat.name }}
        </button>
      </div>

      <!-- 商品グリッド -->
      <div v-if="products.data.length" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-12">
        <ProductCard v-for="product in products.data" :key="product.id" :product="product" />
      </div>
      <p v-else class="mt-20 text-center text-stone-400 text-sm">
        該当する商品はありません
      </p>

      <!-- ページネーション -->
      <div v-if="products.last_page > 1" class="flex justify-center gap-2 mt-16">
        <Link
          v-for="link in products.links"
          :key="link.label"
          :href="link.url ?? ''"
          class="px-4 py-2 text-xs border transition"
          :class="[
            link.active
              ? 'border-stone-800 bg-stone-800 text-white'
              : 'border-stone-200 text-stone-500 hover:border-stone-400',
            !link.url ? 'opacity-30 pointer-events-none' : ''
          ]"
          v-html="link.label"
        />
      </div>
    </div>
  </AppLayout>
</template>
