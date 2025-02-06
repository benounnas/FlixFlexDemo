<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { MediaType } from '@/types/enums'
import { useForm } from '@inertiajs/vue3'
import { Toaster, toast } from 'vue-sonner'

interface Season {
  air_date: string
  episode_count: number
  id: number
  name: string
  overview: string
  poster_path: string | null
  season_number: number
  vote_average: number
}

interface Network {
  id: number
  name: string
  logo_path: string
}

const props = defineProps<{
  serie: {
    is_favorite: boolean,
    id: number
    name: string
    poster_path: string
    backdrop_path: string
    first_air_date: string
    last_air_date: string
    vote_average: number
    overview: string
    number_of_seasons: number
    number_of_episodes: number
    status: string
    genres: Array<{ id: number, name: string }>
    created_by: Array<{ id: number, name: string }>
    networks: Network[]
    seasons: Season[]
    videos?: {
      results: Array<{ key: string }>
    }
    last_episode_to_air?: {
      name: string
      overview: string
      air_date: string
      episode_number: number
      season_number: number
    }
    next_episode_to_air?: {
      name: string
      overview: string
      air_date: string
      episode_number: number
      season_number: number
    }
  }
}>()

const error = ref<string>('')
const isSubmitting = ref(false)
const isFavorite = ref(props.serie.is_favorite)

const form = useForm({
  media_id: props.serie.id,
  media_type: MediaType.TV
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

watch(() => form.errors, (newErrors) => {
  if (Object.keys(newErrors).length > 0) {
    error.value = Object.values(newErrors)[0] as string
  }
}, { deep: true })
</script>

<template>
  <Head :title="serie.name" />
  <DefaultLayout>
    <Toaster position="top-right" />
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div v-if="error" class="bg-red-50 p-4 mb-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-red-700">{{ error }}</p>
              </div>
            </div>
          </div>

          <div class="relative h-[400px] mb-8">
            <img
                :src="`https://image.tmdb.org/t/p/original${serie.backdrop_path}`"
                :alt="serie.name"
                class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="absolute bottom-0 left-0 p-8 flex items-center gap-4">
              <h1 class="text-4xl font-bold text-white mb-2">{{ serie.name }}</h1>
              <button
                  @click="toggleFavorite"
                  :disabled="isSubmitting"
                  class="text-red-500 hover:text-red-600 bg-white rounded-full p-2 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :fill="isFavorite ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </button>
              <div class="flex items-center gap-2 text-sm text-white">
                <span>{{ new Date(serie.first_air_date).getFullYear() }}</span>
                <span>•</span>
                <span>{{ serie.number_of_seasons }} Seasons</span>
                <span>•</span>
                <span>{{ serie.number_of_episodes }} Episodes</span>
              </div>
            </div>
          </div>

          <div class="p-6">
            <p class="text-gray-600 mb-6 text-lg">{{ serie.overview }}</p>

            <div class="grid grid-cols-2 gap-4 mb-6">
              <div><strong>Status:</strong> {{ serie.status }}</div>
              <div><strong>First Air:</strong> {{ serie.first_air_date }}</div>
              <div><strong>Last Air:</strong> {{ serie.last_air_date }}</div>
              <div>
                <strong>Rating:</strong>
                <span class="flex items-center gap-1">
                 {{ serie.vote_average.toFixed(1) }}
                 <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                   <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                 </svg>
               </span>
              </div>
            </div>

            <div v-if="serie.networks?.length" class="mb-6">
              <strong>Networks:</strong>
              <div class="flex gap-4 mt-2">
                <img
                    v-for="network in serie.networks"
                    :key="network.id"
                    :src="`https://image.tmdb.org/t/p/w92${network.logo_path}`"
                    :alt="network.name"
                    class="h-8"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </DefaultLayout>
</template>