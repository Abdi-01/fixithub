import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        // manifest: true,
        outDir: "public/build", // Output tetap di dalam public/build
        rollupOptions: {
            input: "resources/css/app.css",
        },
    },
});
