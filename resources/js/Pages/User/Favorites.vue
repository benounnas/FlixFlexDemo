<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

defineProps<{
  movies: any[]
  series: any[]
}>()
</script>

<template>
  <Head title="My Favorites" />
  <DefaultLayout>
    <div class="max-w-7xl mx-auto p-6">
      <h2 class="text-2xl font-bold mb-6">Favorite Movies</h2>
      <div v-if="movies.length > 0" class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div v-for="movie in movies" :key="movie.id" class="bg-white rounded-lg shadow">
            <img
                :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
                :alt="movie.title"
                class="w-full h-[300px] object-cover rounded-t-lg"
            />
            <div class="p-4">
              <h3 class="font-bold">{{ movie.title }}</h3>
              <p class="text-sm text-gray-600">
                {{ new Date(movie.release_date).getFullYear() }}
              </p>
            </div>
        </div>
      </div>
      <div v-else class="text-center py-6 text-gray-500">
        No favorite movies yet
      </div>

      <h2 class="text-2xl font-bold mb-6">Favorite Series</h2>
      <div v-if="series.length" class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div v-for="show in series" :key="show.id" class="bg-white rounded-lg shadow">
            <img
                :src="`https://image.tmdb.org/t/p/w500${show.poster_path}`"
                :alt="show.name"
                class="w-full h-[300px] object-cover rounded-t-lg"
            />
            <div class="p-4">
              <h3 class="font-bold">{{ show.name }}</h3>
              <p class="text-sm text-gray-600">
                {{ new Date(show.first_air_date).getFullYear() }}
              </p>
            </div>
        </div>
      </div>
      <div v-else class="text-center py-6 text-gray-500">
        No favorite series yet
      </div>
    </div>
  </DefaultLayout>
</template>