<template>
  <div
    class="overflow-hidden rounded-lg shadow px-4 py-5 sm:p-6 my-2.5"
    :class="message.is_new ? 'bg-primary-50' : 'bg-white'"
  >
    <div class="flex justify-between">
      <div class="font-medium text-primary-500">
        <Link :href="`/profile/${message.sender.username}`">{{ message.sender.name }}</Link>
        <div class="text-sm text-gray-400">~ {{ message.created_ago }}</div>
      </div>
      <!--      <div class="text-sm text-gray-400">-->
      <!--        <XButton v-if="message.pinned" size="small" label="Unpin" color="secondary" @click="unpinPost(message.id)" />-->
      <!--        <XButton v-else size="small" label="Pin This" color="secondary" @click="pinPost(message.id)" />-->
      <!--      </div>-->
    </div>
    <p v-if="message.content" class="text-gray-600" v-html="message.content?.replaceAll('\n', '<br/>')"></p>
    <div v-if="message.files && message.files.length > 0" class="mt-2.5 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
      <div v-for="file in message.files" :key="file.path">
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
import { Link, useForm } from '@inertiajs/vue3';
import XButton from '@/components/XButton.vue';
import type { Message } from '@/types/chat';

defineProps<{ message: Message }>();

const form = useForm<{}>({});

function pinPost(id: number) {
  form.post(`/messages/${id}/pin`, {
    preserveScroll: true,
  });
}

function unpinPost(id: number) {
  form.post(`/messages/${id}/unpin`, {
    preserveScroll: true,
  });
}
</script>
