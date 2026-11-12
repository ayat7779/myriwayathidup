import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const appName = import.meta.env.VITE_APP_NAME || 'Riwayat Hidup Digital ASN';

let initialPage = null;
try {
    const el = document.getElementById('app');
    if (el && el.dataset && el.dataset.page) {
        initialPage = JSON.parse(el.dataset.page);
    }
} catch (e) {
    initialPage = null;
}

if (!initialPage || !initialPage.component) {
    initialPage = {
        component: 'Welcome',
        props: { errors: {}, auth: { user: null }, flash: { message: null, success: null, error: null } },
        url: window.location.pathname || '/',
        version: '',
    };
}

createInertiaApp({
    page: initialPage,
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) });
        if (typeof window.route === 'function') {
            vueApp.config.globalProperties.route = window.route;
        }
        return vueApp
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#4f46e5',
    },
});
