<template>
    <div class="box">
        <h3 class="text-center">Thông tin tài khoản</h3>
        <div class="form-group box">
            <label for=""
                >Tên tài khoản: <b>{{ authStore.user.name }}</b></label
            >
        </div>
        <div class="form-group box">
            <label for=""
                >Email: <b>{{ authStore.user.email }}</b></label
            >
        </div>
        <div class="form-group box">
            <label for=""
                >Vai trò: <b>{{ authStore.user.role }}</b></label
            >
        </div>

        <div class="text-center">
            <button class="mt-2 mb-2 me-2 btn btn-primary">
                Cập nhật thông tin
            </button>
            <button class="btn btn-danger">Đổi mật khẩu</button>
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from "../../stores/authStore";

const authStore = useAuthStore();
</script>

<style scoped>
.box {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    border-radius: 8px;
    background-color: #f8f9fa;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h3.text-center {
    text-align: center;
    color: #333;
    margin-bottom: 15px;
}

.form-group {
    margin-bottom: 10px;
}

.form-group label {
    font-size: 16px;
    color: #555;
    display: block;
}

b {
    color: #000;
}

button {
    padding: 8px 15px;
    font-size: 14px;
    border-radius: 5px;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
}

button:hover {
    opacity: 0.9;
}
</style>
