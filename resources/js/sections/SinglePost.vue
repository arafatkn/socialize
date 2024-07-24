<template>
  <div
    class="overflow-hidden rounded-lg shadow px-4 py-5 sm:p-6 my-2.5"
    :class="post.is_new ? 'bg-primary-50' : 'bg-white'"
  >
    <div class="flex justify-between">
      <div class="font-medium text-primary-500">
        <Link :href="`/profile/${post.user.username}`">{{ post.user.name }}</Link>
        <div class="text-sm text-gray-400">~ {{ post.created_ago }}</div>
      </div>
      <div class="text-sm text-gray-400" v-if="($page.props.user as User)?.permissions?.admin">
        <XButton v-if="post.pinned" size="small" label="Unpin" color="secondary" @click="unpinPost(post.id)" />
        <XButton v-else size="small" label="Pin This" color="secondary" @click="pinPost(post.id)" />
      </div>
    </div>
    <p class="text-gray-600" v-html="post.content.replaceAll('\n', '<br/>')"></p>
    <div v-if="post.files && post.files.length > 0" class="mt-2.5 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
      <div v-for="file in post.files" :key="file.path">
        <video v-if="file.mime?.startsWith('video/')" :src="file.path" controls />
        <audio v-else-if="file.mime?.startsWith('audio/')" :src="file.path" controls />
        <a v-else :href="file.path" target="_blank"><img :src="file.path" /></a>
        <a :href="file.path" class="text-primary-400" target="_blank"
          >Download
          <span v-if="file.size"
            >(<span v-if="file.size > 1024 * 1024">{{ (file.size / (1024 * 1024)).toFixed(2) }} MB</span
            ><span v-else>{{ (file.size / 1024).toFixed(2) }} KB</span>)</span
          ></a
        >
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';
import type { Post } from '@/types/post';
import XButton from '@/components/XButton.vue';
import type { User } from '@/types/user';

defineProps<{ post: Post }>();
const $page = usePage();

const form = useForm<{}>({});

function pinPost(id: number) {
  form.post(`/posts/${id}/pin`, {
    preserveScroll: true,
  });
}

function unpinPost(id: number) {
  form.post(`/posts/${id}/unpin`, {
    preserveScroll: true,
  });
}
</script>
