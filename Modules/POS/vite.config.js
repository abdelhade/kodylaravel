import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'Modules/POS/resources/assets/css/pos.css',
                'Modules/POS/resources/assets/js/pos.js',
            ],
            refresh: true,
        }),
    ],
});
