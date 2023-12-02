<template>
    <div>
    <h2>Editar Libro</h2>
    
        <label>Título:</label>
        <input v-model="libro.titulo" type="text">

        <!-- aca agrego el resto de los campos que quiera editar -->

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
            const response = await axios.get(`http://127.0.0.1:8001/apiv1/libros/${libroId}`);
            this.libro = response.data;
            } catch (error) {
            console.error(error);
            }
        },
        async guardarCambios() {
            try {
            // PUT para actualizar los detalles del libro
            await axios.put(`http://127.0.0.1:8001/apiv1/libros/actualizar/${this.libro.id}`, this.libro);
            // Redirigir a la página de listado de libros después de guardar los cambios
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