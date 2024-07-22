<template>
  <div class="w-full py-1.5">
    <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
    <div class="relative mt-1 rounded-md shadow-sm">
      <textarea
        :id="id"
        :class="`block w-full rounded-md ${hasErrors ? errorClasses : normalClasses} focus:outline-none sm:text-sm`"
        :placeholder="placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target?.value)"
        :aria-invalid="hasErrors"
        :rows="rows"
      ></textarea>
      <div v-if="hasErrors" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
        <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
      </div>
    </div>
    <p v-if="hasErrors" class="mt-2 text-sm text-red-600">
      {{ Array.isArray(props.errors) ? props.errors.join(' ') : errors }}
    </p>
  </div>
</template>

<script setup lang="ts">
import { ExclamationCircleIcon } from '@heroicons/vue/20/solid';
import { computed } from 'vue';

type Props = {
  id?: string;
  modelValue: any;
  label?: string;
  placeholder?: string;
  addonLeft?: string;
  addonRight?: string;
  size?: 'small' | 'medium' | 'normal' | 'large';
  block?: boolean;
  errors?: string[] | string;
  rows?: number;
};

const props = withDefaults(defineProps<Props>(), { type: 'text', size: 'normal', block: false });

defineEmits(['update:modelValue']);

const normalClasses = 'border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500';
const errorClasses = 'border-red-300 pr-10 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500';

const hasErrors = computed(() => {
  if (Array.isArray(props.errors) && props.errors.length) {
    return true;
  }

  return !!props.errors;
});
</script>
