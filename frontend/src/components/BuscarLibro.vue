<template>

        <title>CRUD de Libros</title>

        <div id="app">
            <h1>CRUD de Libros</h1>

            <form @submit.prevent="guardarLibro">
                <input type="text" v-model="titulo" placeholder="Título" required>
                <input type="text" v-model="genero" placeholder="Género" required>
                <input type="text" v-model="categoria" placeholder="Categoría" required>
                <input type="number" v-model="cantPaginas" placeholder="Cantidad de páginas" required>
                <input type="number" v-model="anioPublicacion" placeholder="Año de publicación" required>
                <button type="submit">Guardar</button>
            </form>

            <ul>
                <li v-for="libro in libros" :key="libro.id">
                    {{ libro.titulo }} - {{ libro.genero }} - {{ libro.categoria }} - {{ libro.cantPaginas }} - {{
                        libro.anioPublicacion }}
                    <button @click="editarLibro(libro.id)">Editar</button>
                    <button @click="borrarLibro(libro.id)">Borrar</button>
                </li>
            </ul>
        </div>
</template>

<script lang="ts">
import axios from "axios";
new Vue({
    el: '#app',
    data: {
        libros: [],
        titulo: '',
        genero: '',
        categoria: '',
        cantPaginas: 0,
        anioPublicacion: 0,
    },
    created() {
        this.listarLibros();
    },
    methods: {
        listarLibros() {
            axios.get('/api/libros')
                .then(response => {
                    this.libros = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        guardarLibro() {
            const nuevoLibro = {
                titulo: this.titulo,
                genero: this.genero,
                categoria: this.categoria,
                cantPaginas: this.cantPaginas,
                anioPublicacion: this.anioPublicacion
            };

            axios.post('/api/libros', nuevoLibro)
                .then(response => {
                    this.listarLibros();
                    this.resetForm();
                })
                .catch(error => {
                    console.error(error);
                });
        },
        editarLibro(id) {
            // Lógica para editar un libro
        },
        borrarLibro(id) {
            // Lógica para borrar un libro
        },
        resetForm() {
            this.titulo = '';
            this.genero = '';
            this.categoria = '';
            this.cantPaginas = 0;
            this.anioPublicacion = 0;
        }
    }
});
</script>


<style>
body {
    font-family: 'Outfit', sans-serif;
    color: #646cffaa;
}

button {
    margin-left: 1em;
}

button:hover {
    filter: drop-shadow(0 0 1em #646cffaa);
}</style>