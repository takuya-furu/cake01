<script setup>
import AppLayout from '@/Components/AppLayout.vue'
import SafeHtml from '@/Components/SafeHtml.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  post: { type: Object, required: true },
  meta: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppLayout :meta="meta">
    <article class="max-w-3xl mx-auto px-6 py-20">

      <!-- パンくず -->
      <nav class="flex items-center gap-2 text-xs text-stone-400 mb-10">
        <Link href="/" class="hover:text-stone-600 transition">HOME</Link>
        <span>/</span>
        <Link href="/news" class="hover:text-stone-600 transition">NEWS</Link>
        <span>/</span>
        <span class="text-stone-600 truncate max-w-40">{{ post.title }}</span>
      </nav>

      <header class="mb-12 pb-8 border-b border-stone-200">
        <time class="text-xs text-stone-400 tracking-wider">
          {{ post.published_at ? new Date(post.published_at).toLocaleDateString('ja-JP') : '' }}
        </time>
        <h1 class="text-2xl font-light text-stone-800 leading-relaxed mt-3">
          {{ post.title }}
        </h1>
      </header>

      <!-- 本文 (XSS対策済み) -->
      <SafeHtml :html="post.body" />

      <div class="mt-16 pt-8 border-t border-stone-200">
        <Link href="/news" class="text-xs tracking-widest text-stone-500 hover:text-stone-800 transition">
          ← お知らせ一覧に戻る
        </Link>
      </div>
    </article>
  </AppLayout>
</template>
