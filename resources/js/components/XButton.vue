<template>
  <button
    type="button"
    :class="[
      `inline-flex items-center justify-center gap-2 ${
        sizes[size] ?? ''
      } border font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 ${colors[color] ?? ''} ${
        block ? 'w-full' : ''
      }`,
      rounded ? 'rounded-full' : '',
    ]"
  >
    <svg
      v-if="loading"
      class="animate-spin h-4 w-4 -ml-0.5 text-white mr-2"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
    >
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path
        class="opacity-75"
        fill="currentColor"
        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
      ></path>
    </svg>
    <component v-if="icon" :is="icon" class="-ml-0.5 h-4 w-4" aria-hidden="true" />
    <span v-if="label">{{ label }}</span>
    <slot />
    <component v-if="postIcon" :is="postIcon" class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
  </button>
</template>

<script setup lang="ts">
type Props = {
  color?: 'default' | 'primary' | 'secondary' | 'info' | 'warning' | 'danger';
  label?: string;
  loading?: boolean;
  icon?: any;
  postIcon?: any;
  size?: 'small' | 'medium' | 'normal' | 'large';
  block?: boolean;
  rounded?: boolean;
};

withDefaults(defineProps<Props>(), { color: 'default', size: 'normal', loading: false, block: false, rounded: false });

const colors = {
  default: '',
  primary: 'border-transparent bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
  secondary: 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:ring-indigo-500',
  info: 'border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
  success: 'border-transparent bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
  warning: 'border-transparent bg-lime-600 text-white hover:bg-lime-700 focus:ring-lime-500',
  danger: 'border-transparent bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
};

const sizes = {
  small: 'rounded px-2.5 py-1.5 text-xs',
  medium: 'rounded-md px-3 py-2 text-sm leading-4',
  normal: 'rounded-md px-4 py-2 text-sm',
  large: 'rounded-md px-4 py-2 text-base',
};
</script>
