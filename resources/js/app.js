import "./bootstrap";

import { createApp } from "vue"; // thư viện vue-router
import { createPinia } from "pinia"; // thư viện pinia (store)

import App from "./components/App.vue";
import router from "./router";

const app = createApp(App);
app.use(router);
app.use(createPinia());

app.mount("#app");
