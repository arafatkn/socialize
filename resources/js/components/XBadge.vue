<template>
  <span :class="`inline-flex items-center rounded-full font-medium ${sizes[size] ?? ''} ${colors[color] ?? ''}`">
    {{ text }}
    <slot />
  </span>
</template>

<script setup lang="ts">
type Props = {
  color?: 'primary' | 'secondary' | 'success' | 'info' | 'warning' | 'danger';
  text?: string;
  size?: 'small' | 'medium' | 'normal' | 'large';
};

withDefaults(defineProps<Props>(), { color: 'info', size: 'normal' });

const colors = {
  primary: 'bg-indigo-600 text-indigo-800',
  secondary: 'bg-gray-600 text-gray-800',
  info: 'bg-pink-600 text-pink-800',
  success: 'bg-green-600 text-white',
  warning: 'bg-lime-600 text-lime-800',
  danger: 'bg-red-600 text-red-800',
};

const sizes = {
  small: 'px-2 py-0.5 text-xs',
  medium: 'px-2.5 py-0.5 text-xs',
  normal: 'px-3 py-0.5 text-sm',
  large: 'px-3.5 py-1 text-medium',
};
</script>
