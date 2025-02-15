import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { useRouter } from "vue-router";

export const useProjectStore = defineStore("projectStore", () => {
    const listProjects = ref([]);
    const clickDetail = ref(false);
    // Lấy dữ liệu từ localStorage nếu có
    const detailProject = ref(
        JSON.parse(localStorage.getItem("detailProject")) || null
    );
    const router = useRouter();
    const clickUpdate = ref(false);

    // Thông báo
    const alertType = ref(null);
    const notification = ref(null);

    const statusProject = ref([
        { id: 1, name: "pending" },
        { id: 2, name: "in_progress" },
        { id: 3, name: "done" },
    ]);

    const editProject = ref(null);

    // Hàm lấy danh sách dự án
    const getListProjects = async (page = 1) => {
        try {
            const response = await axios.get(`/projects?page=${page}`);
            listProjects.value = response.data;
        } catch (error) {
            console.log(error);
        }
    };

    // Hàm xử lý class status
    const getClassByStatus = (project) => {
        return {
            pending: project.status === "pending",
            in_progress: project.status === "in_progress",
            completed: project.status === "done",
        };
    };

    // Hàm tìm và lưu dụ án theo ID
    const setProject = (id) => {
        detailProject.value =
            { ...listProjects.value.data.find((p) => p.id === id) } || null;

        // Lưu vào localStorage khi thay đổi
        localStorage.setItem(
            "detailProject",
            JSON.stringify(detailProject.value)
        );
    };

    // Hàm xem chi tiết dự án
    const viewDetailProject = (id) => {
        setProject(id);
        router.push(`/spa/projects/${id}`);
    };

    // Hàm xử lý thay đổi thông tin dự án
    const changeProject = () => {
        clickUpdate.value = true;
        editProject.value = { ...detailProject.value };
    };

    // Hàm xử lý cập nhật thông tin dự án
    const updateProject = async () => {
        try {
            const response = await axios.put(
                "/projects/" + editProject.value.id,
                {
                    name: editProject.value.name,
                    description: editProject.value.description,
                    status: editProject.value.status,
                    start_date: editProject.value.start_date,
                    end_date: editProject.value.end_date,
                }
            );

            // Cập nhật lại thông tin chi tiết
            Object.assign(detailProject.value, {
                name: response.data.project.name,
                description: response.data.project.description,
                status: response.data.project.status,
                start_date: response.data.project.start_date,
                end_date: response.data.project.end_date,
            });

            // Cập nhật localStorage
            localStorage.setItem(
                "detailProject",
                JSON.stringify(detailProject.value)
            );

            alertType.value = "alert-success";
            notification.value = {
                message: "Cập nhật thông tin dự án thành công!",
            };

            setTimeout(() => {
                notification.value = null;
            }, 2000);

            clickUpdate.value = false;
        } catch (error) {
            alertType.value = "alert-danger";
            notification.value = error.response.data;

            setTimeout(() => {
                notification.value = null;
            }, 2000);
        }
    };

    return {
        listProjects,
        getListProjects,
        getClassByStatus,
        clickDetail,
        detailProject,
        viewDetailProject,
        clickUpdate,
        statusProject,
        changeProject,
        editProject,
        updateProject,
        notification,
        alertType,
    };
});
