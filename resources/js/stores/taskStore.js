import axios from "axios";
import { defineStore } from "pinia";
import { ref, computed, watch } from "vue";

import { useAuthStore } from "./authStore";
import { useEventStore } from "./eventStore";

import { useRouter } from "vue-router";

export const useTaskStore = defineStore("taskStore", () => {
    const authStore = useAuthStore();
    const eventStore = useEventStore();
    const router = useRouter();

    const listTasks = ref([]);
    const listEmployees = ref(null);
    const listProjects = ref(null);
    const clickCreate = ref(false);

    const taskEdit = ref(null);

    const taskDetail = ref(
        JSON.parse(localStorage.getItem("task-detail")) || null
    );

    // Theo dõi giá trị thay đổi
    watch(taskDetail, (newValue) => {
        localStorage.setItem("task-detail", JSON.stringify(newValue));
    });

    // Thông báo
    const alertType = ref(null);
    const notification = ref(null);

    const deleteTask = ref(null);
    const indexTask = ref(null);

    const task = ref({
        title: "",
        description: "",
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

    const listStatus = ref({
        todo: "Việc cần làm",
        in_progress: "Đang thực hiện",
        review: "Đánh giá",
        done: "Hoàn thành",
    });

    const taskLists = ref({
        todo: [],
        in_progress: [],
        review: [],
        done: [],
    });

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
                    `/tasks-by-employee/${authStore.user.id}`
                );
                listTasks.value = response.data.tasks;

                listTasks.value.forEach((item) => {
                    taskLists.value[item.status].push(item);
                    // item.isUpdate = false;
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
                due_date: task.value.due_date,
                project_id: task.value.project_id,
                assignee_id: task.value.assignee_id,
            });

            // listTasks.value.data.unshift(response.data);

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
    const getClassByStatus = (status) => {
        return {
            todo: status === "todo",
            in_progress: status === "in_progress",
            review: status === "review",
            completed: status === "done",
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
            const response = await axios.put(`/tasks/${taskEdit.value.id}`, {
                title: taskEdit.value.title,
                description: taskEdit.value.description,
                due_date: taskEdit.value.due_date,
                project_id: taskEdit.value.project_id,
            });

            Object.assign(listTasks.value.data[index], {
                title: response.data.task.title,
                description: response.data.task.description,
                due_date: response.data.task.due_date,
                project_id: response.data.task.project_id,
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
    const updateTaskStatus = async (event) => {
        try {
            // Lấy dữ liệu gốc của phần tử kéo
            const task = event.item._underlying_vm_ || event.clone;

            // Xác định status của cột dược kéo đến
            const newStatus = event.to.getAttribute("data-status");

            if (task.status !== newStatus) {
                task.status = newStatus;

                // Gọi đến back-end update status
                await axios.post(`/update-task-status/${task.id}`, {
                    status: newStatus,
                });
            }
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

            listTasks.value.data.splice(indexTask.value, 1);
            indexTask.value = null;
        } catch (error) {
            console.log(error.response.data);
        }
    };

    // Hàm clear store task
    const clearTaskStore = () => {
        listTasks.value = [];
        taskLists.value = {
            todo: [],
            in_progress: [],
            review: [],
            done: [],
        };
    };

    // Hàm lưu data task detail
    const setTaskDetail = (id, status) => {
        if (authStore.user.role === "employee") {
            taskDetail.value = {
                ...taskLists.value[status].find(
                    (t) => Number(t.id) === Number(id)
                ),
            };
        } else {
            taskDetail.value = listTasks.value.data.find(
                (t) => Number(t.id) === Number(id)
            );
        }

        localStorage.setItem("task-details", JSON.stringify(taskDetail.value));
    };

    // Hàm click task detail
    const clickTaskDetail = (id, status) => {
        setTaskDetail(id, status);

        router.push(`/spa/tasks/${id}`);
    };

    return {
        eventStore,
        task,
        listPriority,
        listEmployees,
        listProjects,
        isFormValid,
        alertType,
        notification,
        clickCreate,
        listTasks,
        taskDetail,
        taskEdit,
        deleteTask,
        listStatus,
        authStore,
        taskLists,
        updateTaskStatus,
        getListEmployees,
        updateTask,
        closeModal,
        clickDelTask,
        confirmDelTask,
        findTaskStatus,
        getListTasks,
        getClassByStatus,
        getClassByPriority,
        findTask,
        closeFormCreate,
        clearTaskStore,
        clickTaskDetail,
        getListProjectsByManager,
        createTask,
    };
});
