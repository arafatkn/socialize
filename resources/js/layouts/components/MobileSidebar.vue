<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-40 md:hidden" @close="$emit('close')">
      <TransitionChild
        as="template"
        enter="transition-opacity ease-linear duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="transition-opacity ease-linear duration-300"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" />
      </TransitionChild>

      <div class="fixed inset-0 z-40 flex">
        <TransitionChild
          as="template"
          enter="transition ease-in-out duration-300 transform"
          enter-from="-translate-x-full"
          enter-to="translate-x-0"
          leave="transition ease-in-out duration-300 transform"
          leave-from="translate-x-0"
          leave-to="-translate-x-full"
        >
          <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-white pt-5 pb-4">
            <TransitionChild
              as="template"
              enter="ease-in-out duration-300"
              enter-from="opacity-0"
              enter-to="opacity-100"
              leave="ease-in-out duration-300"
              leave-from="opacity-100"
              leave-to="opacity-0"
            >
              <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button
                  type="button"
                  class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                  @click="$emit('close')"
                >
                  <span class="sr-only">Close sidebar</span>
                  <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                </button>
              </div>
            </TransitionChild>
            <div class="flex flex-shrink-0 items-center px-4">
              <a href="/"><img class="h-8 w-auto" src="../../../../public/images/logo-nobg.png" alt="logo" /></a>
            </div>
            <div class="mt-5 h-0 flex-1 overflow-y-auto">
              <nav class="space-y-1 px-2">
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
                          selectedMenu.startsWith(String(i1))
                            ? 'text-gray-500'
                            : 'text-gray-400 group-hover:text-gray-500',
                          'mr-3 flex-shrink-0 h-6 w-6',
                        ]"
                        aria-hidden="true"
                      />
                      {{ item.name }}
                    </Link>
                  </div>
                  <Disclosure as="div" v-else class="space-y-1" v-slot="{ open }">
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
                          open ? 'text-gray-400 rotate-90' : 'text-gray-300',
                          'ml-3 h-5 w-5 flex-shrink-0 transform transition-colors duration-150 ease-in-out group-hover:text-gray-400',
                        ]"
                        viewBox="0 0 20 20"
                        aria-hidden="true"
                      >
                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
                      </svg>
                    </DisclosureButton>
                    <DisclosurePanel class="space-y-1">
                      <DisclosureButton
                        v-for="(subItem, i2) in item.children"
                        :key="subItem.name"
                        as="button"
                        @click="navigateTo(subItem.href, [i1, i2])"
                        :class="`group flex w-full items-center rounded-md py-2 pl-11 pr-2 text-sm font-medium ${
                          selectedMenu.startsWith(String(i1)) ? 'bg-gray-50' : ''
                        } text-gray-600 hover:bg-gray-50 hover:text-gray-900`"
                        >{{ subItem.name }}</DisclosureButton
                      >
                    </DisclosurePanel>
                  </Disclosure>
                </template>
              </nav>
            </div>
          </DialogPanel>
        </TransitionChild>
        <div class="w-14 flex-shrink-0" aria-hidden="true">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
<script setup lang="ts">
import {
  Dialog,
  DialogPanel,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue';
import { Link, router } from '@inertiajs/vue3';
import type { MenuItem } from '@/types/menu';
import { XMarkIcon } from '@heroicons/vue/24/outline';

defineProps<{ open: boolean; menuItems: MenuItem[]; selectedMenu: string }>();

const emit = defineEmits(['click', 'close']);

const navigateTo = (url: string, idx: number[]) => {
  router.visit(url);
  emit('click', idx);
};
</script>
