import { createApp } from 'vue'
import App from './App.vue'
import Router from './routes/routes.ts'
import VueAxios from 'vue-axios'
import axios from 'axios'
import 'bootstrap/dist/css/bootstrap.css'

const app = createApp(App)
app.use(VueAxios, axios)
app.use(Router)
app.mount('#app')

import 'bootstrap/dist/js/bootstrap'
