<template>
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="table-responsive">
                <table class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Titulo</th>
                            <th>Autor</th>
                            <th>Editorial</th>
                            <th>N° páginas</th>
                            <th>Año</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" id="contenido">
                        <tr v-for="libro in libros" :key="libro.id">
                            <td v-text="libro.id"></td>
                            <td v-text="libro.titulo"></td>
                            <td v-text="libro.autor.nombre_apellido"></td>
                            <td v-text="libro.editorial.nombre"></td>
                            <td v-text="libro.cant_paginas"></td>
                            <td v-text="libro.anio"></td>
                            <td>
                                <RouterLink :to="{path:'/'+libro.id}" class="btn btn-info">Ver</RouterLink>
                                <RouterLink :to="{path:'EditarLibro/'+libro.id}" class="btn btn-warning"> Editar</RouterLink>
                                <button class="btn btn-danger"> Borrar </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>


<script lang="ts">

import axios from 'axios';
import { ref } from 'vue';

export default {
    data() {
        return {
            libros: [],
        };
    },
    mounted() {
        axios.get('http://localhost:8001/apiv1/libros')
            .then(response => {
                this.libros = response.data;
                console.log(this.libros);
            })
            .catch(error => {
                console.error(error);
            });
    },
}
</script>


<style scoped>
.btn {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>