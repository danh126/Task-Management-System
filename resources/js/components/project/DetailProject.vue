<template>
    <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <router-link to="/spa/projects">Quay lại</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Thông tin chi tiết dự án
                <b>{{ projectStore.detailProject.name }}</b>
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
                <!-- <button
                    class="add-task-btn"
                    @click="addNewTask"
                    v-if="
                        authStore.user.id ===
                        projectStore.detailProject.manager.id
                    "
                >
                    + Thêm nhiệm vụ
                </button> -->
            </div>
            <div class="task-list-container">
                <!-- Sử dụng draggable để thay đổi mức độ ưu tiên công việc -->
                <draggable
                    v-model="projectStore.detailProject.tasks"
                    item-key="id"
                    @end="projectStore.updateTaskPriority"
                >
                    <template #item="{ element }">
                        <div>
                            <ul>
                                <li>
                                    <span class="task-name title">{{
                                        element.title
                                    }}</span>
                                    <span class="next mt-3">></span>
                                    <span
                                        :class="
                                            projectStore.getClassByPriority(
                                                element.priority
                                            )
                                        "
                                    >
                                        {{ element.priority }}
                                    </span>
                                    <span class="next mt-3">></span>
                                    <span
                                        :class="[
                                            'me-2',
                                            projectStore.getClassByTaskStatus(
                                                element
                                            ),
                                        ]"
                                    >
                                        {{ element.status }}
                                    </span>
                                    <button
                                        class="delete-task-btn"
                                        v-if="
                                            authStore.user.id ===
                                            projectStore.detailProject.manager
                                                ?.id
                                        "
                                    >
                                        🗑
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </template>
                </draggable>

                <!-- Thông báo -->
                <div v-if="projectStore.detailProject.tasks.length == 0">
                    <p class="text-center alert alert-success">
                        Chưa có nhiệm vụ nào được giao!
                    </p>
                </div>
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
                <li
                    v-for="(
                        file, index
                    ) in taskAttachmentStore.filesByProjectId"
                >
                    <div class="container-file">
                        <div class="list-files">
                            <i
                                :class="[
                                    'me-2',
                                    taskAttachmentStore.ClassByFileConfrim[
                                        file.file_confrim
                                    ],
                                ]"
                            ></i>
                            <a
                                :href="file.file_path"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <span class="file-name">{{
                                    file.file_name
                                }}</span>
                            </a>

                            <!-- Quyền của manager -->
                            <div class="note">
                                <button
                                    class="delete-file-btn mt-2"
                                    @click="
                                        taskAttachmentStore.deleteFileTaskAttachment(
                                            index,
                                            file.id
                                        )
                                    "
                                >
                                    🗑
                                </button>
                            </div>
                        </div>

                        <div class="date-file">
                            <span>Date: {{ file.created_at }}</span>
                            <span>Upload By: {{ file.user.name }}</span>
                        </div>
                    </div>
                </li>
            </ul>

            <!-- Thông báo -->
            <div v-if="taskAttachmentStore.filesByProjectId.length == 0">
                <p class="text-center alert alert-success">
                    Chưa có file nào được tải lên!
                </p>
            </div>
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
import { useTaskAttachmentStore } from "../../stores/taskAttachmentStore";

import { onBeforeRouteLeave } from "vue-router";

import draggable from "vuedraggable";

import { onMounted } from "vue";

const projectStore = useProjectStore();
const authStore = useAuthStore();
const taskAttachmentStore = useTaskAttachmentStore();

onMounted(() => {
    taskAttachmentStore.getFilesByProjectId(projectStore.detailProject.id);

    // Lắng nghe sự kiện task attachment delete
    taskAttachmentStore.eventStore.listenToEvent(
        "delete-task-attachment",
        ".DeleteTaskAttachmentEvent",
        (d) => {
            taskAttachmentStore.filesByProjectId =
                taskAttachmentStore.filesByProjectId.filter(
                    (f) => Number(f.id) !== Number(d.id)
                );
        }
    );
});

// Được gọi trước khi component bị hủy
onBeforeRouteLeave(() => {
    projectStore.clickUpdate = false;
});
</script>
