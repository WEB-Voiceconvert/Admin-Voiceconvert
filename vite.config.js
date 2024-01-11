import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/assets/admin/css/soft-ui-dashboard.css",
                "resources/assets/admin/js/core/popper.min.js",
                "resources/assets/admin/js/core/bootstrap.min.js",
                "resources/assets/admin/js/plugins/perfect-scrollbar.min.js",
                "resources/assets/admin/js/plugins/smooth-scrollbar.min.js",
                "resources/assets/admin/js/plugins/chartjs.min.js",
                "resources/assets/admin/js/soft-ui-dashboard.min.js",
                // "resources/assets/**",
            ],
            refresh: [
                "resources/routes/**",
                "routes/**",
                "resources/views/**",
                "resources/assets/admin/css/**",
            ],
        }),
    ],
});
