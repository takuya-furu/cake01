<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <footer class="bg-stone-900 text-stone-400 py-16 px-6 mt-auto">
    <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-10">
      <div>
        <p class="text-white text-lg tracking-widest font-light mb-3">UN GRAIN</p>
        <p class="text-sm leading-relaxed">
          駅近のケーキ屋・イートインカフェ。<br>
          こだわりのケーキで、日常に特別な時間を。
        </p>
      </div>

      <div>
        <p class="text-white text-xs tracking-widest mb-4">NAVIGATION</p>
        <nav class="flex flex-col gap-2">
          <Link v-for="link in [
            { href: '/products', label: 'ケーキ一覧' },
            { href: '/menu',     label: 'イートインメニュー' },
            { href: '/news',     label: 'お知らせ' },
            { href: '/store',    label: '店舗情報' },
            { href: '/contact',  label: 'お問い合わせ' },
          ]"
            :key="link.href"
            :href="link.href"
            class="text-sm hover:text-white transition"
          >
            {{ link.label }}
          </Link>
        </nav>
      </div>

      <div>
        <p class="text-white text-xs tracking-widest mb-4">STORE INFO</p>
        <dl class="text-sm space-y-1">
          <div class="flex gap-3">
            <dt class="text-stone-500 shrink-0">営業時間</dt>
            <dd>11:00 - 19:00</dd>
          </div>
          <div class="flex gap-3">
            <dt class="text-stone-500 shrink-0">定休日</dt>
            <dd>月曜日</dd>
          </div>
          <div class="flex gap-3">
            <dt class="text-stone-500 shrink-0">席数</dt>
            <dd>20席 (イートイン)</dd>
          </div>
        </dl>
      </div>
    </div>

    <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-stone-800 text-center text-xs text-stone-600">
      © {{ new Date().getFullYear() }} UN GRAIN. All rights reserved.
    </div>
  </footer>
</template>
