import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import Mono from "vue-mono";

createApp(App)
    .use(Mono, { publicKey: "live_pk_hZnPMtHhGuVL6gc6LuzG" })
    .use(router)
    .mount("#app");