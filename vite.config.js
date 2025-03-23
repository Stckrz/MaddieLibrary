import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    base: '/',
    server: {
        host: '0.0.0.0',
        port: 8001,
        proxy: {
            '/api': {
                target: 'http://127.0.0.1:8000',
                changeOrigin: true,
            }
        },
        hmr: {
            // host: '127.0.0.1', // Change this value for your local network ip address(noodle)
            host: '192.168.0.108', // Change this value for your local network ip address(noodle)
            // host: '192.168.1.54', // Change this value for your local network ip address(home)
            port: 5173, // Or your app's standard port
        },
    },
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
        },
    },
});
