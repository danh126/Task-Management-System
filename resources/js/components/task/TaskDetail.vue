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
                </li>
            </ol>
        </nav>

        <div class="row">
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
            <div class="col-lg-4 col-md-4 comment-task">
                <h3>Bình luận</h3>
                <div class="content">
                    <div class="alert alert-success text-center">
                        Chưa có bình luận nào!
                    </div>
                </div>
                <div class="button">
                    <input class="form-control" type="text" />
                    <button class="btn btn-primary">Gửi</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 file-task">
                <div class="task-files">
                    <div class="file-header">
                        <h3>Tài liệu dự án</h3>
                        <input type="file" id="file-upload" hidden />
                        <button class="btn btn-primary">📂 Tải File Lên</button>
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
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";

import { useTaskStore } from "../../stores/taskStore";

const taskStore = useTaskStore();
</script>
