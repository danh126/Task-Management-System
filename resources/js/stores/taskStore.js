import axios from "axios";
import { defineStore } from "pinia";
import { ref, computed, onMounted, watch } from "vue";

import { useAuthStore } from "./authStore";
import { useEventStore } from "./eventStore";

export const useTaskStore = defineStore("taskStore", () => {
    const authStore = useAuthStore();
    const eventStore = useEventStore();

    const listTasks = ref([]);
    const listEmployees = ref(null);
    const listProjects = ref(null);
    const clickCreate = ref(false);

    const taskEdit = ref(null);

    // Thông báo
    const alertType = ref(null);
    const notification = ref(null);

    const deleteTask = ref(null);
    const indexTask = ref(null);

    const task = ref({
        title: "",
        description: "",
        priority: "",
        due_date: "",
        project_id: "",
        assignee_id: "",
    });

    const listPriority = ref([
        { id: 1, name: "low" },
        { id: 2, name: "medium" },
        { id: 3, name: "high" },
        { id: 4, name: "urgent" },
    ]);

    const listStatus = ref([
        { id: 1, name: "todo" },
        { id: 2, name: "in progress" },
        { id: 3, name: "review" },
        { id: 4, name: "done" },
    ]);

    // Hàm lấy danh sách user thuộc role employee
    const getListEmployees = async () => {
        try {
            const response = await axios.get("/employees");
            listEmployees.value = response.data.employees;
        } catch (e) {
            console.log(e.response.data);
        }
    };

    // Hàm lấy danh sách dự án theo manager
    const getListProjectsByManager = async () => {
        try {
            const response = await axios.get(
                `/projects-by-manager/${authStore.user.id}`
            );
            listProjects.value = response.data.projects;
        } catch (error) {
            console.log(error.response.data);
        }
    };

    // Hàm lấy danh sách nhiệm vụ theo manager hoặc employee
    const getListTasks = async (page = 1) => {
        try {
            if (authStore.user.role == "manager") {
                const response = await axios.get(
                    `/tasks-by-manager/${authStore.user.id}?page=${page}`
                );
                listTasks.value = response.data.tasks;

                listTasks.value.data.forEach((item) => {
                    item.isEdit = false;
                });
            } else if (authStore.user.role == "employee") {
                const response = await axios.get(
                    `/tasks-by-employee/${authStore.user.id}?page=${page}`
                );
                listTasks.value = response.data.tasks;

                listTasks.value.data.forEach((item) => {
                    item.isUpdate = false;
                });
            } else {
                const response = await axios.get(`/tasks?page=${page}`);

                listTasks.value = response.data.tasks;
            }
        } catch (error) {
            // console.log(error.response.data);
        }
    };

    // Hàm validate form
    const isFormValid = computed(() => {
        return (
            task.value.name !== "" &&
            task.value.description !== "" &&
            task.value.priority !== "" &&
            task.value.due_date !== "" &&
            task.value.project_id !== "" &&
            task.value.assignee_id !== ""
        );
    });

    // Hàm close form create
    const closeFormCreate = () => {
        clickCreate.value = false;
        task.value = {
            title: "",
            description: "",
            priority: "",
            due_date: "",
            project_id: "",
            assignee_id: "",
        };
    };

    // Hàm thêm nhiệm vụ
    const createTask = async () => {
        try {
            const response = await axios.post("/tasks", {
                title: task.value.title,
                description: task.value.description,
                priority: task.value.priority,
                due_date: task.value.due_date,
                project_id: task.value.project_id,
                assignee_id: task.value.assignee_id,
            });

            // listTasks.value.data.unshift({ ...response.data.task });

            alertType.value = "alert-success";
            notification.value = {
                message: `Thêm nhiệm vụ ${task.value.title} thành công!`,
            };

            // Clear form
            task.value = {
                title: "",
                description: "",
                priority: "",
                due_date: "",
                project_id: "",
                assignee_id: "",
            };

            setTimeout(() => {
                alertType.value = null;
                notification.value = null;
            }, 2000);
        } catch (e) {
            alertType.value = "alert-danger";
            notification.value = e.response.data;

            setTimeout(() => {
                alertType.value = null;
                notification.value = null;
            }, 2000);
        }
    };

    // Hàm xử lý class status
    const getClassByStatus = (task) => {
        return {
            todo: task.status === "todo",
            in_progress: task.status === "in progress",
            review: task.status === "review",
            completed: task.status === "done",
        };
    };

    // Hàm xử lý class Priority
    const getClassByPriority = (task) => {
        return {
            low: task.priority === "low",
            medium: task.priority === "medium",
            high: task.priority === "high",
            urgent: task.priority === "urgent",
        };
    };

    // Hàm láy task edit
    const findTask = (task) => {
        task.isEdit = true;
        taskEdit.value = { ...task };
    };

    // Hàm lấy task update status
    const findTaskStatus = (task) => {
        task.isUpdate = true;
        taskEdit.value = { ...task };
    };

    // Hàm cập nhật task
    const updateTask = async (index) => {
        try {
            await axios.put(`/tasks/${taskEdit.value.id}`, {
                title: taskEdit.value.title,
                description: taskEdit.value.description,
                priority: taskEdit.value.priority,
                due_date: taskEdit.value.due_date,
                project_id: taskEdit.value.project_id,
            });

            Object.assign(listTasks.value.data[index], {
                isEdit: false,
            });

            alertType.value = "alert-success";
            notification.value = {
                message: `Cập nhật nhiệm vụ ${taskEdit.value.title} thành công!`,
            };

            setTimeout(() => {
                alertType.value = null;
                notification.value = null;
            }, 2000);
        } catch (error) {
            alertType.value = "alert-danger";
            notification.value = error.response.data;

            setTimeout(() => {
                alertType.value = null;
                notification.value = null;
            }, 2000);
        }
    };

    // Hàm cập nhật trạng thái task
    const updateTaskStatus = async (index) => {
        try {
            await axios.post(`/update-task-status/${taskEdit.value.id}`, {
                status: taskEdit.value.status,
            });

            Object.assign(listTasks.value.data[index], {
                isUpdate: false,
            });

            alertType.value = "alert-success";
            notification.value = {
                message: `Cập nhật trạng thái nhiệm vụ ${taskEdit.value.status} thành công!`,
            };

            setTimeout(() => {
                alertType.value = null;
                notification.value = null;
            }, 2000);
        } catch (e) {
            //
        }
    };

    // Hàm close modal
    const closeModal = () => {
        deleteTask.value = null;
        indexTask.value = null;
    };

    // Hàm click delete task
    const clickDelTask = (index, task) => {
        deleteTask.value = { ...task };
        indexTask.value = index;
    };

    // Hàm xóa nhiệm vụ
    const confirmDelTask = async () => {
        try {
            await axios.delete(`/tasks/${deleteTask.value.id}`);

            deleteTask.value = null;

            // listTasks.value.data.splice(indexTask.value, 1);
            indexTask.value = null;
        } catch (error) {
            console.log(error.response.data);
        }
    };

    // Thực hiện khi DOM được tải xong
    onMounted(() => {
        // Lắng nghe sự kiện task created
        eventStore.listenToEvent("task-created", ".CreateTask", (d) => {
            listTasks.value.data.unshift(d);
        });

        // Lắng nghe sự kiện task status update
        eventStore.listenToEvent(
            "task-status-update",
            ".TaskStatusUpdate",
            (d) => {
                const task = listTasks.value.data.find((t) => t.id === d.id);

                if (!task) {
                    return;
                }

                task.status = d.status;
            }
        );

        // Lắng nghe sự kiện task updated
        eventStore.listenToEvent("task-updated", ".TaskUpdated", (d) => {
            const task = listTasks.value.data.find((t) => t.id === d.id);

            if (!task) {
                return;
            }

            task.title = d.title;
            task.description = d.description;
            task.priority = d.priority;
            task.due_date = d.due_date;
            task.project_id = d.project_id;
        });

        // Lắng nghe sự kiện task delete
        eventStore.listenToEvent("task-delete", ".DeleteTask", (d) => {
            // Lưu ý phải chuyển đổi id sang dạng Number
            listTasks.value.data = listTasks.value.data.filter(
                (task) => Number(task.id) !== Number(d.id)
            );
        });
    });

    return {
        task,
        listPriority,
        listEmployees,
        listProjects,
        isFormValid,
        getListProjectsByManager,
        createTask,
        alertType,
        notification,
        clickCreate,
        closeFormCreate,
        listTasks,
        getListTasks,
        getClassByStatus,
        getClassByPriority,
        findTask,
        taskEdit,
        updateTask,
        deleteTask,
        closeModal,
        clickDelTask,
        confirmDelTask,
        findTaskStatus,
        listStatus,
        updateTaskStatus,
        authStore,
        getListEmployees,
    };
});
