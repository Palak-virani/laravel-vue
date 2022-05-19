require("./bootstrap");
import { createApp } from "vue";
import router from "./router/index.js";
import Home from "./components/Home.vue";

createApp({
    components: {
        Home
    }
}).use(router).mount("#app");

