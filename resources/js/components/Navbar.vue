<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
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
                        to="/home"
                        class="nav-link active"
                        aria-current="page"
                        >Trang chủ</router-link
                    >
                    <a class="nav-link" href="#">Dự án</a>
                    <a class="nav-link" href="#">Nhiệm vụ</a>
                </div>
            </div>
            <div>
                <button @click="logout">Đăng xuất</button>
            </div>
        </div>
    </nav>
</template>

<script setup>
import axios from "axios";
import { useRouter } from "vue-router";

const logout = async () => {
    try {
        await axios.post("/logout");
        router.push("/login");
    } catch (error) {
        console.error(error);
    }
};
</script>

<style lang="scss" scoped></style>
