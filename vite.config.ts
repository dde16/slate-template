import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "path";

import commonjs from "@rollup/plugin-commonjs";
import resolve from "@rollup/plugin-node-resolve" ;
import typescript from '@rollup/plugin-typescript';
// import builtins from "@rollup/plugin-node-builtins";
// import globals from "@rollup/plugin-node-globals";

export default defineConfig({
    root: path.resolve(__dirname, "public"),
    publicDir: "public",
    base: "/dist",
    build: {
        manifest: true,
        minify: false,
        sourcemap: true,
        target: "es2015",
        rollupOptions: {
            input: "vue/App.ts",
            output: {
                manualChunks: undefined,
				inlineDynamicImports: true
                // dir: "public/dist",
                // file: path.resolve(__dirname, "public/dist/bundle.js"),
                // format: "umd"
            },
            plugins: [
                resolve(),
                commonjs({
                    exclude: ["node_modules/**"]
                }),
                typescript({
                    "moduleResolution": "node",
                    "strict": true,
                    "jsx": "preserve",
                    "sourceMap": true,
                    "resolveJsonModule": true,
                    "esModuleInterop": true,
                    "lib": ["esnext", "dom"],
                    "typeRoots": [
                        "./type"
                    ],
                    include: [
                        "src/**/*.ts",
                        "src/**/*.d.ts",
                        "src/**/*.tsx",
                        "src/**/*.vue"
                    ],
                    exclude: [
                        "node_modules"
                    ]
                })
                // builtins(),
                // globals()
            ]
        }
    },
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "vue"),
            "~": path.resolve(__dirname)
        }
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `
                    @import "vue/style/variables.scss";
                    @import "vue/style/functions.scss";
                `
            }
        }
    },
    plugins: [vue()]
});
