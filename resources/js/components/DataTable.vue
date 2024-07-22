<template>
  <div class="">
    <div class="sm:flex sm:items-center">
      <div v-if="title || subtitle" class="sm:flex-auto">
        <h1 v-if="title" class="text-xl font-semibold text-gray-900">{{ title }}</h1>
        <p v-if="subtitle" class="mt-2 text-sm text-gray-700">{{ subtitle }}</p>
      </div>
      <div v-if="addable" class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <XButton label="Add New" color="primary" :icon="PlusIcon" @click="$emit('addClick')" />
      </div>
    </div>

    <div class="mt-8 flex flex-col">
      <div v-if="loading">
        <div
          role="status"
          class="p-4 space-y-4 max-w-full rounded border border-gray-200 divide-y divide-gray-200 shadow animate-pulse dark:divide-gray-700 md:p-6 dark:border-gray-700"
        >
          <div v-for="i in 5" :key="i" :class="`flex justify-between items-center ${i !== 1 ? 'pt-4' : ''}`">
            <div>
              <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-64 mb-2.5"></div>
              <div class="w-96 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            </div>
            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-16"></div>
          </div>
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <div v-else class="-my-2 overflow-x-auto">
        <div class="inline-block min-w-full py-2 align-middle">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg border-gray-200 border">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    v-for="column in props.columns"
                    :key="column.title"
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                  >
                    {{ column.title }}
                  </th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="(item, index) in props.data" :key="index">
                  <!--
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ person.name }}</td>
-->
                  <td
                    v-for="column in props.columns"
                    :key="column.title + index"
                    class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"
                  >
                    <Link v-if="column.link" :href="getColumnLink(item, column)" class="text-blue-600 font-semibold">{{
                      getColumnValue(item, column)
                    }}</Link>
                    <div v-else-if="typeof column.value === 'function'" v-html="getColumnValue(item, column)"></div>
                    <template v-else>{{ getColumnValue(item, column) }}</template>
                  </td>

                  <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <template v-for="action in props.actions" :key="action.title">
                      <Button
                        :icon="action.icon"
                        size="medium"
                        :color="action.color as any"
                        :label="action.title"
                        class="ml-2"
                        @click="runAction(action, item)"
                      />
                    </template>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { get } from 'lodash';
import { PlusIcon } from '@heroicons/vue/20/solid';
import Button from './XButton.vue';
import type { DataTableActionType, DataTableColumnType } from '@/types/data-table';
import XButton from './XButton.vue';
import type { AnyObject } from '@/types';

type Props = {
  loading?: boolean;
  title: string;
  subtitle?: string;
  columns: Array<DataTableColumnType>;
  data: Array<AnyObject>;
  meta?: { [key: string]: any };
  addable?: boolean;
  actions: Array<DataTableActionType>;
};

const props = withDefaults(defineProps<Props>(), { addable: true });

function getColumnValue(row: AnyObject, column: DataTableColumnType) {
  if (typeof column.value === 'function') {
    return column.value(row);
  } else {
    return get(row, column.value);
  }
}

function getColumnLink(row: AnyObject, column: DataTableColumnType) {
  if (typeof column.link === 'function') {
    return column.link(row);
  } else {
    return column.link;
  }
}

function runAction(action: DataTableActionType, row: AnyObject) {
  if (typeof action.onClick === 'function') {
    action.onClick(row);
  } else if (action.onClick) {
    // router.push(action.onClick);
  }
}
</script>
