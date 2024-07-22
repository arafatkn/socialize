<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-10" @close="$emit('close')">
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all xs:my-4 xs:w-full xs:max-w-lg sm:my-8 sm:w-full sm:max-w-lg"
            >
              <slot name="header">
                <div class="bg-gray-50 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b">
                  <div class="sm:flex sm:items-start">
                    <div class="text-center sm:text-left">
                      <DialogTitle v-if="title" as="h3" class="text-lg font-medium leading-6 text-gray-900">{{
                        title
                      }}</DialogTitle>
                    </div>
                  </div>
                </div>
              </slot>
              <div class="bg-white p-4 sm:p-5 sm:pb-4">
                <slot />
              </div>
              <slot name="footer">
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                  <XButton :loading="loading" color="primary" label="Submit" class="ml-2" @click="$emit('ok')" />
                  <XButton color="secondary" label="Cancel" class="ml-2" @click="$emit('close')" />
                </div>
              </slot>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup lang="ts">
import XButton from './XButton.vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';

type Props = {
  open: boolean;
  title?: string;
  loading?: boolean;
};

withDefaults(defineProps<Props>(), { loading: false });

type Emits = {
  (event: 'ok'): void;
  (event: 'close'): void;
};

defineEmits<Emits>();
</script>
