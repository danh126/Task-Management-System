<template>
    <!-- Form create project -->
    <CreateProject v-if="projectStore.clickCreate" />
    <div>
        <!-- Danh sách dự án -->
        <h3 class="mt-2 mb-2 text-center">Danh sách dự án</h3>
        <button
            class="btn btn-success mt-2 mb-2"
            v-if="!projectStore.clickCreate"
            @click="projectStore.clickCreate = true"
        >
            Thêm dự án mới
        </button>

        <div class="accordion" id="accordionExample">
            <div
                class="accordion-item"
                v-for="(project, index) in projectStore.listProjects.data"
                :key="project.id"
            >
                <h2 class="accordion-header">
                    <button
                        class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        :data-bs-target="`#project-${project.id}`"
                        aria-expanded="true"
                        :aria-controls="`project-${project.id}`"
                    >
                        {{ project.name }} >
                        <span :class="projectStore.getClassByStatus(project)">{{
                            project.status
                        }}</span>
                    </button>
                </h2>
                <div
                    :id="`project-${project.id}`"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordionExample"
                >
                    <div class="accordion-body">
                        <p>{{ project.description }}</p>
                        <button
                            class="btn btn-primary me-2"
                            :disabled="
                                !(authStore.user.id === project.manager_id)
                            "
                            @click="projectStore.viewDetailProject(project.id)"
                        >
                            Chi tiết
                        </button>
                        <button
                            class="btn btn-danger me-2"
                            :disabled="
                                !(authStore.user.id === project.manager_id)
                            "
                            @click="
                                projectStore.clickDelProject(index, project)
                            "
                        >
                            Xóa dự án
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phân trang -->
        <div>
            {{ projectStore.listProjects.from }} -
            {{ projectStore.listProjects.to }} of
            {{ projectStore.listProjects.total }}
        </div>
        <ul class="pagination mt-2 mb-2">
            <li
                class="page-item"
                :class="{
                    disabled: projectStore.listProjects.prev_page_url === null,
                }"
                @click="
                    projectStore.listProjects.prev_page_url &&
                        projectStore.getListProjects(
                            projectStore.listProjects.current_page - 1
                        )
                "
            >
                <a class="page-link" href="#"><</a>
            </li>
            <li
                class="page-item"
                v-if="projectStore.listProjects.prev_page_url"
                @click="
                    projectStore.getListProjects(
                        projectStore.listProjects.current_page - 1
                    )
                "
            >
                <a class="page-link" href="#">{{
                    projectStore.listProjects.current_page - 1
                }}</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#">{{
                    projectStore.listProjects.current_page
                }}</a>
            </li>
            <li
                class="page-item"
                v-if="projectStore.listProjects.next_page_url"
                @click="
                    projectStore.getListProjects(
                        projectStore.listProjects.current_page + 1
                    )
                "
            >
                <a class="page-link" href="#">{{
                    projectStore.listProjects.current_page + 1
                }}</a>
            </li>
            <li
                class="page-item"
                :class="{
                    disabled: projectStore.listProjects.next_page_url === null,
                }"
                @click="
                    projectStore.listProjects.next_page_url &&
                        projectStore.getListProjects(
                            projectStore.listProjects.current_page + 1
                        )
                "
            >
                <a class="page-link" href="#">></a>
            </li>
        </ul>

        <!-- Modal xóa dự án -->
        <div v-if="projectStore.deleteProject !== null">
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
                                Bạn có chắc chắn xóa dự án?
                            </h1>
                            <button
                                type="button"
                                class="btn-close"
                                @click="projectStore.closeModal"
                            ></button>
                        </div>
                        <div class="modal-body text-center">
                            {{ projectStore.deleteProject.name }}
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="projectStore.closeModal"
                            >
                                Hủy
                            </button>
                            <button
                                class="btn btn-danger"
                                @click="projectStore.confirmDelProject"
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
// Stores
import { useProjectStore } from "../../stores/projectStore";
import { useAuthStore } from "../../stores/authStore";

// Components
import CreateProject from "./CreateProject.vue";

// Libary
import { onMounted } from "vue";
import { onBeforeRouteLeave } from "vue-router";

const authStore = useAuthStore();
const projectStore = useProjectStore();

onMounted(() => {
    projectStore.getListProjects();
});

onBeforeRouteLeave(() => {
    projectStore.closeForm();
});
</script>

<style scoped>
.accordion-button {
    background-color: white !important;
    color: black !important;
}

.pending {
    background-color: #fff3cd;
    color: rgb(0, 0, 0);
    margin-left: 5px;
    margin-top: 5px;
    text-align: center;
    height: 25px;
    width: 80px;
}

.in_progress {
    background-color: #cce5ff;
    color: rgb(0, 0, 0);
    margin-left: 5px;
    margin-top: 5px;
    text-align: center;
    height: 25px;
    width: 90px;
}

.completed {
    background-color: #d4edda;
    color: rgb(0, 0, 0);
    margin-left: 5px;
    margin-top: 5px;
    text-align: center;
    height: 25px;
    width: 80px;
}
</style>
