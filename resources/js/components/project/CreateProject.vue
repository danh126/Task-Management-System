<template>
    <!-- Form thêm dự án mới -->
    <div>
        <h3 class="mt-2 mb-2 text-center">Thêm dự án mới</h3>

        <!-- Thông báo -->
        <div
            :class="['alert', projectStore.alertType]"
            role="alert"
            v-if="projectStore.notification !== null"
        >
            {{ projectStore.notification.message }}
        </div>

        <div class="form-group">
            <label for="" class="form-lable mt-2 mb-2"
                >Tên dự án <span class="text-danger">(*)</span></label
            >
            <input
                type="text"
                class="form-control"
                v-model="projectStore.project.name"
            />
        </div>
        <div class="form-group">
            <label for="" class="form-lable mt-2 mb-2"
                >Mô tả <span class="text-danger">(*)</span></label
            >
            <textarea
                class="form-control"
                v-model="projectStore.project.description"
            ></textarea>
        </div>
        <div class="form-group">
            <label for="" class="form-lable mt-2 mb-2"
                >Trưởng dự án <span class="text-danger">(*)</span></label
            >
            <select
                class="form-select"
                v-model="projectStore.project.manager_id"
            >
                <option
                    v-for="manager in projectStore.listManagers.managers"
                    :value="manager.id"
                >
                    {{ manager.name }}
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for="" class="form-lable mt-2 mb-2"
                >Ngày bắt đầu <span class="text-danger">(*)</span></label
            >
            <input
                type="date"
                class="form-control"
                v-model="projectStore.project.start_date"
            />
        </div>
        <div class="form-group">
            <label for="" class="form-lable mt-2 mb-2"
                >Ngày kết thúc <span class="text-danger">(*)</span></label
            >
            <input
                type="date"
                class="form-control"
                v-model="projectStore.project.end_date"
            />
        </div>
        <div class="form-group text-center mt-2 mb-2">
            <button
                class="btn btn-primary me-2"
                :disabled="!projectStore.isValidated"
                @click="projectStore.createProject"
            >
                Thêm dự án
            </button>
            <button class="btn btn-danger" @click="projectStore.closeForm">
                Thoát
            </button>
        </div>
    </div>
</template>

<script setup>
import { useProjectStore } from "../../stores/projectStore";

const projectStore = useProjectStore();
</script>
