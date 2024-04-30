import { defineConfig } from "vite";
import { nodePolyfills } from "vite-plugin-node-polyfills";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        nodePolyfills(),
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/filament/app/theme.css",
            ],
            refresh: true,
        }),
    ],
});
