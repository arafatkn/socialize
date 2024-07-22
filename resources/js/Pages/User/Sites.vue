<template>
  <div>
    <Head title="My Sites" />
    <CrudTable title="My Sites" :data="sites" :columns="columns" :actions="actions" deletable>
      <template #save="{ item }">
        <XInput v-model="item.subdomain" label="Subdomain" placeholder="e.g. arafat" :errors="errors?.subdomain" />
      </template>
    </CrudTable>

    <div v-if="false && sites?.length" class="md:grid-cols-2 lg:grid-cols-3 gap-6 grid mt-12">
      <div v-for="site in sites" :key="site.id">
        <div class="border rounded h-full overflow-hidden hover:shadow-xl transition-shadow duration-150">
          <div class="overflow-hidden max-h-52" style="min-height: 10rem; max-height: 13rem">
            <img src="https://fakeimg.pl/600x400?text=Coming+Soon" alt="Image" />
          </div>
          <div class="p-4">
            <h3 class="text-lg font-bold mb-2 text-gray-800">
              {{ site.subdomain }}
              <!--                  <Badge-->
              <!--                      color={get(statusToColor, market.status, 'primary')}-->
              <!--                  label={upperFirst(market.status)}-->
              <!--                  class="ml-2 font-semibold"-->
              <!--                  />-->
            </h3>
            <div class="mb-3">
              <a
                :href="site.subdomain_full"
                target="_blank"
                class="text-gray-600 text-sm hover:text-primary-400 transition-colors duration-200"
              >
                {{ site.subdomain_full }}
              </a>
            </div>

            <div class="flex gap-2">
              <template v-if="site.status !== 'pending'">
                <x-button label="Dashboard" size="small" color="primary" class="border border-primary-600" />
                <a :href="site.subdomain_full" target="_blank">
                  <x-button label="Live Site" size="small" color="primary" outlined />
                </a>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import CrudTable from '../../components/CrudTable.vue';
import XInput from '../../components/XInput.vue';
import type { DataTableActionType, DataTableColumnType } from '@/types/data-table';
import type { InertiaProps } from '@/types';
import { PencilIcon } from '@heroicons/vue/24/solid';
import { Head, router } from '@inertiajs/vue3';
import type { Site } from '@/types/site';
import XButton from '@/components/XButton.vue';

interface PageProps extends InertiaProps {
  sites: Site[];
}

defineProps<PageProps>();

const columns: DataTableColumnType[] = [
  {
    title: 'Site',
    value: ({ subdomain_full }: Site) =>
      `<a href="//${subdomain_full}" class="text-blue-600 font-semibold" target="_blank">${subdomain_full}</a>`,
  },
  {
    title: 'Status',
    value: 'status',
  },
];

const actions: DataTableActionType[] = [
  {
    title: 'Customize',
    icon: PencilIcon,
    color: 'blue',
    onClick: ({ subdomain }) => router.get(`/user/sites/${subdomain}/`),
  },
];
</script>
