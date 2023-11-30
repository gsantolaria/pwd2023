<template>
    <div>
    <h2>Eliminar Libro</h2>
    <p>¿Estás seguro de que quieres eliminar este libro?</p>

    <!-- Aquí puedes mostrar información sobre el libro a eliminar -->

    <button @click="confirmarEliminar" class="boton eliminar">Confirmar Eliminación</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
    return {
        libro: {}, // Aquí se almacenarán los datos del libro a eliminar
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
    async confirmarEliminar() {
        try {
        // Realizar una solicitud DELETE para eliminar el libro
        await axios.delete(`http://127.0.0.1:8001/apiv1/libros/${this.libro.id}`);

        // Redirigir a la página de listado de libros después de eliminar
        this.$router.push({ name: 'listaLibros' });
        } catch (error) {
        console.error(error);
        }
    },
    },
};
</script>

<style scoped>
    /* Estilos específicos para el componente Eliminar.vue */
</style> 