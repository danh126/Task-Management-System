<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">Navbar</a>
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
                        to="/spa/home"
                        class="nav-link"
                        exact-active-class="active"
                        aria-current="page"
                        >Trang chủ
                    </router-link>
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
                        v-if="user?.role == 'admin'"
                        class="nav-link"
                        exact-active-class="active"
                        >Quản lý tài khoản
                    </router-link>
                </div>
            </div>

            <!-- Dropdown -->
            <div class="dropdown">
                <a
                    class="btn btn-secondary dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    {{ user?.name }} - {{ user?.role }}
                </a>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Thông tin</a></li>
                    <li>
                        <a class="dropdown-item" @click="logout">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

import { useRouter } from "vue-router";

const user = ref(JSON.parse(localStorage.getItem("user")) || null);

const logout = async () => {
    try {
        await axios.post("/logout");
        window.location.href = "/";
    } catch (error) {
        console.error(error);
    }
};

// console.log(user.value.name);
</script>

<style scoped>
.active {
    font-weight: bold;
}
</style>
