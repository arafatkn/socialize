<template>
  <div class="grid grid-cols-4 mt-5 gap-2">
    <div class="col-span-1">
      <Link v-for="chat in chats" :key="chat.id" :href="`/chats/${chat.id}`" class="text-primary-500">
        <XBox>{{ getReceiver(chat)?.name }}</XBox>
      </Link>
    </div>
    <div class="col-span-3">
      <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow">
        <div class="bg-blue-400 px-4 py-5 sm:px-6 text-white font-semibold text-lg">{{ receiver?.name }}</div>

        <div class="px-4 py-5 sm:px-6">
          <XBox class="my-2.5">
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
              <!--              <XButton v-if="!showUploader" label="Add Files" color="secondary" @click="showUploader = true" />-->
            </div>
          </XBox>

          <SingleMessage v-for="message in messages.data" :message="message" />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import XBox from '@/components/XBox.vue';
import type { Chat, Message } from '@/types/chat';
import { computed, ref } from 'vue';
import type { AnyObject, InertiaProps, PaginatedData } from '@/types';
import SingleMessage from '@/sections/SingleMessage.vue';
import XTextarea from '@/components/XTextarea.vue';
import XFileUpload from '@/components/XFileUpload.vue';
import XButton from '@/components/XButton.vue';
import { Link, router, useForm } from '@inertiajs/vue3';

let { chat, chats, messages, user, errors } = defineProps<
  { chat: Chat; chats: Chat[]; messages: PaginatedData<Message> } & InertiaProps
>();

setInterval(() => router.reload(), 10 * 1000);

const enterToSend = ref<boolean>(true);
const showUploader = ref(false);
const form = useForm<{ content: string; files?: any[] }>({ content: '' });

const receiver = computed(() => getReceiver(chat));

function getReceiver(chat: Chat) {
  return chat.user1?.id === user?.id ? chat.user2 : chat.user1;
}

function sendMessage() {
  const url = `/chats/${chat.id}/messages`;

  if (!form.files?.length) {
    form.post(url, {
      onSuccess: () => {
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
      onStart: () => (form.processing = true),
      onSuccess: () => {
        form.content = '';
        form.files = [];
        showUploader.value = false;
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
