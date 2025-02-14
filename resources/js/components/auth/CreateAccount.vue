<template>
    <div>
        <h3 class="text-center">Tạo tài khoản mới</h3>

        <div
            :class="['alert', authStore.alertType]"
            role="alert"
            v-if="authStore.notification !== null"
        >
            {{ authStore.notification.message }}
        </div>

        <label for="name">Tên tài khoản</label>
        <input
            type="text"
            class="form-control mt-2 mb-2"
            v-model="authStore.account.name"
        />
        <label for="name">Email</label>
        <input
            type="email"
            class="form-control mt-2 mb-2"
            v-model="authStore.account.email"
        />
        <label for="name">Vai trò</label>
        <select class="form-select" v-model="authStore.account.role">
            <option
                v-for="role in authStore.listRoles"
                :key="role.name"
                :value="role.name"
            >
                {{ role.name }}
            </option>
        </select>
        <div class="text-center">
            <button
                class="btn btn-primary mt-2 me-2"
                :disabled="!authStore.isFormValid"
                @click="authStore.createAccount"
            >
                Tạo tài khoản
            </button>
            <button
                class="btn btn-danger mt-2"
                @click="authStore.closeCreateAccount"
            >
                Thoát
            </button>
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from "../../stores/authStore";

const authStore = useAuthStore();
</script>
