<template>
    <div>
    <h2>Editar Libro</h2>
    
    <label>Título:</label>
    <input v-model="libro.titulo" type="text">
    <input v-model="libro.editoriales.nombre" type="text">
    <input v-model="libro.cant_paginas" type="number">
    <input v-model="libro.anio" type="number">
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
};
</script>

<style scoped>
    
</style>