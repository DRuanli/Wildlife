import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        react(),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '~': '/resources/sass',
        },
    },
    optimizeDeps: {
        include: [
            'three',
            '@react-three/fiber',
            '@react-three/drei',
            'lodash',
            'chart.js',
        ],
    },
    build: {
        chunkSizeWarningLimit: 1600,
        rollupOptions: {
            output: {
                manualChunks: {
                    three: ['three'],
                    react: ['react', 'react-dom', 'react-router-dom'],
                    vue: ['vue', 'vue-router', 'vuex'],
                    ar: ['ar.js'],
                    tensorflow: ['tensorflow-tfjs'],
                }
            }
        }
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});