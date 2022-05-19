import { createRouter, createWebHistory } from 'vue-router'
import RegisterComponent from '../components/RegisterComponent.vue'
import LoginComponents from '../components/LoginComponents.vue'
import Home from '../components/Home.vue'


const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: LoginComponents
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterComponent
    },

]

export default createRouter({
    history: createWebHistory(),
    routes
})