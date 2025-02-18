<template>
    <Navbar />
    <div class="container body-content">
        <router-view />
    </div>
    <Footer></Footer>
</template>

<script setup>
// Css
import "../../css/app.css";

import Navbar from "./Navbar.vue";
import Footer from "./Footer.vue";
</script>
