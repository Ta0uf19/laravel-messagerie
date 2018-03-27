import Vue from 'vue'
import VueRouter from 'vue-router'

import Messagerie from './components/MessagerieComponent'
import Messages from './components/MessagesComponent'
import store from './store'

Vue.use(VueRouter)

let base = document.querySelector('#messagerie').getAttribute('data-base')

const routes = [
    {path: '/'},
    {path:'/:id', component: Messages, name: 'messages'}
]
const router = new VueRouter({
    mode: 'history',
    routes,
    base
});

new Vue({
    el: '#app',
    components: { Messagerie }, // liste des composants
    store,
    router
});
