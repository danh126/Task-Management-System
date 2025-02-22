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
                            <p class="project-name">
                                {{ element.project_name }}
                            </p>
                            <p>↔️</p>
                            <p class="title">{{ element.title }}</p>
                        </div>
                    </template>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

import draggable from "vuedraggable";

import { useTaskStore } from "../../stores/taskStore";

const taskStore = useTaskStore();
</script>
