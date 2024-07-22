<template>
  <XBox class="my-2.5">
    <XTextarea
      v-model="form.content"
      label="What's on your mind?"
      placeholder="Write something..."
      :errors="errors?.content"
      :rows="5"
    />
    <XButton label="Post Your Thoughts" color="primary" @click="postStatus" :loading="form.processing" />
  </XBox>

  <PaginatedPosts :posts="posts" />
</template>
<script setup lang="ts">
import type { InertiaProps, PaginatedData } from '@/types';
import type { Post } from '@/types/post';
import XTextarea from '@/components/XTextarea.vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import XBox from '@/components/XBox.vue';
import XButton from '@/components/XButton.vue';
import PaginatedPosts from '@/sections/PaginatedPosts.vue';

const props = defineProps<{ posts: PaginatedData<Post> } & InertiaProps>();

setInterval(() => router.reload(), 7 * 1000);

const form = useForm<{ content: string }>({ content: '' });

function postStatus() {
  form.post('/posts', {
    onSuccess: () => {
      form.content = '';
    },
  });
}
</script>
