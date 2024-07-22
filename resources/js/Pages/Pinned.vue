<template>
  <PaginatedPosts :posts="posts" />
</template>
<script setup lang="ts">
import type { InertiaProps, PaginatedData } from '@/types';
import type { Post } from '@/types/post';
import { router } from '@inertiajs/vue3';
import PaginatedPosts from '@/sections/PaginatedPosts.vue';

const props = defineProps<{ posts: PaginatedData<Post> } & InertiaProps>();

setInterval(() => router.reload(), 60 * 1000);
</script>
