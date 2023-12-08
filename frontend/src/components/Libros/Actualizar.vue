<template>
    <div>
    <h2>Editar Libro</h2>
    
    <label>Título:</label>
        <input v-model="libro.titulo" type="text">
    <label>Autor/es:</label>
        <div v-for="(autor, index) in libro.autores" :key="index">
            <input v-model="autor.nombre_apellido" type="text" placeholder="Nombre del autor">
        </div>
    <label>Editorial:</label>
        <input v-model="libro.editoriales.nombre" type="text">
    <label>Categoria:</label>
        <input v-model="libro.categorias.descripcion" type="text">
    <label>Genero:</label>
        <input v-model="libro.generos.descripcion" type="text">
    <label>Cantidad de paginas:</label>
        <input v-model="libro.cant_paginas" type="number">
    <label>Año:</label>
        <input v-model="libro.anio" type="number">
    <label>Estado:</label>
        <input v-model="libro.estado" type="text">

    <button @click="guardarCambios" class="boton guardar">Guardar Cambios</button>

    </div>
</template>

<script lang="ts">
import axios from 'axios';

export default {
    data() {
    return {
        libro: {},
        autores: [],
        };
    },
    created() {
        const libroId = this.$route.params.id;
        this.obtenerDetallesLibro(libroId);
        },
    methods: {
        async obtenerDetallesLibro(libroId) {
            try {

                const response = await axios.get('http://127.0.0.1:8001/apiv1/libros/' + this.$route.params.id);
                this.libro = response.data;
                this.autores = response.data.autores;
                console.log(this.libro);
                console.log(this.autores);

            } catch (error) {
                console.error(error);
            }
        },
        async guardarCambios() {
            try {
            const datosLibro = {
                id: this.libro.id,
                titulo: this.libro.titulo,
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

            await axios.put(`http://127.0.0.1:8001/apiv1/libros/actualizar/${this.$route.params.id}`, datosLibro);
            this.$router.push({ name: 'Libros' });

            } catch (error) {
                console.error(error);
            }
        },
    },
};    
    /* methods: {
        async obtenerDetallesLibro(libroId) {
            try {
                const response = await axios.get('http://127.0.0.1:8001/apiv1/libros/' + this.$route.params.id);
                this.libro = response.data;
                
            } catch (error) {
                console.error(error);
            }
        },
        async guardarCambios() {
            try {
                console.log(this.libro);
                await axios.put('http://127.0.0.1:8001/apiv1/libros/actualizar/' + this.$route.params.id, this.libro);
                this.$router.push({ name: 'Libros' });
            
            } catch (error) {
                console.error(error);
            }
        },
    },
}; */
</script>

<style scoped>
    
</style>