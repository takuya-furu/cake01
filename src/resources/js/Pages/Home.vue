<script setup>
import AppLayout from '@/Components/AppLayout.vue'
import ProductCard from '@/Components/ProductCard.vue'
import SectionTitle from '@/Components/SectionTitle.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  pickups:     { type: Array, default: () => [] },
  latestPosts: { type: Array, default: () => [] },
  meta:        { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppLayout :meta="meta">

    <!-- Hero -->
    <section class="relative h-screen overflow-hidden -mt-16">
      <div class="absolute inset-0 bg-stone-200 flex items-center justify-center">
        <p class="text-stone-400 text-sm tracking-widest">HERO IMAGE</p>
      </div>
      <div class="absolute inset-0 bg-black/30" />
      <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center px-6">
        <p class="tracking-[0.5em] text-xs mb-6 font-light opacity-80">PATISSERIE & CAFÉ</p>
        <h1 class="text-6xl md:text-8xl font-light tracking-[0.3em] mb-8">UN GRAIN</h1>
        <p class="text-sm font-light tracking-widest opacity-90">駅から徒歩2分。日常に、特別なひとときを。</p>
        <Link
          href="/products"
          class="mt-12 border border-white/70 text-white text-xs tracking-widest px-10 py-3 hover:bg-white hover:text-stone-800 transition-colors duration-300"
        >
          CAKE GALLERY
        </Link>
      </div>
    </section>

    <!-- Pickup -->
    <section class="py-24 px-6 max-w-7xl mx-auto">
      <SectionTitle en="PICKUP" ja="おすすめのケーキ" />
      <div v-if="pickups.length" class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-14">
        <ProductCard v-for="product in pickups" :key="product.id" :product="product" />
      </div>
      <p v-else class="mt-14 text-center text-stone-400 text-sm py-16 border border-stone-100">
        準備中です
      </p>
      <div class="text-center mt-12">
        <Link
          href="/products"
          class="inline-block border border-stone-800 text-stone-800 text-xs tracking-widest px-12 py-3 hover:bg-stone-800 hover:text-white transition-colors duration-300"
        >
          VIEW ALL
        </Link>
      </div>
    </section>

    <!-- Eat-in -->
    <section class="py-24 bg-stone-50 px-6">
      <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-16 items-center">
        <div class="aspect-[4/3] bg-stone-200 flex items-center justify-center">
          <p class="text-stone-400 text-sm tracking-widest">EAT-IN IMAGE</p>
        </div>
        <div class="space-y-8">
          <SectionTitle en="EAT IN" ja="ゆったりとした時間を" />
          <p class="text-stone-600 leading-loose font-light text-sm">
            20席のイートインスペースで、できたてのケーキとドリンクをお楽しみください。<br>
            仕事帰りの一息に、大切な方との特別なティータイムに。
          </p>
          <Link
            href="/menu"
            class="inline-block text-xs tracking-widest border-b border-stone-800 pb-1 hover:opacity-60 transition"
          >
            MENU を見る →
          </Link>
        </div>
      </div>
    </section>

    <!-- News -->
    <section class="py-24 px-6">
      <div class="max-w-3xl mx-auto">
        <SectionTitle en="NEWS" ja="お知らせ" />
        <ul v-if="latestPosts.length" class="mt-12 divide-y divide-stone-200">
          <li v-for="post in latestPosts" :key="post.id">
            <Link
              :href="`/news/${post.id}`"
              class="flex items-baseline gap-6 py-5 hover:opacity-60 transition"
            >
              <time class="text-xs text-stone-400 shrink-0 tracking-wider">
                {{ post.published_at ? new Date(post.published_at).toLocaleDateString('ja-JP') : '' }}
              </time>
              <span class="text-stone-700 text-sm font-light">{{ post.title }}</span>
            </Link>
          </li>
        </ul>
        <p v-else class="mt-12 text-center text-stone-400 text-sm py-10">
          お知らせはまだありません
        </p>
        <div class="text-center mt-10">
          <Link href="/news" class="text-xs tracking-widest border-b border-stone-800 pb-1 hover:opacity-60 transition">
            一覧を見る →
          </Link>
        </div>
      </div>
    </section>

  </AppLayout>
</template>
