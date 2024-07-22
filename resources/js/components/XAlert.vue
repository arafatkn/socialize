<template>
  <div :class="['border-l-4 p-4', colors[type]]">
    <div class="flex">
      <div class="flex-shrink-0">
        <CheckCircleIcon v-if="type === 'success'" class="h-5 w-5 text-green-400" aria-hidden="true" />
        <XCircleIcon v-if="type === 'error'" class="h-5 w-5 text-red-400" aria-hidden="true" />
        <ExclamationTriangleIcon v-if="type === 'warning'" class="h-5 w-5 text-yellow-400" aria-hidden="true" />
        <InformationCircleIcon v-if="type === 'info'" class="h-5 w-5 text-blue-400" aria-hidden="true" />
      </div>
      <div class="ml-3">
        <p class="text-sm">
          <slot></slot>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { CheckCircleIcon, XCircleIcon, ExclamationTriangleIcon, InformationCircleIcon } from '@heroicons/vue/24/outline';

type Props = {
  type: 'success' | 'error' | 'warning' | 'info',
};

defineProps<Props>();

const colors = {
  success: 'border-green-400 bg-green-50 text-green-700',
  error: 'border-red-400 bg-red-50 text-red-700',
  warning: 'border-yellow-400 bg-yellow-50 text-yellow-700',
  info: 'border-blue-400 bg-blue-50 text-blue-700',
};
</script>
