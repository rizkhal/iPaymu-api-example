import { createApp, h } from "vue";
import { createPinia } from "pinia";
import { InertiaProgress } from "@inertiajs/progress";
import { createInertiaApp } from "@inertiajs/inertia-vue3";

import modal from "~/plugins/modal";
import components from "~/components";
import defaultLayout from "~/layouts/default";

InertiaProgress.init();

createInertiaApp({
  resolve: async (name) => {
    const page = await import(`./pages/${name}.vue`);

    if (page.default.layout === undefined && !["welcome"].includes(name)) {
      page.default.layout = defaultLayout;
    }

    return await page;
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });

    app.use(plugin);

    app.use(components);

    app.use(modal);

    app.use(createPinia());

    app.config.globalProperties.$route = route;

    app.mixin({ methods: { route: window.route } });

    app.mount(el);

    return app;
  },
});
