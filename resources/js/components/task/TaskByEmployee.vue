<template>
    <div>
        <h3 class="mt-2 mb-2 text-center title-content">Nhiệm vụ của bạn</h3>

        <!-- Note -->
        <div class="note">
            <p><span class="sub-1">∎</span>Tên dự án</p>
            <p><span class="sub-2">∎</span>Nhiệm vụ</p>
        </div>

        <!-- Task Lists Vue Draggable -->
        <div class="row">
            <div
                v-for="(task, status) in taskStore.taskLists"
                :key="task.id"
                class="col-lg-3 col-md-6 mb-3"
            >
                <h5 :class="taskStore.getClassByStatus(status)">
                    {{ taskStore.listStatus[status] }}
                </h5>
                <draggable
                    v-model="taskStore.taskLists[status]"
                    :group="{ name: 'tasks' }"
                    :data-status="status"
                    class="content"
                    @end="taskStore.updateTaskStatus($event)"
                >
                    <template #item="{ element }">
                        <div class="content-task">
                            <div class="date-task">
                                <p>Ngày giao: {{ element.created_at }}</p>
                                <p>Ngày kết thúc: {{ element.due_date }}</p>
                                <button
                                    @click="
                                        taskStore.clickTaskDetail(
                                            element.id,
                                            status
                                        )
                                    "
                                >
                                    Chi tiết
                                </button>
                            </div>
                            <div>
                                <p class="project-name">
                                    {{ element.project_name }}
                                </p>
                                <p class="title">{{ element.title }}</p>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, onUnmounted } from "vue";

import draggable from "vuedraggable";

import { useTaskStore } from "../../stores/taskStore";

const taskStore = useTaskStore();

// Thực hiện khi DOM được tải xong
onMounted(() => {
    taskStore.getListTasks();

    // Lắng nghe sự kiện task created
    taskStore.eventStore.listenToEvent("task-created", ".CreateTask", (d) => {
        taskStore.taskLists[d.status].unshift(d);
    });

    // Lắng nghe sự kiện task delete
    taskStore.eventStore.listenToEvent("task-delete", ".DeleteTask", (d) => {
        taskStore.taskLists[d.status] = taskStore.taskLists[d.status].filter(
            (t) => Number(t.id) !== Number(d.id)
        );
    });

    // Lắng nghe sự kiện task updated
    taskStore.eventStore.listenToEvent("task-updated", ".TaskUpdated", (d) => {
        const task = taskStore.taskLists[d.status].find((t) => t.id === d.id);

        if (!task) {
            return;
        }

        task.title = d.title;
        task.description = d.description;
        task.due_date = d.due_date;
        task.project_id = d.project_id;
    });
});

// Reset data store
onUnmounted(() => {
    taskStore.clearTaskStore();
});
</script>
