import { createApp } from 'vue'
import { createPinia } from 'pinia'
import HeaderLogin from './components/HeaderLogin.vue'
import FamilyShow from './components/FamilyShow.vue'
import Login from './components/Login.vue'
import axios from 'axios'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content')
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

const app = createApp({})
const pinia = createPinia()
app.use(pinia)

app.component('HeaderLogin', HeaderLogin)
app.component('FamilyShow', FamilyShow)
app.component('Login', Login)

app.provide('$axios', axios)
//test
app.mount('#app')
