<template>
  <div
    class="overflow-hidden rounded-lg shadow px-4 py-5 sm:p-6 my-2.5"
    :class="post.is_new ? 'bg-primary-50' : 'bg-white'"
  >
    <div class="flex justify-between">
      <div class="font-medium text-primary-500">
        <Link :href="`/profile/${post.user.username}`">{{ post.user.name }}</Link>
      </div>
      <div class="text-sm text-gray-400">~ {{ post.created_ago }}</div>
    </div>
    <p class="text-gray-600" v-html="post.content.replaceAll('\n', '<br/>')"></p>
    <div v-if="post.files && post.files.length > 0" class="mt-2.5 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
      <template v-for="file in post.files" :key="file.path">
        <a :href="file.path" target="_blank">
          <img :src="file.path" />
        </a>
      </template>
    </div>
  </div>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { Post } from '@/types/post';

defineProps<{ post: Post }>();
</script>
