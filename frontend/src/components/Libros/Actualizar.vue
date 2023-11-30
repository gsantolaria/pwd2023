<template>
    <div>
    <h2>Editar Libro</h2>
    <!-- Aquí puedes agregar los campos de edición del libro -->
    <label>Título:</label>
    <input v-model="libro.titulo" type="text">

    <!-- Otros campos de edición -->

    <button @click="guardarCambios" class="boton guardar">Guardar Cambios</button>
    </div>
</template>

<script lang="ts">
import axios from 'axios';

export default {
    data() {
    return {
        libro: {}, // Aquí se almacenarán los datos del libro a editar
    };
    },
    created() {
    // Obtener el ID del libro desde los parámetros de la ruta
    const libroId = this.$route.params.id;

    // Realizar una solicitud GET para obtener los detalles del libro
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
        // Realizar una solicitud PUT para actualizar los detalles del libro
        await axios.put(`http://127.0.0.1:8001/apiv1/libros/actualizar/${this.libro.id}`, this.libro);

        // Redirigir a la página de listado de libros después de guardar los cambios
        this.$router.push({ name: 'listaLibros' });
        } catch (error) {
        console.error(error);
        }
    },
    },
};
</script>

<style scoped>
    /* Estilos específicos para el componente Editar.vue */
</style>