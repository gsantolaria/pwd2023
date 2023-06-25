import { createRouter, createWebHistory } from "vue-router";
import Home from '../components/Home.vue';
import BuscarLibro from '../components/BuscarLibro.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [{
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/BuscarLibro',
        name: 'Buscar libro',
        component: BuscarLibro
    }]
})

export default router;