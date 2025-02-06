<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
  canLogin?: boolean;
  canRegister?: boolean;
}>();
</script>

<template>
  <Head title="FlixFlex - Stream Your Favorites" />
  <div class="bg-gray-900 text-white">
    <div class="relative min-h-screen flex flex-col">
      <nav class="absolute right-0 top-0 p-6">
        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
              class="text-white/90 hover:text-white focus:outline-none">
          Dashboard
        </Link>
        <template v-else>
          <Link :href="route('login')"
                class="text-white/90 hover:text-white focus:outline-none">
            Log in
          </Link>
          <Link v-if="canRegister" :href="route('register')"
                class="ml-4 text-white/90 hover:text-white focus:outline-none">
            Register
          </Link>
        </template>
      </nav>

      <div class="container mx-auto flex px-5 py-24 items-center justify-center flex-col">
        <img src="/images/movie.svg" alt="Movie Streaming" class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-contain h-64">
        <div class="text-center lg:w-2/3 w-full">
          <h1 class="title-font sm:text-5xl text-4xl mb-4 font-bold bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">
            Your Entertainment, Your Way
          </h1>
          <p class="mb-8 leading-relaxed text-gray-300 text-lg">
            Stream unlimited movies and TV shows anytime, anywhere. Join FlixFlex today and discover a world of entertainment at your fingertips.
          </p>
          <div class="flex justify-center gap-4">
            <Link :href="route('register')"
                  class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
              Start Watching
              <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
            </Link>
            <Link :href="route('movies.index')"
                  class="inline-flex items-center bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
              Browse Movies
            </Link>
          </div>
        </div>
      </div>

      <footer class="absolute bottom-0 w-full py-6 text-center text-sm text-gray-400">
        © 2025 FlixFlex. Stream endlessly.
      </footer>
    </div>
  </div>
</template>