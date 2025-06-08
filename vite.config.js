import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
        })
    ],
    // server: {
    //     host: '0.0.0.0',
    //     port: 3000,
    //     cors: {
    //         // Permite que o origin http://192.168.68.104:8000 carregue os assets
    //         origin: ['http://192.168.68.104:8000'],
    //         // você pode adicionar mais configurações aqui, se quiser
    //     },
    //     hmr: {
    //         host: '192.168.68.104',
    //     },
    // },
});