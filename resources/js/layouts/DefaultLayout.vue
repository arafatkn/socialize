<template>
  <Header :user="user" />
  <div class="container">
    <slot />
  </div>
</template>
<script setup lang="ts">
import Header from '@/layouts/components/Header.vue';
import type { InertiaProps } from '@/types';

defineProps<InertiaProps>();
</script>
