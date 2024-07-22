<script setup lang="ts">
import { onBeforeMount, ref, watch } from 'vue';
import { ArrowRightOnRectangleIcon, UserIcon, HomeIcon } from '@heroicons/vue/24/outline';
import { usePage } from '@inertiajs/vue3';
import type { InertiaProps } from '@/types';
import type { MenuItem } from '@/types/menu';
import XNotification from '../components/XNotification.vue';
import DesktopSidebar from './components/DesktopSidebar.vue';
import MobileSidebar from './components/MobileSidebar.vue';
import UserHeader from './components/UserHeader.vue';

const $page = usePage();
const props = defineProps<InertiaProps>();
const notification = ref<any>(null);

const menuItems: MenuItem[] = [
  { name: 'Dashboard', href: '/user/dashboard', icon: HomeIcon },
  // {
  //   name: 'Sites',
  //   href: '/user/sites',
  //   icon: GlobeAltIcon,
  // },
  {
    name: 'My Account',
    href: '#',
    icon: UserIcon,
    children: [
      { name: 'Edit Profile', href: '/user/settings/profile' },
      { name: 'Change Password', href: '/user/settings/password' },
    ],
  },
  { name: 'Logout', href: '/auth/logout', icon: ArrowRightOnRectangleIcon },
];

const sidebarOpen = ref(false);
const selectedMenu = ref('0');

const updateCurrentMenu = (_: number[]) => {
  // const [first, second] = idx;
  /*if (!isNaN(first) && navigation.value[first]) {
    navigation.value[first].current = true;

    if (!isNaN(second) && navigation.value[first].children[second]) {
      navigation.value[first].children[second].current = true;
    }
  }*/
  /*for (const x in navigation.value) {
    if (navigation.value[x].children?.length) {
      for (const y of navigation.value[x].children) {
        if (y.href === url) {
          //navigation[x].children[y]?.current = true;
          navigation.value[x].current = true;
          console.log(y.href);
        }
      }
    }
  }*/
};

onBeforeMount(() => {
  selectedMenu.value = menuItems.findIndex((item) => item.href === $page.url).toString();
});

watch(
  () => props.flash,
  (val) => {
    if (val.message) {
      notification.value.addNotification('info', val.message);
    }
    if (val.error) {
      notification.value.addNotification('error', val.error);
    }
    if (val.success) {
      notification.value.addNotification('success', val.success);
    }
  }
);
</script>

<template>
  <div>
    <MobileSidebar
      :open="sidebarOpen"
      :selected-menu="selectedMenu"
      :menu-items="menuItems"
      @click="
        (args: number[]) => {
          selectedMenu = args.join('_');
          sidebarOpen = false;
        }
      "
      @close="sidebarOpen = false"
    />

    <!-- Static sidebar for desktop -->
    <DesktopSidebar
      :menu-items="menuItems"
      :selected-menu="selectedMenu"
      @click="(args: number[]) => (selectedMenu = args.join('_'))"
    />

    <div class="flex flex-1 flex-col md:pl-64">
      <UserHeader @sidebar="sidebarOpen = true" />

      <main class="flex-1">
        <div class="py-6">
          <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
            <XNotification ref="notification" />
            <slot />
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
