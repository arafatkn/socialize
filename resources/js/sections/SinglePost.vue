<template>
  <XBox class="my-2.5" :class="post.is_new ? ' bg-primary-50' : ''">
    <div class="flex justify-between">
      <div class="font-medium text-primary-500">
        <Link :href="`/profile/${post.user.username}`">{{ post.user.name }}</Link>
      </div>
      <div class="text-sm text-gray-400">~ {{ post.created_ago }}</div>
    </div>
    <p class="text-gray-600" v-html="post.content.replaceAll('\n', '<br/>')"></p>
  </XBox>
</template>
<script setup lang="ts">
import XBox from '@/components/XBox.vue';
import { Link } from '@inertiajs/vue3';
import type { Post } from '@/types/post';

defineProps<{ post: Post }>();
</script>
