<template>
  <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-white shadow">
    <button
      type="button"
      class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
      @click="$emit('sidebar')"
    >
      <span class="sr-only">Open sidebar</span>
      <Bars3BottomLeftIcon class="h-6 w-6" aria-hidden="true" />
    </button>
    <div class="flex flex-1 justify-between px-4">
      <div class="flex flex-1">
        <!--        <SearchBar />-->
      </div>
      <div class="ml-4 flex items-center md:ml-6">
        <Notifications />
        <!-- Profile dropdown -->
        <ProfileMenu />
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import Notifications from './NotificationsList.vue';
import ProfileMenu from './ProfileMenu.vue';
import SearchBar from './SearchBar.vue';
import { Bars3BottomLeftIcon } from '@heroicons/vue/24/outline';

defineEmits(['sidebar']);
</script>
