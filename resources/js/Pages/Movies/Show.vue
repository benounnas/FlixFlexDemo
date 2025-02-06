<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { MediaType } from '@/types/enums'
import { useForm } from '@inertiajs/vue3'
import { Toaster, toast } from 'vue-sonner'
import {Movie} from "@/types/movies";

interface Props {
  movie: Movie & {
    is_favorite: boolean
  }
}

const props = defineProps<Props>()
const error = ref<string>('')
const isSubmitting = ref(false)
const isFavorite = ref(props.movie.is_favorite)

const form = useForm({
  media_id: props.movie.id,
  media_type: MediaType.MOVIE
})

const toggleFavorite = async () => {
  if (isSubmitting.value) return

  try {
    isSubmitting.value = true
    error.value = ''

    form.post(route('favorites.toggle'), {
      preserveScroll: true,
      preserveState: true,
      onSuccess: (page) => {
        isFavorite.value = !isFavorite.value
        if (page.props.flash.message) {
          toast.success(page.props.flash.message)
        }
      },
      onError: (errors) => {
        error.value = errors.message || 'An error occurred while updating favorites'
        toast.error(error.value)
      }
    })
  } catch (e) {
    error.value = 'An unexpected error occurred'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<template>
  <Head :title="movie.title" />
  <DefaultLayout>
    <Toaster position="top-right" />
    <div class="container mx-auto px-4 py-8">
      <div class="relative h-[400px] mb-8 rounded-xl overflow-hidden">
        <img
            :src="`https://image.tmdb.org/t/p/original${movie.backdrop_path}`"
            class="w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent" />
        <div class="absolute bottom-0 p-8">
          <div class="flex items-center gap-4">
            <h1 class="text-4xl font-bold text-white mb-2">{{ movie.title }}</h1>
            <button
                @click="toggleFavorite"
                :disabled="isSubmitting"
                class="text-red-500 hover:text-red-600 bg-white rounded-full p-2 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :fill="isFavorite ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
            </button>
          </div>
          <div class="flex items-center gap-4 text-white/80">
            <span>{{ new Date(movie.release_date).getFullYear() }}</span>
            <span>{{ movie.runtime }} min</span>
            <div class="flex items-center gap-1">
              <span class="font-bold">{{ movie.vote_average.toFixed(1) }}</span>
              <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
              </svg>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
          <img
              :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
              :alt="movie.title"
              class="w-full rounded-xl shadow-lg"
          />
        </div>

        <div class="md:col-span-2">
          <div class="flex gap-2 mb-4">
            <span v-for="genre in movie.genres" :key="genre.id"
                  class="px-3 py-1 bg-gray-100 rounded-full text-sm">
              {{ genre.name }}
            </span>
          </div>

          <p class="text-lg mb-8">{{ movie.overview }}</p>

          <div class="grid grid-cols-2 gap-4">
            <div v-if="movie.production_companies?.length" class="mb-4">
              <h3 class="font-bold mb-2">Production</h3>
              <div class="text-sm text-gray-600">
                {{ movie.production_companies.map(company => company.name).join(', ') }}
              </div>
            </div>

            <div v-if="movie.spoken_languages?.length" class="mb-4">
              <h3 class="font-bold mb-2">Languages</h3>
              <div class="text-sm text-gray-600">
                {{ movie.spoken_languages.map(lang => lang.english_name).join(', ') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </DefaultLayout>
</template>