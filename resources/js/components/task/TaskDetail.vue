<template>
    <div>
        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link to="/spa/tasks">Quay lại</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Thông tin chi tiết nhiệm vụ
                    <b>{{ taskStore.taskDetail.title }}</b>
                    <span v-if="taskStore.authStore.user.role === 'manager'">
                        > Người thực hiện:
                        <b>{{ taskStore.taskDetail.user_name }}</b>
                    </span>
                </li>
            </ol>
        </nav>

        <div class="row">
            <!-- Chi tiết nhiệm vụ -->
            <div class="col-lg-4 col-md-4 detail-task">
                <h3>Chi tiết nhiệm vụ</h3>
                <div>
                    <p><b>Dự án: </b>{{ taskStore.taskDetail.project_name }}</p>
                    <p><b>Nhiệm vụ: </b>{{ taskStore.taskDetail.title }}</p>
                    <p><b>Mô tả: </b>{{ taskStore.taskDetail.description }}</p>
                    <p>
                        <b>Mức độ ưu tiên: </b>
                        <span
                            :class="
                                taskStore.getClassByPriority(
                                    taskStore.taskDetail
                                )
                            "
                            >{{ taskStore.taskDetail.priority }}</span
                        >
                    </p>
                    <p>
                        <b>Trạng thái: </b>
                        <span
                            :class="
                                taskStore.getClassByStatus(
                                    taskStore.taskDetail.status
                                )
                            "
                            >{{
                                taskStore.listStatus[
                                    taskStore.taskDetail.status
                                ]
                            }}</span
                        >
                    </p>
                    <p>
                        <b>Ngày bắt đầu: </b
                        >{{ taskStore.taskDetail.created_at }}
                    </p>
                    <p>
                        <b>Ngày kết thúc: </b
                        >{{ taskStore.taskDetail.created_at }}
                    </p>
                </div>
            </div>

            <!-- Bình luận liên quan -->
            <div class="col-lg-4 col-md-4 comment-task">
                <h3>Bình luận</h3>
                <div class="alert alert-success text-center">
                    Chưa có bình luận nào!
                </div>
                <div class="content" v-if="taskStore.comments.length > 0"></div>
                <div class="button">
                    <input class="form-control" type="text" />
                    <button class="btn btn-primary">Gửi</button>
                </div>
            </div>

            <!-- File liên quan đến nhiệm vụ -->
            <div class="col-lg-4 col-md-4 file-task">
                <div class="task-files">
                    <div class="file-header">
                        <h3>Tài liệu nhiệm vụ</h3>
                        <input
                            type="file"
                            id="file-upload"
                            multiple
                            @change="handleFileSelect"
                            ref="fileInput"
                            hidden
                        />
                        <button
                            class="btn btn-primary"
                            @click="triggerFileInput"
                        >
                            📂 Chọn File
                        </button>
                    </div>

                    <!-- Ghi chú -->
                    <div
                        class="note"
                        v-if="taskStore.selectedFile.length === 0"
                    >
                        <p>
                            <i class="fa fa-adjust me-2 text-danger"></i> Chưa
                            duyệt
                        </p>
                        <p>
                            <i class="fa fa-check-circle text-primary"></i> Đã
                            duyệt
                        </p>
                    </div>

                    <!-- Files chọn để uploads -->
                    <div v-if="taskStore.selectedFile.length > 0">
                        <p class="bg-info-subtle p-2 text-center">
                            File bạn đã chọn
                        </p>
                        <div class="file-list-selected">
                            <ul>
                                <li
                                    v-for="(
                                        file, index
                                    ) in taskStore.selectedFile"
                                >
                                    <span class="file-name">{{
                                        file.name
                                    }}</span>
                                    <button
                                        class="delete-file-btn"
                                        @click="
                                            taskStore.deleteFileSelect(index)
                                        "
                                    >
                                        🗑
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <button
                            class="btn btn-primary mt-2"
                            @click="taskStore.uploadFiles"
                        >
                            <i
                                class="fas fa-file-upload"
                                style="color: #ffd43b"
                            ></i>
                            Tải lên
                        </button>
                    </div>

                    <!-- Danh sách file liên quan -->
                    <div class="file-list-container" v-else>
                        <!-- Thông báo -->
                        <div
                            class="alert alert-success text-center"
                            v-if="taskStore.taskAttachments.length === 0"
                        >
                            Chưa có file nào được tải lên!
                        </div>

                        <ul>
                            <li
                                v-for="(
                                    file, index
                                ) in taskStore.taskAttachments"
                            >
                                <i
                                    :class="[
                                        'me-2',
                                        taskStore.ClassByFileConfrim[
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
                                <span>Date: {{ file.created_at }}</span>

                                <!-- Quyền của manager -->
                                <div
                                    class="note"
                                    v-if="
                                        taskStore.authStore.user.role ===
                                            'manager' && file.file_confrim === 0
                                    "
                                >
                                    <button
                                        class="btn btn-primary me-2"
                                        @click="taskStore.fileConfrim(file.id)"
                                    >
                                        <i class="fa fa-check-circle me-2"></i
                                        >Duyệt
                                    </button>
                                    <button
                                        class="delete-file-btn"
                                        @click="
                                            taskStore.deleteFileTaskAttachment(
                                                index,
                                                file.id
                                            )
                                        "
                                    >
                                        🗑
                                    </button>
                                </div>

                                <!-- Quyền của employee -->
                                <div
                                    v-if="
                                        taskStore.authStore.user.role ===
                                            'employee' &&
                                        file.file_confrim === 0
                                    "
                                >
                                    <button
                                        class="delete-file-btn"
                                        @click="
                                            taskStore.deleteFileTaskAttachment(
                                                index,
                                                file.id
                                            )
                                        "
                                    >
                                        🗑
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useTaskStore } from "../../stores/taskStore";

import { ref, onMounted } from "vue";

const taskStore = useTaskStore();

// Upload file
const fileInput = ref(null);

const triggerFileInput = () => {
    fileInput.value.click(); // Kích hoạt input file khi nhấn button
};

// Hàm input file change
const handleFileSelect = (event) => {
    const files = event.target.files;
    taskStore.setFiles(files); // lưu file khi chọn
};

onMounted(() => {
    taskStore.getTaskAttachments(taskStore.taskDetail.id);

    // Lắng nghe sự kiện task attachment created
    taskStore.eventStore.listenToEvent(
        "create-task-attachment",
        ".CreateTaskAttachmentEvent",
        (d) => {
            taskStore.taskAttachments.unshift(d);
        }
    );

    // Lắng nghe sự kiện task attachment delete
    taskStore.eventStore.listenToEvent(
        "delete-task-attachment",
        ".DeleteTaskAttachmentEvent",
        (d) => {
            taskStore.taskAttachments = taskStore.taskAttachments.filter(
                (f) => Number(f.id) !== Number(d.id)
            );
        }
    );

    // Lắng nghe sự kiện task attachment updated
    taskStore.eventStore.listenToEvent(
        "updated-task-attachment",
        ".UpdateTaskAttachmentEvent",
        (d) => {
            const file = taskStore.taskAttachments.find(
                (file) => Number(file.id) === Number(d.id)
            );

            if (!file) {
                return;
            }

            file.file_confrim = 1;
        }
    );
});
</script>
