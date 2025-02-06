<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import Pagination from '@/Components/Base/Pagination.vue'
import SerieCard from "@/Components/Base/SerieCard.vue";

defineProps<{
  series: Array<{
    id: number,
    name: string,
    poster_path: string,
    first_air_date: string,
    vote_average: number,
    overview: string
  }>,
  currentPage: number,
  totalPages: number,
  totalResults: number
}>()
</script>

<template>
  <Head title="Series" />
  <DefaultLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
          <h1 class="text-3xl font-bold">Series</h1>
          <p class="text-gray-600">Total: {{ totalResults }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <SerieCard
              v-for="serie in series"
              :key="serie.id"
              :serie="serie"
          />
        </div>

        <div class="mt-8">
          <Pagination
              :current-page="currentPage"
              :total-pages="totalPages"
              base-url="series"
          />
        </div>
      </div>
    </div>
  </DefaultLayout>
</template>