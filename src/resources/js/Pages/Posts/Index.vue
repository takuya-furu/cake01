<script setup>
import AppLayout from '@/Components/AppLayout.vue'
import SectionTitle from '@/Components/SectionTitle.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  posts: { type: Object, required: true },
  meta:  { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppLayout :meta="meta">
    <div class="max-w-3xl mx-auto px-6 py-20">
      <SectionTitle en="NEWS" ja="お知らせ" />

      <ul v-if="posts.data.length" class="mt-14 divide-y divide-stone-200">
        <li v-for="post in posts.data" :key="post.id">
          <Link
            :href="`/news/${post.id}`"
            class="flex items-baseline gap-6 py-6 hover:opacity-60 transition group"
          >
            <time class="text-xs text-stone-400 shrink-0 tracking-wider">
              {{ post.published_at ? new Date(post.published_at).toLocaleDateString('ja-JP') : '' }}
            </time>
            <span class="text-stone-700 text-sm font-light group-hover:underline underline-offset-2">
              {{ post.title }}
            </span>
          </Link>
        </li>
      </ul>
      <p v-else class="mt-20 text-center text-stone-400 text-sm">
        お知らせはまだありません
      </p>

      <!-- ページネーション -->
      <div v-if="posts.last_page > 1" class="flex justify-center gap-2 mt-14">
        <Link
          v-for="link in posts.links"
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
