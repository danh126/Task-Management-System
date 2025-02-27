<template>
    <div class="box">
        <!-- Thay đổi mật khẩu -->
        <div v-if="authStore.click">
            <h3 class="text-center">Thay đổi mật khẩu</h3>

            <!-- Thông báo -->
            <div
                :class="['alert', authStore.alertType]"
                role="alert"
                v-if="authStore.notification !== null"
            >
                {{ authStore.notification.message }}
            </div>

            <!-- Form change password -->
            <div class="form-group">
                <label
                    >Nhập mật khẩu cũ:
                    <span class="text-danger">(*)</span></label
                >
                <input
                    type="password"
                    v-model="authStore.changePassword.old_pass"
                    class="form-control mt-2 mb-2"
                />
            </div>
            <div class="form-group">
                <label
                    >Nhập mật khẩu mới:
                    <span class="text-danger">(*)</span></label
                >
                <input
                    type="password"
                    v-model="authStore.changePassword.new_pass"
                    class="form-control mt-2 mb-2"
                />
            </div>
            <div class="form-group">
                <label
                    >Xác nhận mật khẩu mới:
                    <span class="text-danger">(*)</span></label
                >
                <input
                    type="password"
                    v-model="authStore.changePassword.confirm_pass"
                    class="form-control mt-2 mb-2"
                />
            </div>
            <div class="form-group text-center">
                <button
                    class="btn btn-primary me-2"
                    :disabled="!authStore.requiredChangePass"
                    @click="authStore.updatePassword"
                >
                    Cập nhật
                </button>
                <button
                    class="btn btn-danger"
                    @click="authStore.closeChangePass"
                >
                    Thoát
                </button>
            </div>
        </div>

        <!-- Thông tin tài khoản -->
        <div v-else>
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
                <button class="btn btn-danger" @click="authStore.click = true">
                    Đổi mật khẩu
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from "../../stores/authStore";

const authStore = useAuthStore();
</script>
