<template>
  <SinglePost v-for="post in posts" :post="post" />
</template>
<script setup lang="ts">
import type { Post } from '@/types/post';
import SinglePost from '@/sections/SinglePost.vue';

defineProps<{ posts: Post[] }>();
</script>
