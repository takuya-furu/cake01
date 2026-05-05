<script setup>
import { Head } from '@inertiajs/vue3'
import AppHeader from './AppHeader.vue'
import AppFooter from './AppFooter.vue'

const props = defineProps({
  meta: {
    type: Object,
    default: () => ({
      title: 'UN GRAIN',
      description: 'こだわりのケーキとイートインカフェ。駅徒歩2分。',
      jsonLd: null,
    }),
  },
})
</script>

<template>
  <Head>
    <title>{{ meta.title }}</title>
    <meta name="description" :content="meta.description" />
    <meta property="og:title" :content="meta.title" />
    <meta property="og:description" :content="meta.description" />
    <meta property="og:type" content="website" />
    <component
      :is="'script'"
      v-if="meta.jsonLd"
      type="application/ld+json"
      v-html="JSON.stringify(meta.jsonLd)"
    />
  </Head>

  <div class="min-h-screen flex flex-col">
    <AppHeader />
    <main class="flex-1">
      <slot />
    </main>
    <AppFooter />
  </div>
</template>
