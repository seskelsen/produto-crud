import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue'; // Importando o plugin Vue.js

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue(), // Adicionando o plugin Vue.js
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js', // Garantir que a versão correta do Vue seja usada
        },
    },
});
