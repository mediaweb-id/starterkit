import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { renderToString } from '@vue/server-renderer';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import globalComponent from "@/globalComponent";
import sectionComponent from "@/sectionComponent";
import vendorComponent from "@/vendorComponent";
import { createSSRApp, h } from 'vue';
import { route as ziggyRoute } from 'ziggy-js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// 1. Gabungkan semua komponen sekali saja
const pages = {
    ...import.meta.glob('./frontend/**/*.vue'),
    ...import.meta.glob('../../vendor/acitjazz/*/resources/js/**/*.vue'),
};

// 2. Helper untuk mencari & meng‑import halaman
function resolvePage(name: string) {
    // Key mana pun yang berakhir dengan `/name.vue`
    const importer = Object.entries(pages).find(([key]) =>
        key.endsWith(`/${name}.vue`)
    )?.[1];

    if (!importer) {
        throw new Error(`Page not found: ${name}`);
    }

    // ⬇️  KEMBALIKAN Promise yang menghasilkan objek komponen
    return importer().then(mod => mod.default);
}


createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - ${appName}`,
        resolve: name => {
            console.log('Minta halaman:', name);
            return resolvePage(name);
        },
        setup({ App, props, plugin }) {
            const app = createSSRApp({ render: () => h(App, props) });

            // Configure Ziggy for SSR...
            const ziggyConfig = {
                ...page.props.ziggy,
                location: new URL(page.props.ziggy.location),
            };

            // Create route function...
            const route = (name: string, params?: any, absolute?: boolean) => ziggyRoute(name, params, absolute, ziggyConfig);

            // Make route function available globally...
            app.config.globalProperties.route = route;

            // Make route function available globally for SSR...
            if (typeof window === 'undefined') {
                global.route = route;
            }

            app.use(globalComponent)
                        .use(sectionComponent)
                        .use(vendorComponent)
                        .use(plugin);
            return app;
        },
    }),
);
