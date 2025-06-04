import { createApp } from 'vue'
import './style.css'
import axios from 'axios'
import App from './App.vue'

axios.defaults.baseURL = 'http://127.0.0.1:8000'
axios.defaults.headers.common['Authorization'] = 'Bearer token'
createApp(App).mount('#app')
