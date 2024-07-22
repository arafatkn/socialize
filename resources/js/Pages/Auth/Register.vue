<script setup lang="ts">
import SocialAuth from '../../sections/SocialAuth.vue';
import { computed } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import XAlert from '../../components/XAlert.vue';
import XButton from '../../components/XButton.vue';
import type { InertiaProps } from '@/types';

const props = defineProps<InertiaProps>();

type FormType = {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
};

const msgType = computed(() => {
  if (props.errors?.message) {
    return 'error';
  }

  return 'success';
});

const form = useForm<FormType>({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});
</script>

<template>
  <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Create an account</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Or
        {{ ' ' }}
        <Link href="/auth/login" class="font-medium text-indigo-600 hover:text-indigo-500"
          >login to your existing account
        </Link>
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form class="space-y-6" @submit.prevent="form.post('')">
          <XAlert v-if="form.hasErrors" type="error">
            <p v-for="error in form.errors">{{ error }}</p>
          </XAlert>
          <XAlert v-if="form.recentlySuccessful" type="success">{{ errors?.message }}</XAlert>

          <div>
            <label class="block text-sm font-medium text-gray-700">Full Name</label>
            <div class="mt-1">
              <input
                v-model="form.name"
                type="text"
                required
                autocomplete="name"
                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
              />
            </div>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <div class="mt-1">
              <input
                v-model="form.email"
                name="email"
                type="text"
                required
                autocomplete="no"
                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
              />
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1">
              <input
                v-model="form.password"
                name="password"
                type="password"
                autocomplete="no"
                required
                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
              />
            </div>
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700"
              >Password Confirmation</label
            >
            <div class="mt-1">
              <input
                v-model="form.password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="no"
                required
                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
              />
            </div>
          </div>

          <div>
            <XButton
              :loading="form.processing"
              :disabled="form.processing"
              type="submit"
              block
              color="primary"
              label="Sign Up"
              class="text-center"
            />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
