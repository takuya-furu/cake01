<script setup>
import AppLayout from '@/Components/AppLayout.vue'
import SectionTitle from '@/Components/SectionTitle.vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

defineProps({
  meta: { type: Object, default: () => ({}) },
})

const flash = computed(() => usePage().props.flash ?? {})

const form = useForm({
  name:    '',
  email:   '',
  message: '',
})

const submit = () => {
  form.post('/contact', {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <AppLayout :meta="meta">
    <div class="max-w-2xl mx-auto px-6 py-20">
      <SectionTitle en="CONTACT" ja="お問い合わせ" />

      <!-- 送信完了メッセージ -->
      <div
        v-if="flash.success"
        class="mt-10 p-4 bg-stone-50 border border-stone-200 text-stone-700 text-sm text-center"
      >
        {{ flash.success }}
      </div>

      <form class="mt-14 space-y-8" @submit.prevent="submit">
        <div>
          <label class="block text-xs tracking-widest text-stone-500 mb-2">
            お名前 <span class="text-rose-400">*</span>
          </label>
          <input
            v-model="form.name"
            type="text"
            class="w-full border-b border-stone-300 py-2 text-sm font-light focus:outline-none focus:border-stone-800 transition bg-transparent"
            placeholder="山田 花子"
          />
          <p v-if="form.errors.name" class="mt-1 text-xs text-rose-500">{{ form.errors.name }}</p>
        </div>

        <div>
          <label class="block text-xs tracking-widest text-stone-500 mb-2">
            メールアドレス <span class="text-rose-400">*</span>
          </label>
          <input
            v-model="form.email"
            type="email"
            class="w-full border-b border-stone-300 py-2 text-sm font-light focus:outline-none focus:border-stone-800 transition bg-transparent"
            placeholder="example@email.com"
          />
          <p v-if="form.errors.email" class="mt-1 text-xs text-rose-500">{{ form.errors.email }}</p>
        </div>

        <div>
          <label class="block text-xs tracking-widest text-stone-500 mb-2">
            メッセージ <span class="text-rose-400">*</span>
          </label>
          <textarea
            v-model="form.message"
            rows="6"
            class="w-full border-b border-stone-300 py-2 text-sm font-light focus:outline-none focus:border-stone-800 transition resize-none bg-transparent"
            placeholder="お問い合わせ内容をご記入ください"
          />
          <p v-if="form.errors.message" class="mt-1 text-xs text-rose-500">{{ form.errors.message }}</p>
        </div>

        <div class="pt-4 text-center">
          <button
            type="submit"
            :disabled="form.processing"
            class="border border-stone-800 text-stone-800 text-xs tracking-widest px-16 py-3 hover:bg-stone-800 hover:text-white transition-colors duration-300 disabled:opacity-40"
          >
            {{ form.processing ? '送信中...' : '送 信' }}
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
