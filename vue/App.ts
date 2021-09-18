import { createWebHistory, createRouter } from "vue-router";

import { h, createApp } from "vue";

import App from "@/App.vue";

window.onload = async function () {
    const app = createApp({
        render: () => h(App)
    });

    app.use(createRouter({
        history: createWebHistory(),
        routes: [
            {
                path: "/home",
                component: (await import("@/page/Home.vue")).default
            },
            {
                path: "/:catchAll(.*)",
                component: (await import("@/page/404.vue")).default
            }
        ]
    }));


    app.component("v-extern", (await import("@/component/Extern.vue")).default);


    app.mount("#app");
};


