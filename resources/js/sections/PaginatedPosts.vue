<template>
  <PostList :posts="posts.data" />

  <div class="flex gap-2 justify-center mt-10">
    <Link v-if="posts.links?.prev" :href="posts.links.prev"><XButton label="Prev Page" /></Link>
    <Link v-if="posts.links?.next" :href="posts.links.next"><XButton label="Next Page" /></Link>
  </div>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { Post } from '@/types/post';
import type { PaginatedData } from '@/types';
import XButton from '@/components/XButton.vue';
import PostList from '@/sections/PostList.vue';

defineProps<{ posts: PaginatedData<Post> }>();
</script>
