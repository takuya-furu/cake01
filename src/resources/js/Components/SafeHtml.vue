<script setup>
import { computed } from 'vue'
import DOMPurify from 'dompurify'

const props = defineProps({
  html: { type: String, required: true },
})

const sanitized = computed(() =>
  DOMPurify.sanitize(props.html, {
    ALLOWED_TAGS: ['h2', 'h3', 'p', 'strong', 'em', 'ul', 'ol', 'li', 'a', 'img', 'br', 'blockquote'],
    ALLOWED_ATTR: ['href', 'src', 'alt', 'target', 'rel', 'class'],
  })
)
</script>

<template>
  <div
    class="prose prose-stone max-w-none
      prose-h2:text-xl prose-h2:font-light prose-h2:tracking-wide
      prose-h3:text-lg prose-h3:font-light
      prose-a:text-stone-700 prose-a:underline
      prose-img:rounded"
    v-html="sanitized"
  />
</template>
