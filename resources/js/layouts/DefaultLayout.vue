<template>
  <Header :user="user" />
  <div class="container">
    <slot />
  </div>
  <div class="bg-primary-100 mt-5 text-primary-800">
    <div class="container mx-auto text-center px-4 py-5">Developed with Laravel + Inertia + Vue + Tailwind</div>
  </div>
</template>
<script setup lang="ts">
import Header from '@/layouts/components/Header.vue';
import type { InertiaProps } from '@/types';

defineProps<InertiaProps>();
</script>
