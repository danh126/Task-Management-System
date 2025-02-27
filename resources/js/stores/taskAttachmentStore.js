import { defineStore } from "pinia";

import { ref } from "vue";

import { useAuthStore } from "./authStore";
import { useEventStore } from "./eventStore";

import axios from "axios";

export const useTaskAttachmentStore = defineStore("taskAttachmentStore", () => {
    const authStore = useAuthStore();
    const eventStore = useEventStore();

    const selectedFile = ref([]);
    const taskAttachments = ref([]);
    const filesByProjectId = ref([]);
    const progress = ref(0);

    const ClassByFileConfrim = ref({
        0: "fa fa-adjust text-danger",
        1: "fa fa-check-circle text-primary",
    });

    // Hàm lưu file đã chọn
    const setFiles = (files) => {
        if (selectedFile.value.length > 0) {
            selectedFile.value.push(...files);
        } else {
            selectedFile.value = [...files];
        }
    };

    // Hàm xóa file upload đã chọn
    const deleteFileSelect = (index) => {
        selectedFile.value.splice(index, 1);
    };

    // Hàm upload file
    const uploadFiles = async (task_deatil) => {
        const formData = new FormData();

        selectedFile.value.forEach((file) => {
            formData.append("files[]", file);
            formData.append("task_id", task_deatil.id);
            formData.append("uploaded_by", authStore.user.id);
        });

        try {
            await axios.post("/task-attachments", formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
                onUploadProgress: (progressEvent) => {
                    progress.value = Math.round(
                        (progressEvent.loaded / progressEvent.total) * 100
                    );
                },
            });

            selectedFile.value = [];
        } catch (error) {
            console.log(error);
        }
    };

    // Hàm lấy danh sách file task attachments
    const getTaskAttachments = async (id) => {
        try {
            const response = await axios.get(
                `/task-attachments-by-task-id/${id}`
            );

            taskAttachments.value = response.data.task_attachments;
        } catch (error) {
            console.log(error);
        }
    };

    // Hàm xóa file attachment
    const deleteFileTaskAttachment = async (index, id) => {
        try {
            await axios.delete("/task-attachments/" + id);
        } catch (error) {
            console.log(error);
        }
    };

    // Hàm xác nhận file task attachment
    const fileConfrim = async (id) => {
        try {
            await axios.post(`/task-attachments-file-confrim/${id}`);
        } catch (error) {
            console.log(error);
        }
    };

    // Hàm lấy danh sách file liên quan trong dự án
    const getFilesByProjectId = async (id) => {
        try {
            const response = await axios.get(
                `/task-attachments-by-project/${id}`
            );

            filesByProjectId.value = response.data.task_attachments;
        } catch (e) {
            console.log(e);
        }
    };

    // Clear task attachment store
    const clearTaskAttachmentStore = () => {
        selectedFile.value = [];
        filesByProjectId.value = [];
        taskAttachments.value = [];
        progress.value = 0;
    };

    return {
        eventStore,
        selectedFile,
        taskAttachments,
        ClassByFileConfrim,
        filesByProjectId,
        progress,
        setFiles,
        deleteFileSelect,
        uploadFiles,
        getTaskAttachments,
        deleteFileTaskAttachment,
        fileConfrim,
        getFilesByProjectId,
        clearTaskAttachmentStore,
    };
});
