<template>
    <div>
        <h3 class="mt-2 mb-2 text-center">Danh sách dự án</h3>
        <button
            class="btn btn-success mt-2 mb-2"
            v-if="
                !projectStore.clickCreate && authStore.user.role === 'manager'
            "
            @click="projectStore.clickCreate = true"
        >
            Thêm dự án mới
        </button>

        <!-- Danh sách dự án -->
        <div
            class="accordion mt-2"
            id="accordionExample"
            v-if="
                projectStore.listProjects.data &&
                projectStore.listProjects.data.length > 0
            "
        >
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
                        <p class="project-name">{{ project.name }}</p>
                        <span class="next">></span>
                        <p :class="projectStore.getClassByStatus(project)">
                            {{ project.status }}
                        </p>
                    </button>
                </h2>
                <div
                    :id="`project-${project.id}`"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordionExample"
                >
                    <div class="accordion-body">
                        <p>{{ project.description }}</p>
                        <div v-if="authStore.user.role === 'manager'">
                            <button
                                class="btn btn-primary me-2"
                                @click="
                                    projectStore.viewDetailProject(project.id)
                                "
                            >
                                Chi tiết
                            </button>
                            <button
                                class="btn btn-danger me-2"
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
        </div>

        <!-- Thông báo chưa có dữ liệu -->
        <div class="text-center" v-else>
            <p class="alert alert-success">Chưa có dữ liệu!</p>
        </div>

        <!-- Phân trang -->
        <div class="mt-2">
            <div>
                {{ projectStore.listProjects.from }} -
                {{ projectStore.listProjects.to }} of
                {{ projectStore.listProjects.total }}
            </div>
            <ul class="pagination mt-2 mb-2">
                <li
                    class="page-item"
                    :class="{
                        disabled:
                            projectStore.listProjects.prev_page_url === null,
                    }"
                    @click="
                        projectStore.listProjects.prev_page_url &&
                            projectStore.getListProjects(
                                authStore.user,
                                projectStore.listProjects.current_page - 1
                            )
                    "
                >
                    <a class="page-link"><</a>
                </li>
                <li
                    class="page-item"
                    v-if="projectStore.listProjects.prev_page_url"
                    @click="
                        projectStore.getListProjects(
                            authStore.user,
                            projectStore.listProjects.current_page - 1
                        )
                    "
                >
                    <a class="page-link">{{
                        projectStore.listProjects.current_page - 1
                    }}</a>
                </li>
                <li class="page-item active">
                    <a class="page-link">{{
                        projectStore.listProjects.current_page
                    }}</a>
                </li>
                <li
                    class="page-item"
                    v-if="projectStore.listProjects.next_page_url"
                    @click="
                        projectStore.getListProjects(
                            authStore.user,
                            projectStore.listProjects.current_page + 1
                        )
                    "
                >
                    <a class="page-link">{{
                        projectStore.listProjects.current_page + 1
                    }}</a>
                </li>
                <li
                    class="page-item"
                    :class="{
                        disabled:
                            projectStore.listProjects.next_page_url === null,
                    }"
                    @click="
                        projectStore.listProjects.next_page_url &&
                            projectStore.getListProjects(
                                authStore.user,
                                projectStore.listProjects.current_page + 1
                            )
                    "
                >
                    <a class="page-link">></a>
                </li>
            </ul>
        </div>

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

// Libary
import { onMounted } from "vue";

const authStore = useAuthStore();
const projectStore = useProjectStore();

onMounted(() => {
    projectStore.getListProjects(authStore.user);
});
</script>
