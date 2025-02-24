<template>
    <div>
        <!-- Form create task -->
        <CreateTask v-if="taskStore.clickCreate" />

        <!-- Component task by manager-->
        <TaskByManager v-if="taskStore.authStore.user.role !== 'employee'" />

        <!-- Component task by employee -->
        <TaskByEmployee v-else />
    </div>
</template>

<script setup>
// Libary
import { onMounted, watch } from "vue";
import echo from "../../echo.js";

// Components
import CreateTask from "./CreateTask.vue";
import TaskByEmployee from "./TaskByEmployee.vue";
import TaskByManager from "./TaskByManager.vue";

// Stores
import { useTaskStore } from "../../stores/taskStore";

// define
const taskStore = useTaskStore();
</script>
