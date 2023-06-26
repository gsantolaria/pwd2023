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

</script>


<style scoped>

</style>