import { createRouter, createWebHistory } from "vue-router";
import Home from "./components/Home.vue";
import Projects from "./components/project/Project.vue";
import Tasks from "./components/task/Task.vue";
import TaskDetail from "./components/task/TaskDetail.vue";
import ListUsers from "./components/auth/ListUsers.vue";
import Profile from "./components/auth/Profile.vue";
import DetailProoject from "./components/project/DetailProject.vue";

const routes = [
    { path: "/spa", component: Home },

    { path: "/spa/projects", component: Projects },
    { path: "/spa/projects/:id", component: DetailProoject },

    { path: "/spa/tasks", component: Tasks },
    { path: "/spa/tasks/:id", component: TaskDetail },

    { path: "/spa/users", component: ListUsers },
    { path: "/spa/users/profile", component: Profile },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Middleware kiểm tra authentication
// router.beforeEach((to, from, next) => {
//     const isAuthenticated = localStorage.getItem("user"); // Kiểm tra user trong localStorage
//     if (to.meta.requiresAuth && !isAuthenticated) {
//         next("/");
//     } else {
//         next();
//     }
// });

export default router;
