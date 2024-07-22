<template>
  <XCard>
    <template #header>Change Password</template>

    <form @submit.prevent="form.post('')">
      <XInput
        v-model="form.current_password"
        type="password"
        label="Current Password"
        :errors="form.errors?.current_password"
      />
      <XInput v-model="form.new_password" type="password" label="New Password" :errors="form.errors?.new_password" />
      <XInput
        v-model="form.new_password_confirmation"
        type="password"
        label="New Password Confirmation"
        :errors="form.errors?.new_password_confirmation"
      />
      <XButton
        type="submit"
        label="Update Password"
        color="primary"
        class="mt-2"
        :loading="form.processing"
        :disabled="form.processing"
      />
    </form>
  </XCard>
</template>
<script setup lang="ts">
import XCard from '../../../components/XCard.vue';
import XInput from '../../../components/XInput.vue';
import XButton from '../../../components/XButton.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  current_password: '',
  new_password: '',
  new_password_confirmation: '',
});
</script>
