<template>
    <Navbar />
    <div class="container body-content">
        <router-view />
    </div>
    <Footer></Footer>
</template>

<script setup>
import Navbar from "./Navbar.vue";
import Footer from "./Footer.vue";
</script>

<style scoped>
.body-content {
    padding-bottom: 60px;
}
</style>
