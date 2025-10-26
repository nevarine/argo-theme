import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
    ],
    build: {
        outDir: 'dist', // Výstupní adresář pro sestavené soubory
        emptyOutDir: true,
        manifest: true, // Generování manifest.json pro snazší načítání v PHP
        rollupOptions: {
            input: {
                main: './src/main.js', // Hlavní vstupní soubor JavaScriptu
            },
        },
    },
    server: {
        // Nastavení pro Hot Module Replacement (HMR)
        hmr: {
            host: 'localhost',
        },
    },
});