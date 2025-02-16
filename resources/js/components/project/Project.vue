<template>
    <div>
        <!-- Form thêm dự án mới -->
        <template v-if="projectStore.clickCreate">
            <div>
                <h3 class="mt-2 mb-2 text-center">Thêm dự án mới</h3>

                <!-- Thông báo -->
                <div
                    :class="['alert', projectStore.alertType]"
                    role="alert"
                    v-if="projectStore.notification !== null"
                >
                    {{ projectStore.notification.message }}
                </div>

                <div class="form-group">
                    <label for="" class="form-lable mt-2 mb-2">Tên dự án</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="projectStore.project.name"
                    />
                </div>
                <div class="form-group">
                    <label for="" class="form-lable mt-2 mb-2">Mô tả</label>
                    <textarea
                        class="form-control"
                        v-model="projectStore.project.description"
                    ></textarea>
                </div>
                <div class="form-group">
                    <label for="" class="form-lable mt-2 mb-2"
                        >Trưởng dự án</label
                    >
                    <select
                        class="form-select"
                        v-model="projectStore.project.manager_id"
                    >
                        <option
                            v-for="manager in projectStore.listManagers
                                .managers"
                            :value="manager.id"
                        >
                            {{ manager.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="" class="form-lable mt-2 mb-2"
                        >Ngày bắt đầu</label
                    >
                    <input
                        type="date"
                        class="form-control"
                        v-model="projectStore.project.start_date"
                    />
                </div>
                <div class="form-group">
                    <label for="" class="form-lable mt-2 mb-2"
                        >Ngày kết thúc</label
                    >
                    <input
                        type="date"
                        class="form-control"
                        v-model="projectStore.project.end_date"
                    />
                </div>
                <div class="form-group text-center mt-2 mb-2">
                    <button
                        class="btn btn-primary me-2"
                        :disabled="!projectStore.isValidated"
                        @click="projectStore.createProject"
                    >
                        Thêm dự án
                    </button>
                    <button
                        class="btn btn-danger"
                        @click="projectStore.closeForm"
                    >
                        Thoát
                    </button>
                </div>
            </div>
        </template>

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
                            @click="projectStore.viewDetailProject(project.id)"
                        >
                            Chi tiết
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
    </div>
</template>

<script setup>
import { useProjectStore } from "../../stores/projectStore";
import { onMounted } from "vue";

const projectStore = useProjectStore();

onMounted(() => {
    projectStore.getListProjects();
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
