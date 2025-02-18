<template>
    <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <router-link to="/spa/projects">Quay lại</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Thông tin chi tiết dự án {{ projectStore.detailProject.name }}
            </li>
        </ol>
    </nav>

    <div class="project-container">
        <!-- Chi tiết dự án -->
        <div class="project-details">
            <h3>Chi tiết dự án</h3>

            <!-- Thông báo -->
            <div
                :class="['alert', projectStore.alertType]"
                role="alert"
                v-if="projectStore.notification !== null"
            >
                {{ projectStore.notification.message }}
            </div>

            <label for="">Tên dự án:</label>
            <p v-if="projectStore.clickUpdate === false">
                {{ projectStore.detailProject.name }}
            </p>
            <input
                type="text"
                class="form-control"
                v-model="projectStore.editProject.name"
                v-if="projectStore.clickUpdate"
            />

            <label for="">Mô tả:</label>
            <p v-if="projectStore.clickUpdate === false">
                {{ projectStore.detailProject.description }}
            </p>
            <textarea
                class="form-control"
                v-model="projectStore.editProject.description"
                v-if="projectStore.clickUpdate"
            ></textarea>

            <label for="">Trạng thái:</label>
            <p v-if="projectStore.clickUpdate === false">
                {{ projectStore.detailProject.status }}
            </p>
            <select
                class="form-select"
                v-if="projectStore.clickUpdate"
                v-model="projectStore.editProject.status"
            >
                <option
                    v-for="status in projectStore.statusProject"
                    :key="status.id"
                    :value="status.name"
                >
                    {{ status.name }}
                </option>
            </select>

            <label for="">Trưởng dự án:</label>
            <div class="manager-info">
                <p>{{ projectStore.detailProject.manager.name }}</p>
                <button
                    class="view-manager-btn"
                    @click="projectStore.showInfoManager = true"
                >
                    🔍
                </button>
            </div>

            <label for="">Ngày bắt đầu:</label>
            <p v-if="projectStore.clickUpdate === false">
                {{ projectStore.detailProject.start_date }}
            </p>
            <input
                type="date"
                class="form-control"
                v-model="projectStore.editProject.start_date"
                v-if="projectStore.clickUpdate"
            />

            <label for="">Ngày kết thúc:</label>
            <p v-if="projectStore.clickUpdate === false">
                {{ projectStore.detailProject.end_date }}
            </p>
            <input
                type="date"
                class="form-control"
                v-model="projectStore.editProject.end_date"
                v-if="projectStore.clickUpdate"
            />

            <button
                class="update-btn"
                @click="projectStore.changeProject"
                v-if="
                    projectStore.clickUpdate === false &&
                    authStore.user.id === projectStore.detailProject.manager.id
                "
            >
                Cập nhật
            </button>

            <div v-if="projectStore.clickUpdate">
                <button class="update-btn" @click="projectStore.updateProject">
                    Lưu thay đổi
                </button>
                <button
                    class="update-btn-close btn btn-danger"
                    @click="projectStore.clickUpdate = false"
                >
                    Thoát
                </button>
            </div>
        </div>

        <!-- Danh sách task -->
        <div class="project-tasks">
            <div class="task-header">
                <h3>Nhiệm vụ dự án</h3>
                <button
                    class="add-task-btn"
                    @click="addNewTask"
                    v-if="
                        authStore.user.id ===
                        projectStore.detailProject.manager.id
                    "
                >
                    + Thêm nhiệm vụ
                </button>
            </div>
            <div class="task-list-container">
                <ul>
                    <li>
                        <span class="task-name">task 1</span>
                        <span class="task-status">To do</span>
                        <button
                            class="delete-task-btn"
                            v-if="
                                authStore.user.id ===
                                projectStore.detailProject.manager.id
                            "
                        >
                            🗑
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Danh sách file liên quan -->
    <div class="project-files">
        <div class="file-header">
            <h3>Tài liệu dự án</h3>
            <input type="file" id="file-upload" hidden />
            <button class="upload-file-btn">📂 Tải File Lên</button>
        </div>
        <div class="file-list-container">
            <ul>
                <li>
                    <span class="file-name">file name</span>
                    <button class="delete-file-btn">🗑</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Thông tin quản lý dự án -->
    <template v-if="projectStore.showInfoManager">
        <div class="center-box" id="popupBox">
            <button
                class="close-btn"
                @click="projectStore.showInfoManager = false"
            >
                ✖
            </button>
            <h2>Thông tin Quản lý Dự án</h2>
            <label>Trưởng dự án</label>
            <p>{{ projectStore.detailProject.manager.name }}</p>
            <label>Email</label>
            <p>{{ projectStore.detailProject.manager.email }}</p>
            <label>Vai trò</label>
            <p>{{ projectStore.detailProject.manager.role }}</p>
        </div>
    </template>
</template>

<script setup>
import { useProjectStore } from "../../stores/projectStore";
import { useAuthStore } from "../../stores/authStore";
import { onBeforeRouteLeave } from "vue-router";

const projectStore = useProjectStore();
const authStore = useAuthStore();

// Được gọi trước khi component bị hủy
onBeforeRouteLeave(() => {
    projectStore.clickUpdate = false;
});
</script>
