<template>
  <Modal :open="open" :title="title" @ok="$emit('ok')" @cancel="$emit('cancel')">
    <div>
      <p class="text-gray-500">After deleting, you will not be able to recover it.</p>
    </div>
    <template #footer>
      <div class="px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6">
        <SButton :loading="loading" color="danger" label="Confirm" class="ml-2" @click="deleteData" />
        <SButton color="secondary" label="Cancel" class="ml-2" @click="$emit('cancel')" />
      </div>
    </template>
  </Modal>
</template>

<script setup lang="ts">
import Modal from './XModal.vue';
import SButton from './XButton.vue';
import { inject, ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = withDefaults(
  defineProps<{
    open: boolean;
    title?: string;
    url: string;
  }>(),
  { title: 'Are you sure want to delete?' }
);

const emit = defineEmits<{
  (event: 'ok'): void;
  (event: 'cancel'): void;
}>();

const notify = inject<Record<string, any>>('notification', {});
const loading = ref(false);

const deleteData = () => {
  router.delete(props.url, {
    onStart: () => (loading.value = true),
    onSuccess: (res) => {
      console.log(res);
      notify.success('Data deleted successfully.');
      emit('ok');
    },
    onError: (err) => {
      console.log(err);
      notify.error(err.message);
    },
    onFinish: () => (loading.value = false),
  });
};
</script>
