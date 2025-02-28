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
                        v-if="taskAttachmentStore.selectedFile.length === 0"
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

                    <!-- Thanh tiến trình uploads -->
                    <div
                        v-if="taskAttachmentStore.progress > 0"
                        class="upload-box"
                    >
                        <button
                            class="close-btn"
                            @click="taskAttachmentStore.progress = 0"
                        >
                            X
                        </button>
                        <p v-if="taskAttachmentStore.progress < 100">
                            Đang tải lên: {{ taskAttachmentStore.progress }}%
                        </p>
                        <p v-else>
                            Hoàn thành: {{ taskAttachmentStore.progress }}%
                        </p>
                        <div class="progress-container">
                            <div
                                class="progress-bar"
                                :style="{
                                    width: taskAttachmentStore.progress + '%',
                                }"
                            ></div>
                        </div>
                    </div>

                    <!-- Thông báo -->
                    <div
                        class="alert alert-success text-center"
                        v-if="
                            taskAttachmentStore.taskAttachments.length == 0 &&
                            taskAttachmentStore.selectedFile.length == 0
                        "
                    >
                        Chưa có file nào được tải lên!
                    </div>

                    <!-- Files chọn để uploads -->
                    <div v-if="taskAttachmentStore.selectedFile.length > 0">
                        <p class="bg-info-subtle p-2 text-center">
                            File bạn đã chọn
                        </p>
                        <div class="file-list-selected">
                            <ul>
                                <li
                                    v-for="(
                                        file, index
                                    ) in taskAttachmentStore.selectedFile"
                                >
                                    <span class="file-name">{{
                                        file.name
                                    }}</span>
                                    <button
                                        class="delete-file-btn"
                                        @click="
                                            taskAttachmentStore.deleteFileSelect(
                                                index
                                            )
                                        "
                                    >
                                        🗑
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <button
                            class="btn btn-primary mt-2"
                            @click="
                                taskAttachmentStore.uploadFiles(
                                    taskStore.taskDetail
                                )
                            "
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
                        <ul>
                            <li
                                v-for="(
                                    file, index
                                ) in taskAttachmentStore.taskAttachments"
                            >
                                <div class="list-files-2">
                                    <i
                                        :class="[
                                            'me-2',
                                            taskAttachmentStore
                                                .ClassByFileConfrim[
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
                                    <div
                                        class="note"
                                        v-if="
                                            taskStore.authStore.user.role ===
                                                'manager' &&
                                            file.file_confrim === 0
                                        "
                                    >
                                        <button
                                            class="btn btn-primary mt-2 me-2"
                                            @click="
                                                taskAttachmentStore.fileConfrim(
                                                    file.id
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-check-circle me-2"
                                            ></i
                                            >Duyệt
                                        </button>
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

                                    <!-- Quyền của employee -->
                                    <div
                                        v-if="
                                            taskStore.authStore.user.role ===
                                                'employee' &&
                                            file.file_confrim === 0
                                        "
                                    >
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

                                <div class="date-file-2">
                                    <span>Date: {{ file.created_at }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Lịch sử thay đổi trạng thái -->
            <div class="col-lg-4 col-md-4 task-log">
                <div class="dots-list">
                    <h3>Lịch sử thay đổi trạng thái</h3>

                    <!-- Thông báo -->
                    <div
                        class="alert alert-success text-center"
                        v-if="taskLogStore.taskLogs.length == 0"
                    >
                        Chưa có lịch sử thay đổi trạng thái nào!
                    </div>

                    <ol v-else>
                        <li v-for="log in taskLogStore.taskLogs">
                            <div class="log">
                                <span class="date">{{ log.created_at }}</span>
                                <span
                                    :class="
                                        taskStore.getClassByStatus(
                                            log.old_status
                                        )
                                    "
                                >
                                    {{ log.old_status }}
                                </span>
                                <span
                                    ><i
                                        class="fa-solid fa-arrow-right"
                                        style="color: #74c0fc"
                                    ></i
                                ></span>
                                <span
                                    :class="
                                        taskStore.getClassByStatus(
                                            log.new_status
                                        )
                                    "
                                >
                                    {{ log.new_status }}
                                </span>
                                <span class="user">{{ log.user.name }}</span>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Bình luận liên quan -->
            <div class="col-lg-12 col-md-12 comment-task">
                <h3>Bình luận</h3>

                <!-- Comments -->
                <div
                    class="content"
                    v-if="taskCommentStore.task_comments.length > 0"
                >
                    <div
                        v-for="comment in taskCommentStore.task_comments"
                        class="comment"
                    >
                        <div class="comment-header">
                            <p>{{ comment.user.name }}</p>
                            <span
                                v-if="
                                    taskCommentStore.authStore.user.id ===
                                    comment.user.id
                                "
                                @click="
                                    taskCommentStore.deleteTaskComment(
                                        comment.id
                                    )
                                "
                                >X</span
                            >
                        </div>

                        <div class="comment-footer">
                            <p>{{ comment.comment }}</p>
                            <span>{{ comment.created_at }}</span>
                        </div>
                    </div>
                </div>

                <!-- Thông báo -->
                <div class="alert alert-success text-center" v-else>
                    Chưa có bình luận nào!
                </div>

                <!-- Message  -->
                <div class="button">
                    <input
                        class="form-control"
                        type="text"
                        v-model="taskCommentStore.task_comment"
                    />
                    <button
                        class="btn btn-primary"
                        @click="
                            taskCommentStore.createTaskComment(
                                taskStore.taskDetail.id
                            )
                        "
                    >
                        Gửi
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useTaskStore } from "../../stores/taskStore";
import { useTaskAttachmentStore } from "../../stores/taskAttachmentStore";
import { useTaskCommentStore } from "../../stores/taskCommentStore";
import { useTaskLogStore } from "../../stores/taskLogStore";

import { ref, onMounted, onBeforeUnmount } from "vue";

const taskStore = useTaskStore();
const taskAttachmentStore = useTaskAttachmentStore();
const taskCommentStore = useTaskCommentStore();
const taskLogStore = useTaskLogStore();

// Upload file
const fileInput = ref(null);

const triggerFileInput = () => {
    fileInput.value.click();
};

// Hàm input file change
const handleFileSelect = (event) => {
    const files = event.target.files;
    taskAttachmentStore.setFiles(files);
};

onMounted(() => {
    // Lấy danh sách file liên quan
    taskAttachmentStore.getTaskAttachments(taskStore.taskDetail.id);

    // Lấy danh sách comment liên quan
    taskCommentStore.getTaskCommentsByTaskId(taskStore.taskDetail.id);

    // Lấy danh sách lịch sử thay đổi trạng thái
    taskLogStore.getTaskLogsByTaskId(taskStore.taskDetail.id);

    // Lắng nghe sự kiện task attachment created
    taskAttachmentStore.eventStore.listenToEvent(
        "create-task-attachment",
        ".CreateTaskAttachmentEvent",
        (d) => {
            taskAttachmentStore.taskAttachments.unshift(d);
        }
    );

    // Lắng nghe sự kiện task attachment delete
    taskAttachmentStore.eventStore.listenToEvent(
        "delete-task-attachment",
        ".DeleteTaskAttachmentEvent",
        (d) => {
            taskAttachmentStore.taskAttachments =
                taskAttachmentStore.taskAttachments.filter(
                    (f) => Number(f.id) !== Number(d.id)
                );
        }
    );

    // Lắng nghe sự kiện task attachment updated
    taskAttachmentStore.eventStore.listenToEvent(
        "updated-task-attachment",
        ".UpdateTaskAttachmentEvent",
        (d) => {
            const file = taskAttachmentStore.taskAttachments.find(
                (file) => Number(file.id) === Number(d.id)
            );

            if (!file) {
                return;
            }

            file.file_confrim = 1;
        }
    );

    // Lắng nghe sự kiện task comment created
    taskCommentStore.eventStore.listenToEvent(
        "create-task-comment",
        ".CreateTaskCommentEvent",
        (d) => {
            taskCommentStore.task_comments.unshift(d);
        }
    );

    // Lắng nghe sự kiện task comment delete
    taskCommentStore.eventStore.listenToEvent(
        "delete-task-comment",
        ".DeleteTaskCommentEvent",
        (d) => {
            taskCommentStore.task_comments =
                taskCommentStore.task_comments.filter(
                    (f) => Number(f.id) !== Number(d.id)
                );
        }
    );
});

onBeforeUnmount(() => {
    // Clear store
    taskAttachmentStore.clearTaskAttachmentStore();
    taskCommentStore.clearTaskCommentStore();
    taskLogStore.clearTaskLogsStore();
});
</script>
