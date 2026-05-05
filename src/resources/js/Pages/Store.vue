<script setup>
import AppLayout from '@/Components/AppLayout.vue'
import SectionTitle from '@/Components/SectionTitle.vue'

defineProps({
  meta: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppLayout :meta="meta">
    <div class="max-w-4xl mx-auto px-6 py-20">
      <SectionTitle en="STORE" ja="店舗情報" />

      <div class="mt-16 grid md:grid-cols-2 gap-12">
        <!-- 店舗写真プレースホルダー -->
        <div class="aspect-[4/3] bg-stone-100 flex items-center justify-center">
          <p class="text-stone-400 text-sm tracking-widest">STORE IMAGE</p>
        </div>

        <!-- 店舗詳細 -->
        <div>
          <p class="text-xl font-light tracking-widest text-stone-800 mb-8">UN GRAIN</p>
          <dl class="space-y-5 text-sm">
            <div class="flex gap-6">
              <dt class="text-stone-400 tracking-wider shrink-0 w-20">住所</dt>
              <dd class="text-stone-700 font-light leading-relaxed">
                〒000-0000<br>東京都〇〇区〇〇 1-2-3
              </dd>
            </div>
            <div class="flex gap-6">
              <dt class="text-stone-400 tracking-wider shrink-0 w-20">アクセス</dt>
              <dd class="text-stone-700 font-light">〇〇線「〇〇駅」徒歩2分</dd>
            </div>
            <div class="flex gap-6">
              <dt class="text-stone-400 tracking-wider shrink-0 w-20">営業時間</dt>
              <dd class="text-stone-700 font-light">11:00 〜 19:00</dd>
            </div>
            <div class="flex gap-6">
              <dt class="text-stone-400 tracking-wider shrink-0 w-20">定休日</dt>
              <dd class="text-stone-700 font-light">月曜日</dd>
            </div>
            <div class="flex gap-6">
              <dt class="text-stone-400 tracking-wider shrink-0 w-20">席数</dt>
              <dd class="text-stone-700 font-light">20席（イートイン）</dd>
            </div>
            <div class="flex gap-6">
              <dt class="text-stone-400 tracking-wider shrink-0 w-20">TEL</dt>
              <dd class="text-stone-700 font-light">00-0000-0000</dd>
            </div>
          </dl>
        </div>
      </div>

      <!-- 地図プレースホルダー -->
      <div class="mt-16 aspect-video bg-stone-100 flex items-center justify-center border border-stone-200">
        <p class="text-stone-400 text-sm tracking-widest">Google Maps</p>
      </div>
    </div>
  </AppLayout>
</template>
