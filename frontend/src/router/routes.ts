import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/Home.vue';
import SociosListar from '../components/Socios/Listar.vue';
import SociosCrear from '../components/Socios/Crear.vue';
import SocioActualizar from '../components/Socios/Actualizar.vue';
import LibrosListar from '../components/Libros/Listar.vue';
import LibrosCrear from '../components/Libros/Crear.vue';
import LibrosActualizar from '../components/Libros/Actualizar.vue';
import LibrosBorrar from '../components/Libros/Borrar.vue';
import LibrosPrestar from '../components/Prestamos/Prestamo.vue';
import LibrosDevolver from '../components/Prestamos/Devolucion.vue';
import MenuPrestamo from '../components/Prestamos/Menu.vue';
import Categorias from '../components/Categorias/Categorias.vue';
import Generos from '../components/Generos/Generos.vue';
import Editoriales from '../components/Editoriales/Editoriales.vue';


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../components/About.vue')
    },
    {
      path: '/socios',
      name: 'Socios',
      component: SociosListar
    },
    {
      path: '/socios/crear',
      name: 'sociosCrear',
      component: SociosCrear
    },
    {
      path: '/socios/actualizar/:id',
      name: 'ActualizarSocio',
      component: SocioActualizar
    },
    {
      path: '/libros',
      name: 'Libros',
      component: LibrosListar
    },
    {
      path: '/libros/crear',
      name: 'librosCrear',
      component: LibrosCrear
    },
    {
      path: '/libros/actualizar/:id',
      name: 'ActualizarLibro',
      component: LibrosActualizar
    },
    {
      path: '/libros/:id',
      name: 'EliminarLibro',
      component: LibrosBorrar
    },
    {
      path: '/prestamos/prestamo',
      name: 'PrestarLibro',
      component: LibrosPrestar
    },
    {
      path: '/prestamos/devolucion',
      name: 'DevolverLibro',
      component: LibrosDevolver
    },
    {
      path: '/prestamos/menu',
      name: 'Menu',
      component: MenuPrestamo
    },
    {
      path: '/categorias',
      name: 'Categorias',
      component: Categorias
    },
    {
      path: '/editoriales',
      name: 'Editoriales',
      component: Editoriales
    },
    {
      path: '/generos',
      name: 'Generos',
      component: Generos
    },

  ]
})

export default router