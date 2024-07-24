<template>
  <XCard class="my-2.5">
    <template #header>
      <h3 class="font-semibold">{{ userData.name }}</h3>
    </template>

    <template #footer>
      <div class="flex gap-2" v-if="userData.id !== user?.id">
        <Link v-if="chat" :href="`/chats/${chat.id}`">
          <XButton label="Message" color="secondary" />
        </Link>
        <XButton v-else label="Message" color="secondary" @click="messageModal = true" />
      </div>
      <div v-else>
        Profile Link:
        <Link class="text-primary-500" :href="user.public_profile_url">{{ user.public_profile_url }}</Link
        ><br />Share it with others to start chatting
      </div>
    </template>
  </XCard>

  <PaginatedPosts v-if="user?.permissions?.feed" :posts="posts" />

  <XModal
    :open="messageModal"
    :title="`Say Hi to ${userData.name}`"
    :loading="chatForm.processing"
    @ok="startChat"
    @close="messageModal = false"
  >
    <XTextarea
      v-model="chatForm.content"
      label="Your Message"
      :placeholder="'Write something...'"
      :errors="errors?.content"
    />
  </XModal>
</template>
<script setup lang="ts">
import type { InertiaProps, PaginatedData } from '@/types';
import type { Post } from '@/types/post';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import XButton from '@/components/XButton.vue';
import PaginatedPosts from '@/sections/PaginatedPosts.vue';
import type { User } from '@/types/user';
import XCard from '@/components/XCard.vue';
import XModal from '@/components/XModal.vue';
import { ref } from 'vue';
import XTextarea from '@/components/XTextarea.vue';
import type { Chat } from '@/types/chat';

const props = defineProps<{ userData: User; chat?: Chat; posts: PaginatedData<Post> } & InertiaProps>();

const $page = usePage();

const messageModal = ref(false);
const chatForm = useForm<{ receiver_id: number; content: string }>({ receiver_id: props.userData.id, content: '' });

function startChat() {
  chatForm.post('/chats', {
    onSuccess: (res) => {
      console.log(res);
    },
    onError: (err) => {
      console.log(err);
    },
  });
}
</script>
