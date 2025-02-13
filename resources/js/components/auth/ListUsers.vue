<template>
    <div>
        <CreateAccount
            v-if="createAccount"
            :createAccount="createAccount"
            :listRoles="listRoles"
            @update-createAccount="updateCreateAccount"
        />

        <h3 class="mt-2 mb-2 text-center">Danh sách người dùng</h3>
        <button
            class="btn btn-success mb-2"
            v-if="!createAccount"
            @click="createAccount = true"
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
                <tr v-for="(user, index) in listUsers" :key="user?.id">
                    <td scope="row">{{ user?.id }}</td>

                    <td>{{ user?.name }}</td>
                    <td>{{ user?.email }}</td>

                    <td v-if="!user.isEdit">{{ user?.role }}</td>
                    <td v-else>
                        <select class="form-select" v-model="selectedUser.role">
                            <option
                                v-for="role in listRoles"
                                :value="role.name"
                                :key="role.name"
                            >
                                {{ role.name }}
                            </option>
                        </select>
                    </td>

                    <!-- Button thực hiện tác vụ -->
                    <td v-if="!user.isEdit && !createAccount">
                        <buttonn
                            class="btn btn-primary me-2"
                            @click="findUser(user)"
                            >Phân quyền
                        </buttonn>
                        <button class="btn btn-danger">Xóa</button>
                    </td>

                    <td v-else-if="!createAccount">
                        <button
                            class="btn btn-primary me-2"
                            @click="updateRole(index)"
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
import { ref, onMounted } from "vue";
import CreateAccount from "./CreateAccount.vue";
import axios from "axios";

const listRoles = ref([
    { name: "admin" },
    { name: "manager" },
    { name: "employee" },
]);

const listUsers = ref([]);
const selectedUser = ref(null);
const createAccount = ref(false);

onMounted(async () => {
    try {
        const response = await axios.get("/users");
        listUsers.value = response.data;

        listUsers.value.forEach((item) => {
            item.isEdit = false;
        });
    } catch (error) {
        console.log(error);
    }
});

// Lấy user được chọn
const findUser = (user) => {
    user.isEdit = true;
    selectedUser.value = { ...user };
};

// Hàm nhận sự kiện update từ component con
const updateCreateAccount = (value) => {
    createAccount.value = value;
};

// Hàm update role
const updateRole = async (index) => {
    try {
        const response = await axios.put("/users/" + selectedUser.value.id, {
            role: selectedUser.value.role,
        });

        // Cập nhật lại listUsers ở row vừa update
        Object.assign(listUsers.value[index], {
            role: response.data.user.role,
            isEdit: false,
        });
    } catch (error) {
        // console.log(error);
    }
};
</script>
<style lang="scss" scoped></style>
