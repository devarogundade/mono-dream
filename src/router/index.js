import { createRouter, createWebHashHistory } from "vue-router";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Tickets from "../views/Tickets.vue";
import NFTs from "../views/Nfts.vue";
import Receipts from "../views/Receipts.vue";

const routes = [{
    path: "/",
    name: "Home",
    component: Home,
}, {
    path: "/login",
    name: "Login",
    component: Login,
}, {
    path: "/register",
    name: "Register",
    component: Register,
}, {
    path: "/tickets",
    name: "Tickets",
    component: Tickets,
}, {
    path: "/nfts",
    name: "Nfts",
    component: NFTs,
}, {
    path: "/receipts",
    name: "Receipts",
    component: Receipts,
}];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;