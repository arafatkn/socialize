<template>
  <Head title="Reset Password" />

  <div class="flex min-h-full flex-1 flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <a href="/">
        <img class="mx-auto h-24 w-auto" src="../../../../public/images/logo-nobg.png" alt="AmarDetails" />
      </a>
      <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Reset Password</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
      <div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
        <div class="mb-6" v-if="Object.values(flash).filter((v) => v).length">
          <XAlert type="warning" v-if="!!flash?.message">{{ flash?.message }}</XAlert>
          <XAlert type="error" v-if="!!flash?.error">{{ flash?.error }}</XAlert>
          <XAlert type="success" v-if="!!flash?.success">{{ flash?.success }}</XAlert>
        </div>

        <form @submit.prevent="submitForm" method="POST">
          <XInput v-model="form.email" label="Email address" required disabled />

          <XInput v-model="form.password" type="password" :errors="errors?.password" label="New Password" required />

          <XInput
            v-model="form.password_confirmation"
            type="password"
            :errors="errors?.password_confirmation"
            label="New Password Confirmation"
            required
          />

          <div class="mt-4">
            <XButton
              type="submit"
              :loading="form.processing"
              class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
              Reset Password
            </XButton>
          </div>
        </form>
      </div>

      <p class="mt-10 text-center text-sm text-gray-500">
        Don't have an account?
        {{ ' ' }}
        <Link href="/auth/register" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
          >Register Now</Link
        >
      </p>
    </div>
  </div>
</template>
<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import XInput from '@/components/XInput.vue';
import type { InertiaProps } from '@/types';
import XButton from '@/components/XButton.vue';
import XAlert from '@/components/XAlert.vue';

interface PageProps extends InertiaProps {
  email: string;
  token: string;
}

const props = defineProps<PageProps>();

const form = useForm({
  email: props.email,
  token: props.token,
  password: '',
  password_confirmation: '',
});

function submitForm() {
  form.post('/auth/reset-password');
}
</script>
