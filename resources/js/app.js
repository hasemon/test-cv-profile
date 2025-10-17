import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueCompositionAPI from '@vue/composition-api'
import App from './App.vue'
import router from './router'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

Vue.use(BootstrapVue)
Vue.use(VueCompositionAPI)
Vue.use(Toast, {
    // optional options
    position: "top-right",
    timeout: 3000,
    closeOnClick: true,
    pauseOnHover: true,
});

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')
