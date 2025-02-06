<script setup lang="ts">
import { Head, router, Link } from '@inertiajs/vue3'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import debounce from 'lodash/debounce'
import { ref, watch } from 'vue'

const props = defineProps<{
  results: any[]
  meta: {
    current_page: number
    total: number
    last_page: number
  }
  query?: string
}>()

const searchQuery = ref(props.query || '')

const search = debounce((value: string) => {
  if (value.length >= 2) {
    router.get(route('search.index'), { q: value }, { preserveState: true })
  }
}, 300)

watch(searchQuery, search)
</script>

<template>
  <Head title="Search" />
  <DefaultLayout>
    <div class="max-w-7xl mx-auto p-6">
      <input
          v-model="searchQuery"
          type="search"
          placeholder="Search movies and series..."
          class="w-full p-4 rounded-lg border mb-8"
      />

      <div v-if="results.length" class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div v-for="item in results" :key="item.id" class="bg-white rounded-lg shadow">
          <Link
              :href="route(`${item.media_type === 'movie' ? 'movies' : 'series'}.show`, item.id)"
          >
            <img
                :src="`https://image.tmdb.org/t/p/w500${item.poster_path}`"
                :alt="item.title || item.name"
                class="w-full h-[300px] object-cover rounded-t-lg"
            />
            <div class="p-4">
              <h3 class="font-bold">{{ item.title || item.name }}</h3>
              <p class="text-sm text-gray-600">
                {{ new Date(item.release_date || item.first_air_date).getFullYear() }}
              </p>
            </div>
          </Link>
        </div>
      </div>
      <div v-else-if="searchQuery" class="text-center py-12">
        No results found
      </div>
    </div>
  </DefaultLayout>
</template>