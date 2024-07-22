<template>
  <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex flex-grow flex-col overflow-y-auto border-r border-gray-200 bg-white pt-5">
      <div class="flex flex-shrink-0 items-center px-4">
        <a href="/"><img class="h-8 w-auto" src="../../../../public/images/logo-nobg.png" alt="logo" /></a>
      </div>
      <div class="mt-5 flex flex-grow flex-col">
        <nav class="flex-1 space-y-1 px-2 pb-4">
          <template v-for="(item, i1) in menuItems" :key="item.name">
            <div v-if="!item.children">
              <Link
                @click="$emit('click', [i1])"
                :href="item.href"
                :class="[
                  selectedMenu.startsWith(String(i1))
                    ? 'bg-gray-100 text-gray-900'
                    : 'bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                  'group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md',
                ]"
              >
                <component
                  :is="item.icon"
                  :class="[
                    selectedMenu.startsWith(String(i1)) ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500',
                    'mr-3 flex-shrink-0 h-6 w-6',
                  ]"
                  aria-hidden="true"
                />
                {{ item.name }}
              </Link>
            </div>
            <Disclosure v-else as="div" class="space-y-1" v-slot="{ open }">
              <DisclosureButton
                :class="[
                  selectedMenu.startsWith(String(i1))
                    ? 'bg-gray-100 text-gray-900'
                    : 'bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                  'group w-full flex items-center pl-2 pr-1 py-2 text-left text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500',
                ]"
              >
                <component
                  :is="item.icon"
                  class="mr-3 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                  aria-hidden="true"
                />
                <span class="flex-1">{{ item.name }}</span>
                <svg
                  :class="[
                    open || selectedMenu.startsWith(String(i1)) ? 'text-gray-400 rotate-90' : 'text-gray-300',
                    'ml-3 h-5 w-5 flex-shrink-0 transform transition-colors duration-150 ease-in-out group-hover:text-gray-400',
                  ]"
                  viewBox="0 0 20 20"
                  aria-hidden="true"
                >
                  <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
                </svg>
              </DisclosureButton>
              <DisclosurePanel static v-show="open || selectedMenu.startsWith(String(i1))" class="space-y-1">
                <DisclosureButton
                  v-for="(subItem, i2) in item.children"
                  :key="subItem.name"
                  as="button"
                  @click="navigateTo(subItem.href, [i1, i2])"
                  :class="`group flex w-full items-center rounded-md py-2 pl-11 pr-2 text-sm font-medium ${
                    selectedMenu.startsWith([i1, i2].join('_')) ? 'bg-gray-50' : ''
                  } text-gray-600 hover:bg-gray-50 hover:text-gray-900`"
                  >{{ subItem.name }}</DisclosureButton
                >
              </DisclosurePanel>
            </Disclosure>
          </template>
        </nav>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
import { Link, router } from '@inertiajs/vue3';
import type { MenuItem } from '@/types/menu';

defineProps<{ menuItems: MenuItem[]; selectedMenu: string }>();

const emit = defineEmits(['click']);

const navigateTo = (url: string, idx: number[]) => {
  router.visit(url);
  emit('click', idx);
};
</script>
