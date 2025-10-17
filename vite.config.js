import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue2'
import laravel from 'laravel-vite-plugin'
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'], // <- entry point
            refresh: true,                  // enables hot reload in dev
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
})
