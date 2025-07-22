import { createWebHistory, createRouter } from "vue-router";
import Swal from "sweetalert2";

const guestRoutes = [
    {
        path: "/login",
        name: "Login",
        component: () => import("./../pages/Auth/Login.vue"),
    },
    
].map((route) => ({ ...route, meta: { requiresGuest: true } }));

const authRoutes = [
    {
        path: "/",
        name: "Dashboard",
        component: () => import("./../pages/Dashboard.vue"),
        meta: { requiresAuth: true, roles: ["admin", "developer"] },
    },
    {
        path: "/about",
        name: "About",
        component: () => import("./../pages/AboutView.vue"),
        meta: { requiresAuth: true, roles: ["admin", "developer"] },
    },
    {
        path: "/user/list",
        name: "user.index",
        component: () => import("../pages/user/index.vue"),
        meta: { requiresAuth: true, roles: ["admin"] },
    },
    {
        path: "/user/create",
        name: "user.create",
        component: () => import("../pages/user/create.vue"),
        meta: { requiresAuth: true, roles: ["admin"] },
    },
];

const fallbackRoute = {
    path: "/:pathMatch(.*)*",
    name: "NotFound",
    component: () => import("./../pages/partials/NotFound.vue"),
};

const routes = [...authRoutes, ...guestRoutes, fallbackRoute];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");
    const user = JSON.parse(localStorage.getItem("user"));
    console.log(user,token);
    
    if (to.meta.requiresAuth && !token) {
        return next("/login");
    }

    if (to.meta.requiresGuest && token) {
        return next("/");
    }
    if (to.meta.roles && user) {
        if (!to.meta.roles.includes(user.role)) {
            Swal.fire({
                icon: "error",
                title: "Access Denied",
                text: "You do not have permission to access this page.",
                timer: 3000,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
            });
            return next(false);
        }
    }
    next();
});

export default router;
