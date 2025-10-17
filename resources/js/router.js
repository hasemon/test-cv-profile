import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './pages/Dashboard.vue'
import ProfilePage from './pages/ProfilePage.vue'
import ProfileCreate from './pages/ProfileCreate.vue'
import ProfileEdit from './pages/ProfileEdit.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/', component: Dashboard, name: 'profile.dashboard' },
    { path: '/profile', component: ProfilePage, name: 'profile.page' },
    { path: "/edit/:id?", name: "profile.edit", component: ProfileEdit },
    { path: "/create", name: "profile.create", component: ProfileCreate }
]

const router = new VueRouter({
    mode: 'history',
    routes,
})

export default router
