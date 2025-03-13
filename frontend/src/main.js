import { createApp } from 'vue';
import App from './App.vue';
import router from './router';  // ✅ Import Vue Router

const app = createApp(App);
app.use(router);  // ✅ Active Vue Router
app.mount('#app');
