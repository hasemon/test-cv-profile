import Vue from 'vue'
import VueRouter from 'vue-router'
import ProfileList from './pages/ProfileList.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/', component: ProfileList, name: 'profile.list' },
]

const router = new VueRouter({
    mode: 'history',
    routes,
})

export default router
