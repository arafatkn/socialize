<template>
  <XBox v-for="user in users" :key="user.id" class="my-2.5">
    <div class="flex justify-between">
      <div>
        <XBadge :text="user.id.toString()" class="mr-2" color="success" size="small" />
        <Link class="font-medium text-primary-500" :href="`/profile/${user.username}`">{{ user.name }}</Link>
        - {{ user.permissions }}
      </div>
      <div class="text-sm text-gray-400"></div>
    </div>
    <p class="text-gray-600"></p>
  </XBox>
</template>
<script setup lang="ts">
import type { InertiaProps } from '@/types';
import type { User } from '@/types/user';
import { Link, router } from '@inertiajs/vue3';
import XBox from '@/components/XBox.vue';
import XBadge from '@/components/XBadge.vue';

const props = defineProps<{ users: User[] } & InertiaProps>();

setInterval(() => router.reload(), 60 * 1000);
</script>
