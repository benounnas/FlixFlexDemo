<!-- components/Base/Pagination.vue -->
<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

defineProps<{
  currentPage: number
  totalPages: number
  baseUrl: string
}>()
</script>

<template>
  <div class="flex items-center justify-center gap-2">
    <Link
        v-if="currentPage > 1"
        :href="`/${baseUrl}?page=${currentPage - 1}`"
        class="px-4 py-2 bg-white border rounded-lg hover:bg-gray-50"
    >
      Previous
    </Link>

    <Link
        v-if="currentPage < totalPages"
        :href="`/${baseUrl}?page=${currentPage + 1}`"
        class="px-4 py-2 bg-white border rounded-lg hover:bg-gray-50"
    >
      Next
    </Link>
  </div>
</template>