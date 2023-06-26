<template>
    <div>
        <h1>Crear Libro</h1>
        <form @submit.prevent="guardarLibro" class="container">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" id="titulo" v-model="titulo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="autor" class="form-label">Autor:</label>
                <input type="text" id="autor" v-model="autor" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial:</label>
                <input type="text" id="editorial" v-model="editorial" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="cantPaginas" class="form-label">Cantidad de Páginas:</label>
                <input type="number" id="cantPaginas" v-model="cantPaginas" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="anioPublicacion" class="form-label">Año de Publicación:</label>
                <input type="number" id="anioPublicacion" v-model="anioPublicacion" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</template>

<script lang="ts">
import axios from 'axios';

export default {
    data() {
        return {
            titulo: '',
            autor: '',
            editorial: '',
            cantPaginas: 0,
            anioPublicacion: 0,
            estado: 'Activo',
        };
    },
    methods: {
        guardarLibro() {
            const nuevoLibro = {
                titulo: this.titulo,
                autor: [this.autor], // Convertir el autor en un array
                editorial: this.editorial,
                cant_paginas: this.cantPaginas,
                anio: this.anioPublicacion,
                estado: 'Activo',
            };
            axios.post('http://localhost:8001/apiv1/libros/nuevo', nuevoLibro)
                .then(response => {
                    console.log('Libro guardado: ', response.data);
                })
                .catch(error => {
                    console.error('Error al guardar el libro: ', error);
                });
        }
    }
}
</script>

<style>
.container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
}
</style>