<template>
    <div>
        <CreateAccount v-if="authStore.createAccount" />

        <h3 class="mt-2 mb-2 text-center">Danh sách người dùng</h3>
        <button
            class="btn btn-success mb-2"
            v-if="!authStore.createAccount"
            @click="authStore.createAccount = true"
        >
            Tạo tài khoản
        </button>

        <!-- Danh sách tài khoản -->
        <table class="table">
            <thead class="table-success">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên tài khoản</th>
                    <th scope="col">Email</th>
                    <th scope="col">Vai trò</th>
                    <th scope="col" v-if="!createAccount">Tác vụ</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(user, index) in authStore.listUsers"
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
                    <td v-if="!user.isEdit && !authStore.createAccount">
                        <buttonn
                            class="btn btn-primary me-2"
                            @click="authStore.findUser(user)"
                            >Phân quyền
                        </buttonn>
                        <button class="btn btn-danger">Xóa</button>
                    </td>

                    <td v-else-if="!authStore.createAccount">
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

<style lang="scss" scoped></style>
