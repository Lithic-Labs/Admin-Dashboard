

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import "@/assets/css/bootstrap.min.css";
import "@/assets/css/plugins.min.css";
import "@/assets/css/kaiadmin.min.css";
import "@/assets/css/demo.css";







const app = createApp(App);

app.use(router);

app.mount('#app');
