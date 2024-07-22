<template>
  <XCard class="my-2.5">
    <template #header>
      <h3 class="font-semibold">{{ userData.name }}</h3>
    </template>

    <template #footer>
      <div class="flex gap-2">
        <XButton disabled label="Message (upcoming)" color="secondary" @click="postStatus" :loading="form.processing" />
      </div>
    </template>
  </XCard>

  <PaginatedPosts :posts="posts" />
</template>
<script setup lang="ts">
import type { InertiaProps, PaginatedData } from '@/types';
import type { Post } from '@/types/post';
import { Link, router, useForm } from '@inertiajs/vue3';
import XButton from '@/components/XButton.vue';
import PaginatedPosts from '@/sections/PaginatedPosts.vue';
import type { User } from '@/types/user';
import XCard from '@/components/XCard.vue';

const props = defineProps<{ userData: User; posts: PaginatedData<Post> } & InertiaProps>();

const form = useForm<{ content: string }>({ content: '' });

function postStatus() {
  form.post('/posts');
}
</script>
