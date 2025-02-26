<template>
    <div>
        <h3 class="mt-2 mb-2 text-center">Danh sách nhiệm vụ</h3>
        <button
            class="mt-2 mb-3 btn btn-success"
            v-if="
                !taskStore.clickCreate &&
                taskStore.authStore.user.role === 'manager'
            "
            @click="taskStore.clickCreate = true"
        >
            Thêm nhiệm vụ mới
        </button>

        <!-- Danh sách nhiệm vụ -->
        <div
            class="accordion mt-2"
            id="accordionExample"
            v-if="
                taskStore.listTasks.data && taskStore.listTasks.data.length > 0
            "
        >
            <div
                class="accordion-item"
                v-for="(task, index) in taskStore.listTasks.data"
                :key="task.id"
            >
                <h2 class="accordion-header">
                    <button
                        class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        :data-bs-target="`#task-${task.id}`"
                        aria-expanded="true"
                        :aria-controls="`task-${task.id}`"
                    >
                        <p class="project-name">{{ task.project_name }}</p>
                        <span class="next">></span>
                        <p class="title">{{ task.title }}</p>
                        <span class="next">></span>
                        <p :class="taskStore.getClassByStatus(task.status)">
                            {{ task.status }}
                        </p>
                    </button>
                </h2>
                <div
                    :id="`task-${task.id}`"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordionExample"
                >
                    <div class="accordion-body">
                        <!-- Thông báo -->
                        <div
                            :class="['alert', taskStore.alertType]"
                            role="alert"
                            v-if="taskStore.notification !== null"
                        >
                            {{ taskStore.notification.message }}
                        </div>

                        <p v-if="task.isUpdate" class="mt-2">
                            <b class="me-2">Trạng thái:</b>
                            <select
                                class="form-select mt-2"
                                v-model="taskStore.taskEdit.status"
                            >
                                <option
                                    v-for="status in taskStore.listStatus"
                                    :value="status.name"
                                >
                                    {{ status.name }}
                                </option>
                            </select>
                        </p>

                        <p v-if="task.isEdit" class="mt-2">
                            <b class="me-2">Tiêu đề:</b>
                            <input
                                type="text"
                                class="form-control mt-2"
                                v-model="taskStore.taskEdit.title"
                            />
                        </p>
                        <p>
                            <b class="me-2">Mô tả:</b>
                            <span v-if="!task.isEdit">
                                {{ task.description }}
                            </span>
                            <textarea
                                type="text"
                                class="form-control mt-2"
                                v-if="task.isEdit"
                                v-model="taskStore.taskEdit.description"
                            ></textarea>
                        </p>
                        <p>
                            <b class="me-2">Người thực hiện:</b>
                            <span>{{ task.user_name }}</span>
                        </p>
                        <p>
                            <b>Mức độ ưu tiên:</b>
                            <span :class="taskStore.getClassByPriority(task)">
                                {{ task.priority }}
                            </span>
                        </p>
                        <p>
                            <b class="me-2">Ngày giao:</b>
                            <span>{{ task.created_at }}</span>
                        </p>
                        <p>
                            <b class="me-2">Ngày hết hạn:</b>
                            <span v-if="!task.isEdit">{{ task.due_date }}</span>
                            <input
                                type="date"
                                class="form-control mt-2"
                                v-if="task.isEdit"
                                v-model="taskStore.taskEdit.due_date"
                            />
                        </p>

                        <!-- Button xử lý tác vụ -->
                        <div
                            v-if="
                                !task.isEdit &&
                                taskStore.deleteTask === null &&
                                taskStore.authStore.user.role !== 'admin'
                            "
                        >
                            <button
                                class="btn btn-primary me-2"
                                v-if="
                                    taskStore.authStore.user.role === 'manager'
                                "
                                @click="taskStore.findTask(task)"
                            >
                                Cập nhật
                            </button>
                            <button
                                class="btn btn-success me-2"
                                @click="
                                    taskStore.clickTaskDetail(
                                        task.id,
                                        task.status
                                    )
                                "
                            >
                                Chi tiết
                            </button>
                            <button
                                class="btn btn-danger me-2"
                                v-if="
                                    taskStore.authStore.user.role === 'manager'
                                "
                                @click="taskStore.clickDelTask(index, task)"
                            >
                                Xóa nhiệm vụ
                            </button>
                        </div>

                        <!-- Update task -->
                        <div v-if="task.isEdit">
                            <button
                                class="btn btn-primary me-2"
                                @click="taskStore.updateTask(index)"
                            >
                                Lưu thay đổi
                            </button>
                            <button
                                class="btn btn-danger me-2"
                                @click="task.isEdit = false"
                            >
                                Thoát
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông báo chưa có dữ liệu -->
        <div class="text-center" v-else>
            <p class="alert alert-success">Chưa có dữ liệu!</p>
        </div>

        <!-- Phân trang -->
        <div class="mt-2">
            <div>
                {{ taskStore.listTasks.from }} - {{ taskStore.listTasks.to }} of
                {{ taskStore.listTasks.total }}
            </div>
            <ul class="pagination mt-2 mb-2">
                <li
                    class="page-item"
                    :class="{
                        disabled: taskStore.listTasks.prev_page_url === null,
                    }"
                    @click="
                        taskStore.listTasks.prev_page_url &&
                            taskStore.getListTasks(
                                taskStore.listTasks.current_page - 1
                            )
                    "
                >
                    <a class="page-link"><</a>
                </li>
                <li
                    class="page-item"
                    v-if="taskStore.listTasks.prev_page_url"
                    @click="
                        taskStore.getListTasks(
                            taskStore.listTasks.current_page - 1
                        )
                    "
                >
                    <a class="page-link">{{
                        taskStore.listTasks.current_page - 1
                    }}</a>
                </li>
                <li class="page-item active">
                    <a class="page-link">{{
                        taskStore.listTasks.current_page
                    }}</a>
                </li>
                <li
                    class="page-item"
                    v-if="taskStore.listTasks.next_page_url"
                    @click="
                        taskStore.getListTasks(
                            taskStore.listTasks.current_page + 1
                        )
                    "
                >
                    <a class="page-link">{{
                        taskStore.listTasks.current_page + 1
                    }}</a>
                </li>
                <li
                    class="page-item"
                    :class="{
                        disabled: taskStore.listTasks.next_page_url === null,
                    }"
                    @click="
                        taskStore.listTasks.next_page_url &&
                            taskStore.getListTasks(
                                taskStore.listTasks.current_page + 1
                            )
                    "
                >
                    <a class="page-link">></a>
                </li>
            </ul>
        </div>

        <!-- Modal xóa nhiệm vụ -->
        <div v-if="taskStore.deleteTask !== null">
            <div
                class="modal fade show d-block"
                tabindex="-1"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                Bạn có chắc chắn xóa nhiệm vụ?
                            </h1>
                            <button
                                type="button"
                                class="btn-close"
                                @click="taskStore.closeModal"
                            ></button>
                        </div>
                        <div class="modal-body text-center">
                            {{ taskStore.deleteTask.title }}
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="taskStore.closeModal"
                            >
                                Hủy
                            </button>
                            <button
                                class="btn btn-danger"
                                @click="taskStore.confirmDelTask"
                            >
                                Xóa dự án
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
            <!-- Thêm backdrop -->
        </div>
    </div>
</template>

<script setup>
// Libary
import { onMounted, watch, onBeforeUnmount } from "vue";

// Stores
import { useTaskStore } from "../../stores/taskStore";

// define
const taskStore = useTaskStore();

// Thực hiện khi DOM được tải xong
onMounted(() => {
    taskStore.getListTasks();

    // Lắng nghe sự kiện task created
    taskStore.eventStore.listenToEvent("task-created", ".CreateTask", (d) => {
        taskStore.listTasks.data.unshift(d);
    });

    // Lắng nghe sự kiện task status update
    taskStore.eventStore.listenToEvent(
        "task-status-update",
        ".TaskStatusUpdate",
        (d) => {
            const task = taskStore.listTasks.data.find((t) => t.id === d.id);

            if (!task) {
                return;
            }

            task.status = d.status;
        }
    );
});

// Reset data store
onBeforeUnmount(() => {
    taskStore.clearTaskStore();
});
</script>
