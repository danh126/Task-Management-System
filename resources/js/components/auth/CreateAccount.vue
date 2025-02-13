<template>
    <div>
        <h3 class="text-center">Tạo tài khoản mới</h3>
        <label for="name">Tên tài khoản</label>
        <input
            type="text"
            class="form-control mt-2 mb-2"
            v-model="account.name"
        />
        <label for="name">Email</label>
        <input
            type="email"
            class="form-control mt-2 mb-2"
            v-model="account.email"
        />
        <label for="name">Vai trò</label>
        <select class="form-select" v-model="account.role">
            <option
                v-for="role in props.listRoles"
                :key="role.name"
                :value="role.name"
            >
                {{ role.name }}
            </option>
        </select>
        <div class="text-center">
            <button class="btn btn-primary mt-2 me-2" @click="create">
                Tạo tài khoản
            </button>
            <button class="btn btn-danger mt-2" @click="closeCreateAccount">
                Thoát
            </button>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";

const account = ref({
    name: "",
    email: "",
    role: "",
});

// Định nghĩa prop nhận dược từ component cha
const props = defineProps({
    createAccount: Boolean,
    listRoles: Array,
});

const emit = defineEmits(["update-createAccount"]); // định nghĩa emit

// Hàm close form create account
const closeCreateAccount = () => {
    // Thay đổi giá trị ở component cha
    emit("update-createAccount", !props.createAccount);

    // Clear form
    account.value = {
        name: "",
        email: "",
        role: "",
    };
};

// Hàm tạo tài khoản
const create = async () => {
    try {
        //
    } catch (error) {
        //
    }
};
</script>
