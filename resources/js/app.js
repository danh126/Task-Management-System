import "./bootstrap";

// import Alpine from "alpinejs";
import { createApp } from "vue";
import App from "./components/App.vue";
import router from "./router";

// window.Alpine = Alpine;

// Alpine.start();

const app = createApp(App);
app.use(router);

app.mount("#app");
