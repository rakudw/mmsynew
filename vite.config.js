import { defineConfig } from 'vite';
import inject from '@rollup/plugin-inject';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        inject({
            $: 'jquery',
            jQuery: 'jquery',
        }), laravel({
            input: [

                'resources/js/app.js',
                'resources/js/front-end.js',
                'resources/material/js/plugins/chartjs.min.js',

                'resources/scss/admin.scss',
                'resources/scss/app.scss',
                'resources/scss/fontawesome.scss',
                'resources/scss/stylesheet.scss',

                'resources/ts/admin.ts',
                'resources/ts/login.ts',
                'resources/ts/form.ts',
                'resources/ts/pendency.ts',
                'resources/ts/dashboard.ts',
                'resources/ts/view.ts',
                'resources/ts/exporter.ts',
            ], refresh: true,
        }),
    ]
});
