<template>
  <XBox class="my-2.5">
    <div class="flex gap-2 items-center">
      <input v-model="enterToPost" type="checkbox" id="enterToPost" />
      <label for="enterToPost">Use ENTER to Post</label>
    </div>

    <XTextarea
      v-model="form.content"
      label="What's on your mind?"
      :placeholder="'Write something...' + (enterToPost ? ' and press ENTER' : '')"
      :errors="errors?.content"
      :rows="enterToPost ? 3 : 5"
      @keyup.enter="
        () => {
          enterToPost ? postStatus() : '';
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
        v-if="!enterToPost || showUploader"
        label="Post Your Thoughts"
        color="primary"
        @click="postStatus"
        :loading="form.processing"
      />
      <XButton v-if="!showUploader" label="Add Files" color="secondary" @click="showUploader = true" />
    </div>
  </XBox>

  <PaginatedPosts :posts="posts" />
</template>
<script setup lang="ts">
import type { AnyObject, InertiaProps, PaginatedData } from '@/types';
import type { Post } from '@/types/post';
import XTextarea from '@/components/XTextarea.vue';
import { useForm, router } from '@inertiajs/vue3';
import XBox from '@/components/XBox.vue';
import XButton from '@/components/XButton.vue';
import PaginatedPosts from '@/sections/PaginatedPosts.vue';
import { ref } from 'vue';
import XFileUpload from '@/components/XFileUpload.vue';

let { errors } = defineProps<{ posts: PaginatedData<Post> } & InertiaProps>();

setInterval(() => router.reload(), 7 * 1000);

const enterToPost = ref<boolean>(true);
const showUploader = ref(false);
const form = useForm<{ content: string; files?: any[] }>({ content: '' });

function postStatus() {
  if (!form.files?.length) {
    form.post('/posts', {
      onSuccess: () => {
        form.content = '';
        form.files = [];
      },
    });
    return;
  }

  router.post(
    '/posts',
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
