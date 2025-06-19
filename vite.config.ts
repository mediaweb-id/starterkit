import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from "@tailwindcss/vite";
import { resolve } from 'node:path';
import { defineConfig,searchForWorkspaceRoot } from 'vite'
import fs from 'fs';;

const acitjazzVendorPath = path.resolve(__dirname, 'vendor/acitjazz');

// Cari semua `vendor/acitjazz/*/resources/js/index.js` (atau file utama lain)
const vendorJS = fs
    .readdirSync(acitjazzVendorPath, { withFileTypes: true })
    .filter(dirent => dirent.isDirectory())
    .map(dirent =>
        path.resolve(acitjazzVendorPath, dirent.name, 'resources/js/index.js')
    )
    .filter(fs.existsSync); // hanya yang ada index.js-nya

export default defineConfig({
    plugins: [
        laravel({
            input:['resources/js/app.ts','resources/js/admin.ts',...vendorJS],
            ssr: ['resources/js/ssr.ts','resources/js/admin-ssr.ts'],
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            '@themes': path.resolve(__dirname, './resources/css/themes'),
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
            '@vendor': resolve(__dirname, 'vendor'),

            ...Object.fromEntries(
                fs.readdirSync(acitjazzVendorPath, { withFileTypes: true })
                    .filter(d => d.isDirectory())
                    .map(d => [
                        `@${d.name}`,
                        path.resolve(acitjazzVendorPath, d.name, 'resources/js'),
                    ])
            ),
        },
    },
    server: {
        fs: {
            allow: [
                searchForWorkspaceRoot(process.cwd()),
                ...fs
                    .readdirSync(acitjazzVendorPath, { withFileTypes: true })
                    .filter(d => d.isDirectory())
                    .map(d =>
                        path.resolve(acitjazzVendorPath, d.name, 'resources/js')
                    ),
            ],
        },
    },
});
