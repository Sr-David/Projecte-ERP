import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        extensions: ['.js', '.jsx'],
    },
    build: {
        // Generar archivos de origen para facilitar la depuración
        sourcemap: true,
        // Asegurar que los assets se generen correctamente
        manifest: true,
        // Especificar el directorio de salida
        outDir: 'public/build',
        // No limpiar el directorio de salida
        emptyOutDir: false,
        // Configuración de rollup
        rollupOptions: {
            output: {
                // Utilizar un patrón de nombre fijo para evitar hashes de contenido
                entryFileNames: 'assets/app.js',
                chunkFileNames: 'assets/[name].js',
                assetFileNames: 'assets/[name].[ext]'
            }
        },
        // Reportar errores de manera más detallada
        reportCompressedSize: true,
        // Configuración mínima para asegurar la compatibilidad
        target: 'es2015',
    },
});
