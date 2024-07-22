<template>
  <div class="bg-blue-500">
    <div class="container mx-auto">
      <div class="flex items-center py-4 justify-between">
        <Link href="/"><x-button label="Home" color="secondary" rounded /></Link>

        <div class="flex gap-2">
          <template v-if="!user">
            <Link href="/auth/login">
              <XButton label="Login" color="primary" />
            </Link>
            <Link href="/auth/register">
              <XButton label="Register" color="secondary" />
            </Link>
          </template>
          <template v-else>
            <Link href="/auth/logout">
              <XButton :label="`Logout (${user?.name})`" color="secondary" />
            </Link>
          </template>
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
