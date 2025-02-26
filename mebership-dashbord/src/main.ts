import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index.ts'
import vuetify from './plugins/vuetify'
import axios from './axios';
import { loadFonts } from './plugins/webfontloader'

loadFonts()

const app = createApp(App);
app.config.globalProperties.$axios = axios;


app.use(vuetify)
app.use(router)
app.mount('#app')
