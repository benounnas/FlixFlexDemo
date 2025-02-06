<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import MovieCard from "@/Components/Base/MovieCard.vue"
import Pagination from '@/Components/Base/Pagination.vue'

defineProps({
  movies: {
    type: Array,
    default: () => [],
    item: {
      id: Number,
      title: String,
      poster_path: String,
      release_date: String,
      vote_average: Number,
      adult: Boolean,
      overview: String,
      genre_ids: Array,
      original_language: String,
      popularity: Number,
      vote_count: Number,
      video: Boolean,
      backdrop_path: String,
      original_title: String
    }
  },
  currentPage: Number,
  totalPages: Number,
  totalResults: Number
})
</script>

<template>
  <Head title="Movies" />

  <DefaultLayout>
    <div class="container mx-auto px-4 py-8">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Movies</h1>
        <p class="text-gray-600">Total: {{ totalResults }}</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
        <MovieCard v-for="movie in movies" :key="movie.id" :movie="movie" />
      </div>

      <div class="mt-8">
        <Pagination
            :current-page="currentPage"
            :total-pages="totalPages"
            base-url="movies"
        />
      </div>
    </div>
  </DefaultLayout>
</template>