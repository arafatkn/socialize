<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import SocialAuth from '../../sections/SocialAuth.vue';
import XAlert from '../../components/XAlert.vue';
import XButton from '../../components/XButton.vue';
import type { InertiaProps } from '@/types';

type LoginFormType = {
  email: string;
  password: string;
};

const props = defineProps<InertiaProps>();

const login = ref<LoginFormType>({ email: '', password: '' });
const loading = ref(false);

const startLogin = () => {
  router.post('/auth/login', login.value);
};
</script>

<template>
  <Head title="Login" />
  <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Sign in to your account</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Or
        {{ ' ' }}
        <Link href="/auth/register" class="font-medium text-indigo-600 hover:text-indigo-500"
          >create an account for free</Link
        >
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form class="space-y-6" @submit.prevent="startLogin" method="POST">
          <div class="mb-6" v-if="errors?.message || Object.values(flash).filter((v) => v).length">
            <XAlert type="warning" v-if="!!flash?.message">{{ flash?.message }}</XAlert>
            <XAlert type="error" v-if="!!flash?.error">{{ flash?.error }}</XAlert>
            <XAlert type="success" v-if="!!flash?.success">{{ flash?.success }}</XAlert>
            <XAlert v-if="!!errors?.message" type="error">{{ errors?.message }}</XAlert>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <div class="mt-1">
              <input
                v-model="login.email"
                name="email"
                type="text"
                required
                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
              />
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1">
              <input
                v-model="login.password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
              />
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input
                id="remember-me"
                name="remember"
                type="checkbox"
                checked
                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
              />
              <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>

            <div class="text-sm">
              <Link href="/auth/lost-password" class="font-medium text-indigo-600 hover:text-indigo-500"
                >Forgot your password?</Link
              >
            </div>
          </div>

          <div>
            <XButton type="submit" :loading="loading" block color="primary" label="Sign In" class="text-center" />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
