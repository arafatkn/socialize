import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import UserLayout from './layouts/UserLayout.vue';
import AuthLayout from './layouts/AuthLayout.vue';
import DefaultLayout from './layouts/DefaultLayout.vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Socialize';

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    let page: any = pages[`./Pages/${name}.vue`];

    if (!page.default.layout) {
      if (name.startsWith('Auth/')) {
        page.default.layout = AuthLayout;
      } else if (name.startsWith('User/')) {
        page.default.layout = UserLayout;
      } else {
        page.default.layout = DefaultLayout;
      }
    }

    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
