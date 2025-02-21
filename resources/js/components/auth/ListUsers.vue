<template>
    <div>
        <CreateAccount v-if="authStore.clickCreateAccount" />

        <h3 class="mt-2 mb-2 text-center">Danh sách người dùng</h3>
        <button
            class="btn btn-success mb-2"
            v-if="!authStore.clickCreateAccount"
            @click="authStore.clickCreateAccount = true"
        >
            Tạo tài khoản
        </button>

        <!-- Tìm kiếm tài khoản-->
        <!-- <div>
            <input
                type="text"
                placeholder="Tìm kiếm tài khoản..."
                class="form-control mt-2 mb-2"
                v-if="!authStore.clickCreateAccount"
                v-model="authStore.txtSearch"
            />
        </div> -->

        <!-- Danh sách tài khoản -->
        <table
            class="table"
            v-if="
                authStore.listUsers.data && authStore.listUsers.data.length > 0
            "
        >
            <thead class="table-success">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên tài khoản</th>
                    <th scope="col">Email</th>
                    <th scope="col">Vai trò</th>
                    <th scope="col" v-if="!authStore.clickCreateAccount">
                        Tác vụ
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(user, index) in authStore.listUsers.data"
                    :key="user?.id"
                >
                    <td scope="row">{{ user?.id }}</td>

                    <td>{{ user?.name }}</td>
                    <td>{{ user?.email }}</td>

                    <td v-if="!user.isEdit">{{ user?.role }}</td>
                    <td v-else>
                        <select
                            class="form-select"
                            v-model="authStore.selectedUser.role"
                        >
                            <option
                                v-for="role in authStore.listRoles"
                                :value="role.name"
                                :key="role.name"
                            >
                                {{ role.name }}
                            </option>
                        </select>
                    </td>

                    <!-- Button thực hiện tác vụ -->
                    <td v-if="!user.isEdit && !authStore.clickCreateAccount">
                        <buttonn
                            class="btn btn-primary me-2"
                            @click="authStore.findUser(user)"
                            >Phân quyền
                        </buttonn>
                        <button
                            class="btn btn-danger"
                            @click="authStore.clickDeleteUser(user, index)"
                        >
                            Xóa
                        </button>
                    </td>

                    <td v-else-if="!authStore.clickCreateAccount">
                        <button
                            class="btn btn-primary me-2"
                            @click="authStore.updateRole(index)"
                        >
                            Cập nhật
                        </button>
                        <button
                            class="btn btn-danger"
                            @click="user.isEdit = false"
                        >
                            Thoát
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Thông báo chưa có dữ liệu -->
        <div class="text-center" v-else>
            <p class="alert alert-success">Chưa có dữ liệu!</p>
        </div>

        <!-- Modal xóa tài khoản -->
        <div v-if="authStore.deleteUser !== null">
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
                                Bạn có chắc chắn xóa tài khoản?
                            </h1>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                                @click="authStore.closeModal"
                            ></button>
                        </div>
                        <div class="modal-body text-center">
                            {{ authStore.deleteUser.name }}
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                                @click="authStore.closeModal"
                            >
                                Hủy
                            </button>
                            <button
                                class="btn btn-danger"
                                @click="authStore.confirmDelUser"
                            >
                                Xóa tài khoản
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
            <!-- Thêm backdrop -->
        </div>

        <!-- Phân trang -->
        <div class="mt-2">
            <div>
                {{ authStore.listUsers.from }} - {{ authStore.listUsers.to }} of
                {{ authStore.listUsers.total }}
            </div>
            <ul class="pagination mt-2 mb-2">
                <li
                    class="page-item"
                    :class="{
                        disabled: authStore.listUsers.prev_page_url === null,
                    }"
                    @click="
                        authStore.listUsers.prev_page_url &&
                            authStore.getListUsers(
                                authStore.listUsers.current_page - 1
                            )
                    "
                >
                    <a class="page-link" href="#"><</a>
                </li>
                <li
                    class="page-item"
                    v-if="authStore.listUsers.prev_page_url"
                    @click="
                        authStore.getListUsers(
                            authStore.listUsers.current_page - 1
                        )
                    "
                >
                    <a class="page-link" href="#">{{
                        authStore.listUsers.current_page - 1
                    }}</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">{{
                        authStore.listUsers.current_page
                    }}</a>
                </li>
                <li
                    class="page-item"
                    v-if="authStore.listUsers.next_page_url"
                    @click="
                        authStore.getListUsers(
                            authStore.listUsers.current_page + 1
                        )
                    "
                >
                    <a class="page-link" href="#">{{
                        authStore.listUsers.current_page + 1
                    }}</a>
                </li>
                <li
                    class="page-item"
                    :class="{
                        disabled: authStore.listUsers.next_page_url === null,
                    }"
                    @click="
                        authStore.listUsers.next_page_url &&
                            authStore.getListUsers(
                                authStore.listUsers.current_page + 1
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
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import CreateAccount from "./CreateAccount.vue";

const authStore = useAuthStore();

onMounted(() => {
    authStore.getListUsers();
});
</script>
