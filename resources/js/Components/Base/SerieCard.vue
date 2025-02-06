<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3'
import { MediaType } from '@/types/enums'

const props = defineProps<{
  serie: {
    id: number,
    name: string,
    poster_path: string,
    first_air_date: string,
    vote_average: number,
    overview: string
  }
}>()

const toggleFavorite = () => {
  router.post(route('favorites.toggle'), {
    media_id: props.serie.id,
    media_type: MediaType.TV
  })
}
</script>

<template>
  <div class="bg-white shadow-xl rounded-xl overflow-hidden">
    <Link
        :href="route('series.show', serie.id)"
        class="block hover:scale-105 transition duration-200"
    >
      <img
          :src="`https://image.tmdb.org/t/p/w500${serie.poster_path}`"
          :alt="serie.name"
          class="w-full h-[400px] object-cover"
      />
      <div class="p-4">
        <h2 class="text-xl font-bold line-clamp-1">{{ serie.name }}</h2>
        <p class="text-gray-500 text-sm">{{ new Date(serie.first_air_date).getFullYear() }}</p>
        <p class="mt-2 text-sm line-clamp-2 text-gray-600">{{ serie.overview }}</p>
      </div>
    </Link>
    <div class="px-4 pb-4 flex items-center justify-between">
      <div class="flex items-center gap-1">
        <span class="font-bold text-lg">{{ serie.vote_average.toFixed(1) }}</span>
        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
        </svg>
      </div>
      <button
          @click="toggleFavorite"
          class="text-red-500 hover:text-red-600"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
      </button>
    </div>
  </div>
</template>