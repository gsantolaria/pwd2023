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
                <!-- <input id="autor" v-model="autorBuscado" @input="buscarAutores" required> -->
                <select v-model="libro.autor" multiple required>
                    <option v-for="autor in autores" :key="autor.id" :value="autor.id">{{ autor.nombre_apellido }}</option>
                </select>
                <button @click="mostrarFormularioAutorNuevo">Agregar Nuevo Autor</button>
            </div>
            <div v-if="mostrarFormularioNuevoAutor">
                <label for="nuevoAutor">Nuevo Autor:</label>
                <input id="nuevoAutor" v-model="nuevoAutor" required>
                <button @click="agregarNuevoAutor">Guardar Autor</button>
            </div>
            <div class="form-group">
                <label for="editorial">Editorial:</label>
                <select v-model="libro.editorial" required>
                    <option v-for="editorial in editoriales" :key="editorial.id" :value="editorial.id">
                        {{ editorial.nombre }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select v-model="libro.categoria" required>
                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                        {{ categoria.descripcion }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="genero">Género:</label>
                <select v-model="libro.genero" required>
                    <option v-for="genero in generos" :key="genero.id" :value="genero.id">
                        {{ genero.descripcion }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="anio">Año de publicación:</label>
                <input type="number" id="anio" v-model="libro.anioPublicacion" required>
            </div>
            <div class="form-group">
                <label for="cant_paginas">Cantidad de páginas:</label>
                <input type="number" id="cant_paginas" v-model="libro.cant_paginas" required>
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
                genero: null,
                editorial: null,
                categoria: null,
                anioPublicacion: null,
                cant_paginas: null
            },
            editoriales: [],
            categorias: [],
            generos: [],
            autorBuscado: '', 
            autores: [], 
            mostrarFormularioNuevoAutor: false,
            nuevoAutor: '',
        };
    },
    mounted() {
        // Cargar autores
        axios.get('http://localhost:8001/apiv1/autores')
            .then(response => this.autores = response.data)
            .catch(error => console.error(error));

        // Cargar editoriales
        axios.get('http://localhost:8001/apiv1/editoriales')
            .then(response => this.editoriales = response.data)
            .catch(error => console.error(error));

        // Cargar categorías
        axios.get('http://localhost:8001/apiv1/categorias')
            .then(response => this.categorias = response.data)
            .catch(error => console.error(error));

        // Cargar géneros
        axios.get('http://localhost:8001/apiv1/generos')
            .then(response => this.generos = response.data)
            .catch(error => console.error(error));
    },
    methods: {
        crearLibro() {
            // probamos esto porque me esta llegando null en vez de un array de autores
            const nuevoLibro = {
                titulo: this.libro.titulo,
                autor: Array.isArray(this.libro.autor) ? this.libro.autor : [this.libro.autor],
                editorial: this.libro.editorial,
                categoria: this.libro.categoria,
                genero: this.libro.genero,
                anioPublicacion: this.libro.anioPublicacion,
                cant_paginas: this.libro.cant_paginas
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
        },
        mostrarFormularioAutorNuevo() {
            this.mostrarFormularioNuevoAutor = true;
        },
        async listarAutores() {
            try {
                const response = await axios.get('http://localhost:8001/apiv1/autores');
                this.autores = response.data;
                } catch (error) {
                    console.error(error);
            }
        },
        async agregarNuevoAutor() {
                const autorExiste = this.autores.find(autor => autor.nombre_apellido === this.nuevoAutor);
                if (autorExiste) {
                    // si el autor existe, asignamos el ID al libro
                    this.libro.autor = autorExiste.id;
                    console.log(this.libro.autor);
                } else {
                    // si el autor no existe, crea un nuevo autor y obtenemos el ID
                    try {
                        const response = await axios.post('http://localhost:8001/apiv1/autores', { nombre_apellido: this.nuevoAutor });
                        this.libro.autor = response.data.id;
                        console.log(this.libro.autor);
                    } catch (error) {
                        console.error(error);
                        alert('Error al agregar el nuevo autor');
                        return;
                    }
                }
                this.mostrarFormularioNuevoAutor = false;
                this.listarAutores();
            }
        },
        
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

button {
    margin-top: 5px;
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