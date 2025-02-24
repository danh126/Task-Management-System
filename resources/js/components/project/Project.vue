<template>
    <div>
        <!-- Form create project -->
        <CreateProject v-if="projectStore.clickCreate" />

        <!-- Component Project Lists By Manager -->
        <ProjectByManager v-if="authStore.user.role !== 'employee'" />

        <!-- Component Project Lists By Manager -->
        <ProjectByEmployee v-else />
    </div>
</template>

<script setup>
// Stores
import { useProjectStore } from "../../stores/projectStore";
import { useAuthStore } from "../../stores/authStore";

// Components
import CreateProject from "./CreateProject.vue";
import ProjectByManager from "./ProjectByManager.vue";
import ProjectByEmployee from "./ProjectByEmployee.vue";

import { onBeforeRouteLeave } from "vue-router";

const projectStore = useProjectStore();
const authStore = useAuthStore();

onBeforeRouteLeave(() => {
    projectStore.closeForm();
});
</script>
