<template>
  <div class="bg-blue-500">
    <div class="container mx-auto">
      <div class="flex items-center py-4 justify-between gap-1">
        <Link href="/"><x-button size="small" label="Home" color="secondary" rounded /></Link>

        <div class="flex gap-1">
          <Link href="/pinned"><x-button size="small" label="Pinned" color="info" rounded /></Link>
          <Link href="/chats"><x-button size="small" label="Messages" color="info" rounded /></Link>
          <Link v-if="user?.public_profile_url" :href="user?.public_profile_url"
            ><x-button size="small" label="Profile" color="info" rounded
          /></Link>
          <Link v-if="user?.permissions?.admin" href="/users"
            ><x-button size="small" label="Users" color="info" rounded
          /></Link>
        </div>

        <div class="flex gap-2">
          <Link href="/auth/logout">
            <XButton size="small" :label="`Logout`" color="secondary" />
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
