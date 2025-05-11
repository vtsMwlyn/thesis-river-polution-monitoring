import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: true, // This makes the server listen on all IPs (0.0.0.0)
        port: 5173,
        strictPort: true,
        hmr: {
            host: '192.168.1.5', // Your IP address
            port: 5173
        },
        cors: {
            origin: '*', // Allow all origins
            methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            allowedHeaders: ['*'],
        },
    }
});
