<script setup lang="ts">
import SocialAuth from '../../sections/SocialAuth.vue';
import { computed } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import XAlert from '../../components/XAlert.vue';
import XButton from '../../components/XButton.vue';
import type { InertiaProps } from '@/types';
import XInput from '@/components/XInput.vue';

const props = defineProps<InertiaProps>();

type FormType = {
  username: string;
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
  reference: string;
};

const msgType = computed(() => {
  if (props.errors?.message) {
    return 'error';
  }

  return 'success';
});

const form = useForm<FormType>({
  username: '',
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  reference: '',
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

          <XInput
            v-model="form.username"
            label="Username (max 32 characters)"
            :errors="form.errors?.username"
            required
          />

          <XInput v-model="form.name" label="Full Name" :errors="form.errors?.name" required />
          <XInput type="email" v-model="form.email" label="Email Address" :errors="form.errors?.email" required />
          <XInput type="password" v-model="form.password" label="Password" :errors="form.errors?.password" required />
          <XInput
            type="password"
            v-model="form.password_confirmation"
            label="Password Confirmation"
            :errors="form.errors?.password_confirmation"
            required
          />
          <XInput v-model="form.reference" label="Reference" :errors="form.errors?.reference" required />

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
