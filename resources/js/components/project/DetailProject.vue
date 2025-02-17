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

<style scoped>
/* Định dạng chung cho popup */
.center-box {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #ffffff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    text-align: left;
    min-width: 350px;
    max-width: 90%;
    font-family: Arial, sans-serif;
    animation: fadeIn 0.3s ease-in-out;
}

/* Tiêu đề */
.center-box h2 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #333;
    text-align: center;
}

/* Label và nội dung */
.center-box label {
    font-weight: bold;
    color: #444;
    display: block;
    margin-top: 10px;
}

.center-box p {
    background: #f5f5f5;
    padding: 8px;
    border-radius: 6px;
    margin-top: 5px;
    color: #333;
}

/* Nút đóng */
.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    border: none;
    font-size: 18px;
    color: #666;
    cursor: pointer;
    transition: color 0.2s;
}

.close-btn:hover {
    color: #ff4d4d;
}

/* Task name */
.task-name {
    flex: 1;
}

/* Task status */
.task-status {
    font-size: 14px;
    color: #666;
    margin-right: 10px;
}

/* Nút xóa */
.delete-task-btn {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}

.delete-task-btn:hover {
    background: #c82333;
}

/* Container chính */
.project-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    max-width: 1000px;
    margin: 20px auto;
}

/* Card chung cho từng phần */
.project-details,
.project-tasks,
.project-files {
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

/* Hiệu ứng hover */
.project-details:hover,
.project-tasks:hover,
.project-files:hover {
    transform: translateY(-5px);
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
}

/* Tiêu đề */
.project-details h3,
.project-tasks h3,
.project-files h3 {
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 16px;
    margin-bottom: 15px;
    color: #007bff;
    border-bottom: 2px solid #007bff;
    padding-bottom: 5px;
}

/* Labels và text */
.project-details label {
    font-weight: bold;
    color: #333;
    margin-top: 10px;
    display: block;
}

.project-details p {
    background: #f1f1f1;
    padding: 10px;
    border-radius: 5px;
    margin: 5px 0;
    color: #333;
}

/* Nút cập nhật */
.update-btn {
    width: 100%;
    padding: 10px;
    margin-top: 15px;
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-transform: uppercase;
    font-weight: bold;
    transition: background 0.3s;
}

.update-btn:hover {
    background: linear-gradient(45deg, #0056b3, #003f7f);
}

.update-btn-close {
    width: 100%;
    padding: 10px;
    margin-top: 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-transform: uppercase;
    font-weight: bold;
    transition: background 0.3s;
}

/* Bọc phần tiêu đề + nút */
.task-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

/* Nút thêm task */
.add-task-btn {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    transition: background 0.3s;
}

.add-task-btn:hover {
    background: linear-gradient(45deg, #0056b3, #003f7f);
}

/* Bọc danh sách task */
.task-list-container {
    max-height: 600px; /* Giới hạn chiều cao, có thể chỉnh sửa */
    overflow-y: auto; /* Bật cuộn dọc khi danh sách quá dài */
    padding-right: 5px; /* Để tránh nội dung bị che bởi thanh cuộn */
}

/* Ẩn thanh cuộn trên Firefox */
.task-list-container {
    scrollbar-width: thin;
    scrollbar-color: #007bff #f1f1f1;
}

/* Tùy chỉnh thanh cuộn cho Chrome & Edge */
.task-list-container::-webkit-scrollbar {
    width: 6px;
}

.task-list-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.task-list-container::-webkit-scrollbar-thumb {
    background: #007bff;
    border-radius: 10px;
}

.task-list-container::-webkit-scrollbar-thumb:hover {
    background: #0056b3;
}

/* Task List */
.project-tasks ul {
    list-style: none;
    padding: 0;
}

.project-tasks li {
    padding: 10px;
    border-radius: 5px;
    background: #f1f1f1;
    margin: 5px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Danh sách file */
/* Header chứa tiêu đề + nút tải file */
.file-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

/* Container danh sách file */
.file-list-container {
    max-height: 200px;
    overflow-y: auto;
    padding-right: 5px;
}

/* Danh sách file */
.project-files ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.project-files li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background: #f1f1f1;
    border-radius: 5px;
    margin: 5px 0;
    transition: background 0.3s;
}

.project-files li:hover {
    background: #e0e0e0;
}

/* Tên file */
.file-name {
    flex: 1;
}

/* Nút tải file lên */
.upload-file-btn {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}

.upload-file-btn:hover {
    background: linear-gradient(45deg, #0056b3, #003f7f);
}

/* Nút xóa file */
.delete-file-btn {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}

.delete-file-btn:hover {
    background: #c82333;
}

/* Manager Info */
.manager-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.manager-info p {
    margin: 0;
    background: #f1f1f1;
    padding: 10px;
    border-radius: 5px;
    flex-grow: 1;
}

.view-manager-btn {
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}

.view-manager-btn:hover {
    background: #0056b3;
}

/* Responsive */
@media (max-width: 768px) {
    .project-container {
        grid-template-columns: 1fr;
    }

    .project-files {
        grid-column: span 1;
    }
}
</style>
