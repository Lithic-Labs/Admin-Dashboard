import { createApp } from 'vue'
import App from './App.vue'


import router from './router'

import "@/assets/css/bootstrap.min.css";
import "@/assets/css/plugins.min.css";
import "@/assets/css/kaiadmin.min.css";
import "@/assets/css/demo.css";
import "@/assets/css/templates.css";

import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';
library.add(fas,far,fab);

const app = createApp(App)

app.component("font-awesome-icon", FontAwesomeIcon);

app.use(router)

app.mount('#app')
