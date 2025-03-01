<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <router-link to="/spa" class="navbar-brand">
                <img
                    src="../../../public/img/logos/logo_ntd.png"
                    alt=""
                    width="40"
                />
            </router-link>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <router-link
                        to="/spa/projects"
                        class="nav-link"
                        exact-active-class="active"
                        >Dự án
                    </router-link>
                    <router-link
                        to="/spa/tasks"
                        class="nav-link"
                        exact-active-class="active"
                        >Nhiệm vụ
                    </router-link>
                    <router-link
                        to="/spa/users"
                        v-if="authStore.user.role == 'admin'"
                        class="nav-link"
                        exact-active-class="active"
                        >Quản lý tài khoản
                    </router-link>
                </div>
            </div>

            <!-- Dropdown -->
            <div class="dropdown ms-auto">
                <a
                    class="btn btn-secondary dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    {{ authStore.user.name }} - {{ authStore.user.role }}
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <router-link
                            to="/spa/users/profile"
                            class="dropdown-item"
                            exact-active-class="active"
                            >Thông tin
                        </router-link>
                    </li>
                    <li>
                        <a class="dropdown-item" @click="authStore.logout"
                            >Đăng xuất</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useAuthStore } from "../stores/authStore";

const authStore = useAuthStore();
</script>

