import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import Mono from "vue-mono";

createApp(App)
    .use(Mono, { publicKey: "test_pk_7ybniNi3ipmSNMK8zQiU" })
    .use(router)
    .mount("#app");