<template>
  <div class="w-full grid grid-cols-1 sm:grid-cols-4 mt-5 gap-2">
    <div class="col-span-1">
      <div class="hidden sm:block divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow">
        <Link
          v-for="ch in chats"
          :key="ch.id"
          :href="`/chats/${ch.id}`"
          class="block px-6 py-4 hover:bg-gray-100 text-primary-500"
          :class="ch.id === chat.id ? 'bg-amber-50' : ''"
        >
          {{ getReceiver(ch)?.name }}
          <XBadge color="success" size="small" :text="getUnreadCount(ch).toString()" class="ml-2" />
        </Link>
      </div>

      <div class="flex sm:hidden divide-x divide-gray-200 rounded-lg bg-white shadow overflow-x-scroll">
        <Link
          v-for="ch in chats"
          :key="ch.id"
          :href="`/chats/${ch.id}`"
          class="block px-6 py-4 hover:bg-gray-100 text-primary-500"
          :class="ch.id === chat.id ? 'bg-amber-50' : ''"
        >
          {{ getReceiver(ch)?.name }}
          <XBadge color="success" size="small" :text="getUnreadCount(ch).toString()" class="ml-2" />
        </Link>
      </div>
    </div>
    <div class="grid-cols-1 sm:col-span-3">
      <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow">
        <div class="bg-blue-400 px-4 py-5 sm:px-6 text-white font-semibold text-lg">{{ receiver?.name }}</div>

        <div class="px-4 py-5 sm:px-6">
          <div class="flex gap-2 items-center">
            <input v-model="enterToSend" type="checkbox" id="enterToSend" />
            <label for="enterToSend">Use ENTER to Send</label>
          </div>

          <XTextarea
            v-model="form.content"
            :placeholder="'Write something...' + (enterToSend ? ' and press ENTER' : '')"
            :errors="errors?.content"
            :rows="enterToSend ? 3 : 5"
            @keyup.enter="
              () => {
                enterToSend ? sendMessage() : '';
              }
            "
          />

          <XFileUpload
            v-if="showUploader"
            v-model="form.files"
            multiple
            accept="image/*,video/*,audio/*"
            :errors="errors?.files"
            @hide="showUploader = false"
          />

          <div class="flex justify-between">
            <XButton
              v-if="!enterToSend || showUploader"
              label="Send Message"
              color="primary"
              @click="sendMessage"
              :loading="form.processing"
            />
            <XButton v-if="!showUploader" label="Add Files" color="secondary" @click="showUploader = true" />
          </div>

          <div class="h-2"></div>

          <SingleMessage v-for="message in messages.data" :message="message" />

          <div class="flex gap-2 justify-center mt-10">
            <Link v-if="messages.links?.prev" :href="messages.links.prev"><XButton label="Prev Page" /></Link>
            <Link v-if="messages.links?.next" :href="messages.links.next"><XButton label="Next Page" /></Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import type { Chat, Message } from '@/types/chat';
import { computed, ref } from 'vue';
import type { AnyObject, InertiaProps, PaginatedData } from '@/types';
import SingleMessage from '@/sections/SingleMessage.vue';
import XTextarea from '@/components/XTextarea.vue';
import XFileUpload from '@/components/XFileUpload.vue';
import XButton from '@/components/XButton.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import XBadge from '@/components/XBadge.vue';
import XSelect from '@/components/XSelect.vue';

let { chat, chats, messages, user, errors } = defineProps<
  { chat: Chat; chats: Chat[]; messages: PaginatedData<Message> } & InertiaProps
>();

setInterval(() => router.reload(), 10 * 1000);

const enterToSend = ref<boolean>(true);
const showUploader = ref(false);
const selectedChatId = ref<number>(chat.id);
const form = useForm<{ content: string; files?: any[] }>({ content: '' });

const receiver = computed(() => getReceiver(chat));

function getReceiver(chat: Chat) {
  return chat.user1?.id === user?.id ? chat.user2 : chat.user1;
}

function getUnreadCount(chat: Chat) {
  return chat.user1?.id === user?.id ? chat.user1_unread_count : chat.user2_unread_count;
}

function sendMessage() {
  const url = `/chats/${chat.id}/messages`;

  if (!form.files?.length) {
    form.post(url, {
      onStart: () => {
        form.content = '';
        form.files = [];
      },
    });
    return;
  }

  router.post(
    url,
    {
      content: form.content,
      files: form.files,
    },
    {
      onStart: () => {
        form.content = '';
        form.files = [];
        showUploader.value = false;
        form.processing = true;
      },
      onFinish: () => (form.processing = false),
      onError: (err: AnyObject) => {
        console.log(err);
        errors = { message: 'Error', ...err };
      },
    }
  );
}
</script>
