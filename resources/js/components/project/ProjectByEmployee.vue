<template>
    <div>
        <h3 class="mt-2 mb-2 text-center">Danh sách dự án</h3>

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
                        <p><b>Mô tả: </b>{{ project.description }}</p>
                        <p><b>Trưởng dự án: </b> {{ project.manager.name }}</p>
                        <p>
                            <b>Email liên hệ: </b> {{ project.manager.email }}
                        </p>
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
                    <a class="page-link" href="#"><</a>
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
                            authStore.user,
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
                    <a class="page-link" href="#">></a>
                </li>
            </ul>
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
