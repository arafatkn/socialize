<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <DataTable
    v-if="loading || (data && data.length > 0)"
    :loading="loading"
    :title="title"
    :data="data"
    :columns="columns"
    :actions="rowActions"
    :addable="addable"
    @addClick="addItem"
  />

  <div v-else class="my-10 block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center">
    <svg
      class="mx-auto h-12 w-12 text-gray-400"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      aria-hidden="true"
    >
      <path
        vector-effect="non-scaling-stroke"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"
      />
    </svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900">No data found</h3>
    <p class="mt-1 text-sm text-gray-500">Get started by creating a new one.</p>
    <div class="mt-6">
      <button
        v-if="addable"
        @click="addItem"
        class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
      >
        <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
        Add New
      </button>
    </div>
  </div>

  <XModal
    :open="!!saveModal"
    :title="saveModal === 'edit' ? 'Edit' : saveModal === 'add' ? 'Add' : '&nbsp;'"
    :loading="saving"
    @ok="saveItem"
    @close="closeModal"
  >
    <slot name="save" :item="currentItem"></slot>
  </XModal>

  <!--  <Modal :open="saveModal === 'add'" title="Edit" :loading="loading" @ok="saveItem" @cancel=" saveModal = '' ">
    <slot name="add" :item="currentItem"></slot>
  </Modal>

  <Modal :open="saveModal === 'edit'" title="Edit" :loading="loading" @ok="saveItem" @cancel=" saveModal = '' ">
    <slot name="edit" :item="currentItem"></slot>
  </Modal>-->

  <GDModal
    :open="deleteModal"
    :url="`${$page.url}/${currentItem.id}`"
    title="Are you sure want to delete?"
    :loading="loading"
    @ok="deleteModal = false"
    @cancel="deleteModal = false"
  />
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import DataTable from './DataTable.vue';
import XModal from './XModal.vue';
import GDModal from './GDModal.vue';
import { PencilSquareIcon, TrashIcon, PlusIcon } from '@heroicons/vue/20/solid';
import type { AnyObject } from '@/types';
import type { DataTableColumnType, DataTableActionType } from '@/types/data-table';

const $page = usePage();

let saveModal = ref('');
const deleteModal = ref(false);
const loading = ref(false);
const saving = ref(false);
const currentItem = ref<AnyObject>({});

type Props = {
  url?: string;
  title: string;
  subtitle?: string;
  data?: Array<AnyObject>;
  meta?: { [key: string]: any };
  columns: Array<DataTableColumnType>;
  actions?: Array<DataTableActionType>;
  addable?: boolean;
  editable?: boolean;
  deletable?: boolean;
};

const props = withDefaults(defineProps<Props>(), {
  addable: true,
});

const rowActions = ref(props.actions ?? []);

if (props.editable) {
  rowActions.value.push({
    title: 'Edit',
    icon: PencilSquareIcon,
    color: 'primary',
    onClick: (row) => {
      currentItem.value = { ...row };
      saveModal.value = 'edit';
    },
  } as DataTableActionType);
}

if (props.deletable) {
  rowActions.value.push({
    title: 'Delete',
    icon: TrashIcon,
    color: 'danger',
    onClick: (row) => {
      currentItem.value = row;
      deleteModal.value = true;
    },
  } as DataTableActionType);
}

function addItem() {
  currentItem.value = {};
  saveModal.value = 'add';
}

function closeModal() {
  saveModal.value = '';
}

function saveItem() {
  let url = props.url ?? $page.url;
  let data = { ...currentItem.value };

  if (saveModal.value === 'edit') {
    url += `/${currentItem.value.id}`;
    data._method = 'PATCH';
  }

  router.post(url, data, {
    onStart: () => (saving.value = true),
    onSuccess: () => {
      closeModal();
    },
    onFinish: () => (saving.value = false),
  });
}
</script>
