<template>
    <div>
        <h3 class="text-center mt-2 mb-2">Thêm nhiệm vụ mới</h3>

        <!-- Thông báo -->
        <div
            :class="['alert', taskStore.alertType]"
            role="alert"
            v-if="taskStore.notification !== null"
        >
            {{ taskStore.notification.message }}
        </div>

        <div class="form-group">
            <label for="">Tiêu đề <span class="text-danger">(*)</span></label>
            <input
                type="text"
                v-model="taskStore.task.title"
                class="form-control mt-2 mb-2"
            />
        </div>
        <div class="form-group">
            <label for="">Mô tả <span class="text-danger">(*)</span></label>
            <textarea
                v-model="taskStore.task.description"
                class="form-control mt-2 mb-2"
            ></textarea>
        </div>
        <div class="form-group">
            <label for="">Dự án <span class="text-danger">(*)</span></label>
            <select
                class="form-select mt-2 mb-2"
                v-model="taskStore.task.project_id"
            >
                <option
                    v-for="project in taskStore.listProjects"
                    :value="project.id"
                >
                    Project: {{ project.name }} - Start:
                    {{ project.start_date }} - End:
                    {{ project.end_date }}
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for=""
                >Người phụ trách <span class="text-danger">(*)</span></label
            >
            <select
                class="form-select mt-2 mb-2"
                v-model="taskStore.task.assignee_id"
            >
                <option
                    v-for="employee in taskStore.listEmployees"
                    :value="employee.id"
                >
                    {{ employee.name }}
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for=""
                >Ngày hết hạn <span class="text-danger">(*)</span></label
            >
            <input
                type="date"
                v-model="taskStore.task.due_date"
                class="form-control mt-2 mb-2"
            />
        </div>

        <div class="form-group text-center mt-2 mb-2">
            <button
                class="btn btn-primary me-2"
                :disabled="!taskStore.isFormValid"
                @click="taskStore.createTask"
            >
                Thêm nhiệm vụ
            </button>
            <button class="btn btn-danger" @click="taskStore.closeFormCreate">
                Thoát
            </button>
        </div>
    </div>
</template>

<script setup>
import { useTaskStore } from "../../stores/taskStore";

import { onMounted } from "vue";

const taskStore = useTaskStore();

// Thực hiện khi DOM được tải xong
onMounted(() => {
    taskStore.getListProjectsByManager();
    taskStore.getListEmployees();
});
</script>
