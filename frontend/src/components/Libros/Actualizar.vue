<template>
    <div>
    <h2>Editar Libro</h2>
    
    <div class="form-group">
      <label for="titulo">Título:</label>
      <input v-model="libro.titulo" type="text" id="titulo" class="form-control">
    </div>

    <div v-for="(autor, index) in libro.autores" :key="index" class="form-group">
      <label for="autor{{index}}">Autor/es:</label>
      <input v-model="autor.nombre_apellido" type="text" placeholder="Nombre del autor" :id="'autor' + index" class="form-control">
    </div>

    <div class="form-group">
      <label for="editorial">Editorial:</label>
      <select v-model="libro.editoriales.id" id="editorial" class="form-control">
        <option v-for="editorial in editoriales" :key="editorial.id" :value="editorial.id">{{ editorial.nombre }}</option>
        <!-- <option value="nuevo">Crear Nueva Editorial</option> -->
      </select>
    </div>

    <div class="form-group">
      <label for="categoria">Categoría:</label>
      <select v-model="libro.categorias.id" id="categoria" class="form-control">
        <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">{{ categoria.descripcion }}</option>
        <!-- <option value="nuevo">Crear Nueva Categoría</option> -->
      </select>
    </div>

    <div class="form-group">
      <label for="genero">Género:</label>
      <select v-model="libro.generos.id" id="genero" class="form-control">
        <option v-for="genero in generos" :key="genero.id" :value="genero.id">{{ genero.descripcion }}</option>
        <!-- <option value="nuevo">Crear Nuevo Género</option> -->
      </select>
    </div>

    <div class="form-group">
      <label for="cant_paginas">Cantidad de páginas:</label>
      <input v-model="libro.cant_paginas" type="number" id="cant_paginas" class="form-control">
    </div>

    <div class="form-group">
      <label for="anio">Año:</label>
      <input v-model="libro.anio" type="number" id="anio" class="form-control">
    </div>

    <div class="form-group">
      <label for="estado">Estado:</label>
      <select v-model="libro.estado" id="estado" class="form-control">
        <option value="Activo">Activo</option>
        <option value="Inactivo">Inactivo</option>
        <option value="Prestado">Prestado</option>
      </select>
    </div>

    <button @click="guardarCambios" class="boton guardar">Guardar Cambios</button>

    </div>
</template>

<script lang="ts">
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
    data() {
    return {
        libro: {},
        autores: [],
        editoriales: [],
        categorias: [],
        generos: [],
        };
    },
    created() {
        const libroId = this.$route.params.id;
        this.obtenerDetallesLibro(libroId);
        this.obtenerListas();
        },
    methods: {
        async obtenerListas() {
        try {
            const [editoriales, generos, categorias] = await Promise.all([
                axios.get('http://127.0.0.1:8001/apiv1/editoriales'),
                axios.get('http://127.0.0.1:8001/apiv1/generos'),
                axios.get('http://127.0.0.1:8001/apiv1/categorias'),
            ]);

            this.editoriales = editoriales.data;
            this.generos = generos.data;
            this.categorias = categorias.data;
        } catch (error) {
            console.error(error);
        }
    },
        async obtenerDetallesLibro(libroId) {
            try {

                const response = await axios.get('http://127.0.0.1:8001/apiv1/libros/' + this.$route.params.id);
                this.libro = response.data;
                this.autores = response.data.autores;
                /* console.log(this.libro);
                console.log(this.autores); */

            } catch (error) {
                console.error(error);
            }
        },
        async guardarCambios() {
            try {
            const datosLibro = {
                id: this.libro.id,
                titulo: this.libro.titulo,
                autor: this.libro.autores,
                editoriales: {
                    id: this.libro.editoriales.id,
                    nombre: this.libro.editoriales.nombre
                },
                generos: {
                    id: this.libro.generos.id,
                    nombre: this.libro.generos.descripcion
                },
                categorias: {
                    id: this.libro.categorias.id,
                    nombre: this.libro.categorias.descripcion
                },
                cant_paginas: this.libro.cant_paginas,
                anio: this.libro.anio,
                estado: this.libro.estado
            };
            //console.log(datosLibro);
            await axios.put(`http://127.0.0.1:8001/apiv1/libros/actualizar/${this.$route.params.id}`, datosLibro);
            
            this.mostrarCartelExito();
            this.$router.push({ name: 'Libros' });

            } catch (error) {
                console.error(error);
            }
            /* if (this.libro.editoriales.id === 'nuevo') {
            
            }

            if (this.libro.categorias.id === 'nuevo') {
               
            }

            if (this.libro.generos.id === 'nuevo') {
               
            } */

        },
        mostrarCartelExito() {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: 'success',
                title: 'Libro editado con éxito',
                showConfirmButton: false,
                timer: 1600,
            });
       },
    },
}    

</script>

<style scoped>
    .form-group {
        width: 60%;
        margin-bottom: 10px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-control {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }
    .boton {
        padding: 8px 16px;
        margin-right: 8px;
        font-size: 14px;
        cursor: pointer;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .guardar {
        background-color: #079d46;
        color: #fff;
        border: 1px solid #079d46;
        cursor: pointer;
    }

</style>