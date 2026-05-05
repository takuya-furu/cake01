<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const menuOpen = ref(false)

const navLinks = [
  { href: '/products', label: 'CAKE' },
  { href: '/menu',     label: 'MENU' },
  { href: '/news',     label: 'NEWS' },
  { href: '/store',    label: 'STORE' },
  { href: '/contact',  label: 'CONTACT' },
]
</script>

<template>
  <header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-sm border-b border-stone-100">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
      <Link href="/" class="text-xl tracking-[0.3em] font-light text-stone-800 hover:opacity-70 transition">
        UN GRAIN
      </Link>

      <!-- PC nav -->
      <nav class="hidden md:flex items-center gap-8">
        <Link
          v-for="link in navLinks"
          :key="link.href"
          :href="link.href"
          class="text-xs tracking-widest text-stone-600 hover:text-stone-900 transition"
        >
          {{ link.label }}
        </Link>
      </nav>

      <!-- Mobile hamburger -->
      <button
        class="md:hidden flex flex-col gap-1.5 p-2"
        @click="menuOpen = !menuOpen"
        aria-label="メニューを開く"
      >
        <span
          class="block w-6 h-px bg-stone-800 transition-transform duration-300"
          :class="{ 'rotate-45 translate-y-2.5': menuOpen }"
        />
        <span
          class="block w-6 h-px bg-stone-800 transition-opacity duration-300"
          :class="{ 'opacity-0': menuOpen }"
        />
        <span
          class="block w-6 h-px bg-stone-800 transition-transform duration-300"
          :class="{ '-rotate-45 -translate-y-2.5': menuOpen }"
        />
      </button>
    </div>

    <!-- Mobile menu -->
    <div
      class="md:hidden overflow-hidden transition-all duration-300 bg-white border-t border-stone-100"
      :class="menuOpen ? 'max-h-80' : 'max-h-0'"
    >
      <nav class="flex flex-col py-4">
        <Link
          v-for="link in navLinks"
          :key="link.href"
          :href="link.href"
          class="px-6 py-3 text-sm tracking-widest text-stone-600 hover:bg-stone-50 transition"
          @click="menuOpen = false"
        >
          {{ link.label }}
        </Link>
      </nav>
    </div>
  </header>

  <!-- ヘッダーの高さ分のスペーサー（Heroセクションがある場合は不要） -->
  <div class="h-16" aria-hidden="true" />
</template>
