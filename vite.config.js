import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/css/style.css", // ← 追加
                "resources/js/translate.js",
                // "resources/js/profile.js",
            ],
            refresh: true,
        }),
    ],
});
