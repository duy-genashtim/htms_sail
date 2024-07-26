import './bootstrap';
// import '../css/app.css'; 
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import {appName} from './config/constants.js';
import { createApp } from 'vue';
import { createPinia } from 'pinia'
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import Routes from './routes.js';
import {Select, Switch, TreeSelect, Table, Transfer} from 'ant-design-vue';

import 'ant-design-vue/dist/reset.css';

const pinia = createPinia();
const app = createApp(App);

const router = createRouter({
    history: createWebHistory(),
    routes: Routes
});

router.beforeEach((to, from)=>{
    document.title = to.meta?.title? to.meta.title + " || " + appName : appName;
});
app.use(Select);
app.use(Switch);
app.use(TreeSelect);
app.use(Table);
app.use(Transfer);
app.use(pinia);
app.use(router);
app.mount("#app");