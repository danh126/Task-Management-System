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

<style scoped>
/* ======= Navbar Styles ======= */
.navbar {
    background: #ffffff;
    padding: 10px 20px;
    width: 100%;
}

/* Logo */
.navbar-brand img {
    transition: transform 0.3s ease-in-out;
}

.navbar-brand img:hover {
    transform: scale(1.1);
}

/* Navbar Links */
.navbar-nav .nav-link {
    font-weight: 500;
    color: #333;
    padding: 10px 15px;
    transition: color 0.3s ease-in-out;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
    color: #3f7a7d;
    border-bottom: 2px solid #3f7a7d;
}

/* ======= Dropdown Styles ======= */
.dropdown .btn {
    background: #3f7a7d;
    color: #fff;
    border: none;
    padding: 8px 12px;
    transition: background 0.3s ease-in-out;
}

.dropdown .btn:hover {
    background: #383737;
}

.dropdown-menu {
    border-radius: 8px;
    border: none;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.dropdown-item {
    padding: 8px 15px;
    transition: background 0.3s ease-in-out;
}

.dropdown-item:hover {
    background: #f0f0f0;
}

/* ======= Mobile Styles ======= */
@media (max-width: 991px) {
    .navbar-nav {
        text-align: center;
        background: #fff;
        border-radius: 5px;
        padding: 10px;
    }

    .dropdown {
        margin-top: 10px;
    }
}
</style>
