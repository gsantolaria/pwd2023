<template>
    <div class="crear-libro">
        <h1>Crear Libro</h1>
        <form @submit.prevent="crearLibro">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" v-model="libro.titulo" required>
            </div>
            <div class="form-group">
                <label for="autor">Autor:</label>
                <input id="autor" v-model="libro.autor" required>
            </div>
            <div class="form-group">
                <label for="genero">Género:</label>
                <select id="genero" v-model="libro.genero" required>
                    <option v-for="genero in generos" :value="genero.id" :key="genero.id">{{ genero.descripcion }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select id="categoria" v-model="libro.categoria" required>
                    <option v-for="categoria in categorias" :value="categoria.id" :key="categoria.id">{{
                        categoria.descripcion }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="editorial">Editorial:</label>
                <select id="editorial" v-model="libro.editorial" required>
                    <option v-for="editorial in editoriales" :value="editorial.id" :key="editorial.id">{{ editorial.nombre
                    }}
                    </option>
                    <option value="agregar">Agregar Editorial</option>
                </select>
            </div>
            <div v-if="libro.editorial === 'agregar'" class="form-group">
                <label for="nuevaEditorial">Nueva Editorial:</label>
                <input type="text" id="nuevaEditorial" v-model="nuevaEditorial" required>
            </div>
            <div class="form-group">
                <label for="anio">Año de publicación:</label>
                <input type="number" id="anio" v-model="libro.anioPublicacion" required>
            </div>
            <div class="form-group">
                <label for="paginas">Cantidad de páginas:</label>
                <input type="number" id="paginas" v-model="libro.cant_paginas" required>
            </div>
            <div>
                <button type="submit" class="btn-crear">Crear Libro</button>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
import axios from 'axios';

export default {
    data() {
        return {
            libro: {
                titulo: '',
                autor: [],
                genero: [],
                editorial: [],
                categoria: [],
                anioPublicacion: null,
                cant_paginas: null
            },
            categorias: [], // categorías obtenidas del backend
            editoriales: [], // editoriales obtenidas del backend
            generos: [], // géneros obtenidos del backend
            nuevaEditorial: ''
        };
    },
    mounted() {
        this.obtenerCategorias();
        this.obtenerEditoriales();
        this.obtenerGeneros();
    },
    methods: {
        obtenerCategorias() {
            // solicitud GET al backend para obtener la lista de categorías
            axios.get('http://localhost:8001/apiv1/categorias')
                .then(response => {
                    this.categorias = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        obtenerEditoriales() {
            // solicitud GET al backend para obtener la lista de editoriales
            axios.get('http://localhost:8001/apiv1/editoriales')
                .then(response => {
                    this.editoriales = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        obtenerGeneros() {
            // solicitud GET al backend para obtener la lista de generos
            axios.get('http://localhost:8001/apiv1/generos')
                .then(response => {
                    this.generos = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        crearLibro() {
            
            if (this.libro.editorial === 'agregar') {
                // Agregar la nueva editorial a la lista de editoriales
                const nuevaEditorial = {
                    id: 'nueva', // Asignar un ID temporal para la nueva editorial
                    nombre: this.nuevaEditorial
                };
                this.editoriales.push(nuevaEditorial);
                this.libro.editorial = nuevaEditorial.id;
                console.log(this.nuevaEditorial);
            }
            const nuevoLibro = {
                titulo: this.libro.titulo,
                autor: Array.isArray(this.libro.autor) ? this.libro.autor : [this.libro.autor],
                editorial: this.libro.editorial.nombre,
                anioPublicacion: this.libro.anioPublicacion,
                paginas: this.libro.cant_paginas
            };
            console.log(nuevoLibro);
            axios
                .post('http://localhost:8001/apiv1/libros/nuevo', nuevoLibro)
                .then(response => {
                    console.log(response.data);
                    alert('Libro creado exitosamente');
                    this.$router.push('/libros')
                })
                .catch(error => {
                    console.error(error);
                    alert('Error al crear el libro');
                });
        }
    }
};
</script>

<style scoped>
.crear-libro {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #adcfbe;
    border-radius: 5px;
    background-color: #fff;
}

h2 {
    margin-top: 0;
}

.form-group {
    margin-bottom: 10px;
    display: block;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
select {
    width: 80%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

.btn-crear {
    display: block;
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #079d46;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
}

.btn-crear:hover {
    background-color: #079d46;
}
</style>