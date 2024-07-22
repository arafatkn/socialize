<template>
  <XCard>
    <template #header>Profile</template>

    <form @submit.prevent="form.post('')">
      <XInput v-model="form.name" label="Name" :errors="form.errors.name" />
      <XInput v-model="form.email" label="Email" :errors="form.errors.email" />
      <XButton
        type="submit"
        label="Update Profile"
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

const props = defineProps<{ user: { name: string; email: string } }>();

const form = useForm({
  name: props.user.name,
  email: props.user.email,
});
</script>
