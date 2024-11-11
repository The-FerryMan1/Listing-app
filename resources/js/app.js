import './bootstrap';


import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import {ZiggyVue} from '../../vendor/tightenco/ziggy'
import Layout from './Layouts/Layout.vue';
import { themeLoad } from './darkmode';

createInertiaApp({
    title: (title) => `Listing | ${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el);
    },
    progress: {
        // The delay after which the progress bar will appear, in milliseconds...
       

        // The color of the progress bar...
        color: "pink",

        // Whether to include the default NProgress styles...
       

        // Whether the NProgress spinner will be shown...
        showSpinner: true,
    },
});

themeLoad()