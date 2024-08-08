// Importações
import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; 

import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';


import './assets/css/tailwind_vue/index.css';


const app = createApp(App);
app.use(router);
app.mount('#app');

