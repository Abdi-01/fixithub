import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    base: "/assets/", // Semua file akan diakses melalui /assets/
    build: {
        outDir: "public/build", // Output tetap di dalam public/build
        rollupOptions: {
            output: {
                assetFileNames: "assets/[name]-[hash][extname]",
                entryFileNames: "assets/[name]-[hash].js",
            },
        },
    },
});
