import { createRouter, createWebHistory } from "vue-router";
import Home from '../components/Home.vue';
import BuscarLibro from '../components/BuscarLibro.vue';
import CrearLibro from '../components/CrearLibro.vue';
import EditarLibro from '../components/EditarLibro.vue';
import EliminarLibro from '../components/EliminarLibro.vue';

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
    },
    {
        path: '/CrearLibro',
        name: 'Crear libro',
        component: CrearLibro
    },
    {
        path: '/EditarLibro',
        name: 'Editar Libro',
        component: EditarLibro
    },
    {
        path: '/EliminarLibro',
        name: 'Eliminar libro',
        component: EliminarLibro
    }]
})

export default router;