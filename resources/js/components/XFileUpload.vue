<template>
  <div class="w-full py-1.5">
    <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
    <input
      name="file-upload"
      type="file"
      ref="uploader"
      @change="$emit('update:modelValue', multiple ? $event.target.files : $event.target.files[0])"
      :multiple="multiple"
      :accept="accept"
      class="sr-only"
    />
    <div v-if="modelValue" class="mt-2">
      <img :src="isString(modelValue) ? modelValue : getDataURL(modelValue)" class="h-20 mb-2" alt="" />
      <div class="text-xs flex items-center">
        <span v-if="!isString(modelValue)">{{ modelValue.name }} ({{ (modelValue.size / 1024).toFixed(2) }} KB)</span>
        <XButton
          @click="$emit('update:modelValue', null)"
          class="ml-2"
          type="button"
          variant="danger"
          size="small"
          :icon="TrashIcon"
        />
      </div>
    </div>
    <div
      v-else
      @click="uploader.click()"
      class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-6 cursor-pointer"
    >
      <div class="text-center">
        <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" />
        <div class="mt-4 flex text-sm leading-6 text-gray-600">
          <label
            class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500"
          >
            <span>Upload a file</span>
          </label>
          <p class="pl-1">or drag and drop</p>
        </div>
        <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 2MB</p>
      </div>
    </div>
    <p v-if="hasErrors" class="mt-2 text-sm text-red-600">
      {{ Array.isArray(props.errors) ? props.errors.join(' ') : errors }}
    </p>
  </div>
</template>

<script setup lang="ts">
import { PhotoIcon, TrashIcon } from '@heroicons/vue/20/solid';
import { computed, ref } from 'vue';
import XButton from './XButton.vue';
import { isString } from 'lodash';

type Props = {
  id?: string;
  type?: string;
  modelValue: any;
  label?: string;
  placeholder?: string;
  errors?: string[] | string;
  multiple?: boolean;
  accept?: string;
};

const props = withDefaults(defineProps<Props>(), {});

defineEmits(['update:modelValue']);

const uploader = ref<HTMLInputElement | null>(null);

function getDataURL(file: File) {
  return window.URL.createObjectURL(file);
}

const normalClasses = '';
const errorClasses = '';

const hasErrors = computed(() => {
  if (Array.isArray(props.errors) && props.errors.length) {
    return true;
  }

  return !!props.errors;
});
</script>
