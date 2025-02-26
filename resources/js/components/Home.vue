<template>
    <div>
        <h1 class="text-center text-uppercase mt-2">
            Hệ thống quản lý công việc
        </h1>
        <div class="text-center">
            <img
                src="../../../public/img/logos/logo_ntd.png"
                alt="Logo"
                width="250"
            />
        </div>

        <!-- Dành cho manager & admin -->
        <div v-if="authStore.user.role !== 'employee'">
            <ProjectChart />
        </div>
    </div>
</template>

<script setup>
import ProjectChart from "./chart/ProjectChart.vue";

import { useAuthStore } from "../stores/authStore.js";

const authStore = useAuthStore();
</script>
