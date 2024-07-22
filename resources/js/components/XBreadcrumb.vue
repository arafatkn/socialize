<template>
  <div class="mb-4">
    <nav class="sm:hidden" aria-label="Back">
      <a href="#" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
        <ChevronLeftIcon class="-ml-1 mr-1 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
        Back
      </a>
    </nav>
    <nav class="hidden sm:flex" aria-label="Breadcrumb">
      <ol role="list" class="flex items-center space-x-4">
        <li>
          <div class="flex">
            <router-link to="/admin" class="text-sm font-medium text-gray-500 hover:text-gray-700">
              Dashboard
            </router-link>
          </div>
        </li>
        <li>
          <div class="flex items-center">
            <ChevronRightIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Engineering</a>
          </div>
        </li>
        <li>
          <div class="flex items-center">
            <ChevronRightIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
            <a href="#" aria-current="page" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
              >Back End Developer</a
            >
          </div>
        </li>
      </ol>
    </nav>
  </div>
</template>

<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid';
</script>
