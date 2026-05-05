<script setup>
import AppLayout from '@/Components/AppLayout.vue'
import SectionTitle from '@/Components/SectionTitle.vue'

defineProps({
  menuItems: { type: Object, default: () => ({}) },
  meta:      { type: Object, default: () => ({}) },
})

const categoryLabel = (key) => ({
  cake:    'ケーキ',
  drink:   'ドリンク',
  food:    'フード',
  dessert: 'デザート',
}[key] ?? key)
</script>

<template>
  <AppLayout :meta="meta">
    <div class="max-w-4xl mx-auto px-6 py-20">
      <SectionTitle en="MENU" ja="イートインメニュー" />

      <div v-if="Object.keys(menuItems).length" class="mt-16 space-y-16">
        <div v-for="(items, category) in menuItems" :key="category">
          <h2 class="text-xs tracking-[0.4em] text-stone-500 border-b border-stone-200 pb-3 mb-8">
            {{ categoryLabel(category) }}
          </h2>
          <div class="space-y-6">
            <div
              v-for="item in items"
              :key="item.id"
              class="flex gap-6 items-start"
            >
              <div v-if="item.image_url" class="w-20 h-20 shrink-0 overflow-hidden bg-stone-100">
                <img :src="item.image_url" :alt="item.name" class="w-full h-full object-cover" loading="lazy" />
              </div>
              <div class="flex-1 flex justify-between items-start gap-4">
                <div>
                  <p class="font-light text-stone-800">{{ item.name }}</p>
                  <p v-if="item.description" class="text-xs text-stone-500 mt-1 leading-relaxed">
                    {{ item.description }}
                  </p>
                </div>
                <p v-if="item.price" class="text-sm text-stone-700 shrink-0">
                  ¥{{ Number(item.price).toLocaleString() }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <p v-else class="mt-20 text-center text-stone-400 text-sm">
        メニューは準備中です
      </p>

      <p class="mt-16 text-xs text-stone-400 text-center">
        ※ 価格はすべて税込みです。メニューは仕入れ状況により変更になる場合があります。
      </p>
    </div>
  </AppLayout>
</template>
