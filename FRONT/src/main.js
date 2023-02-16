import {
    createApp,
    useAttrs
} from 'vue'
import App from './App.vue'
import './index.css'
import router from '@/router'
import store from './store/store'
import VueCookies from 'vue-cookies'
//import cors from 'cors'
const app = createApp(App)
app.use(store)
app.use(VueCookies)
app.provide('cookies', app.config.globalProperties.$cookies)
app.use(router).mount('#app')
//var cors = require('cors')

