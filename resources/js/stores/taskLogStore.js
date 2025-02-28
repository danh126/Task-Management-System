import { defineStore } from "pinia";

import { ref } from "vue";

export const useTaskLogStore = defineStore("taskLogStore", () => {
    const taskLogs = ref([]);

    // Create a task log
    const createTaskLog = async (task_id, user_id, old_status, new_status) => {
        try {
            await axios.post("/task-logs", {
                task_id: task_id,
                user_id: user_id,
                old_status: old_status,
                new_status: new_status,
            });
        } catch (error) {
            console.log(error);
        }
    };

    // Get all task logs by task id
    const getTaskLogsByTaskId = async (task_id) => {
        try {
            const response = await axios.get(
                `/task-logs-by-task-id/${task_id}`
            );

            taskLogs.value = response.data.task_logs;
        } catch (error) {
            console.log(error);
        }
    };

    // Clear task logs store
    const clearTaskLogsStore = () => {
        taskLogs.value = [];
    }

    return {
        taskLogs,
        createTaskLog,
        getTaskLogsByTaskId,
        clearTaskLogsStore
    };
});
