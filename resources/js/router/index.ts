import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/pages/HomeView.vue";
import { useAuthStore } from "@/stores";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "home",
            component: HomeView,
        },
        {
            path: "/login",
            name: "login",
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("@/pages/auth/LoginView.vue"),
            meta: {
                public: true,
            },
        },
        {
            path: "/forgot-password",
            name: "forgot-password",
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("@/pages/auth/ForgotPasswordView.vue"),
            meta: {
                public: true,
            },
        },
        {
            path: "/reset-password/:token",
            name: "reset-password",
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("@/pages/auth/ResetPasswordView.vue"),
            meta: {
                public: true,
            },
        },
        {
            path: "/register",
            name: "register",
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("@/pages/auth/RegisterView.vue"),
            meta: {
                public: true,
            },
        },
        {
            path: "/about",
            name: "about",
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("@/pages/AboutView.vue"),
        },
    ],
});

router.beforeEach(async (to) => {
    // clear alert on route change
    // const alertStore = useAlertStore();
    // alertStore.clear();

    // redirect to login page if not logged in and trying to access a restricted page
    const authRequired = to.meta && !to.meta.public;
    const authStore = useAuthStore();

    if (authRequired && !authStore.isAuthenticated) {
        authStore.returnUrl = to.fullPath;
        return { name: "login" };
    }
});

export default router;