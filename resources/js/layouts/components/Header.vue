<template>
  <div class="bg-blue-500">
    <div class="container mx-auto">
      <div class="flex items-center py-4 justify-between gap-1">
        <Link href="/"><x-button label="Home" color="secondary" rounded /></Link>

        <div class="flex gap-1">
          <Link href="/pinned"><x-button label="Pinned" color="info" rounded /></Link>
          <!--          <Link href="/users"><x-button label="All Users" color="info" rounded /></Link>-->
          <Link href="/chats"><x-button label="Messages" color="info" rounded /></Link>
        </div>

        <div class="flex gap-2">
          <Link href="/auth/logout">
            <XButton :label="`Logout`" color="secondary" />
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import XButton from '@/components/XButton.vue';
import { Link } from '@inertiajs/vue3';
import type { User } from '@/types/user';

const props = defineProps<{ user?: User | null }>();
</script>
