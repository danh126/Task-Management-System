import { defineStore } from "pinia";
import { ref } from "vue";
import { useAuthStore } from "./authStore";
import { useEventStore } from "./eventStore";
import axios from "axios";

export const useTaskCommentStore = defineStore("taskCommentStore", () => {
    const authStore = useAuthStore();
    const eventStore = useEventStore();

    const task_comments = ref([]);

    const task_comment = ref(null);

    // Create task comment
    const createTaskComment = async (task_id) => {
        try {
            const response = await axios.post("/task-comments", {
                task_id: task_id,
                user_id: authStore.user.id,
                comment: task_comment.value,
            });

            task_comment.value = null;

            // task_comments.value.unshift(response.data.task_comment);
        } catch (e) {
            console.log(e);
        }
    };

    // Get task comments by task id
    const getTaskCommentsByTaskId = async (task_id) => {
        try {
            const response = await axios.get(
                `/task-comments-by-task-id/${task_id}`
            );

            task_comments.value = response.data.task_comments;
        } catch (e) {
            console.log(e);
        }
    };

    // Delete task comment
    const deleteTaskComment = async (task_comment_id) => {
        try {
            await axios.delete(`/task-comments/${task_comment_id}`);
        } catch (e) {
            console.log(e);
        }
    };

    // Clear store
    const clearTaskCommentStore = () => {
        task_comments.value = [];
        task_comment.value = null;
    };

    return {
        authStore,
        eventStore,
        task_comment,
        task_comments,
        createTaskComment,
        getTaskCommentsByTaskId,
        clearTaskCommentStore,
        deleteTaskComment,
    };
});
