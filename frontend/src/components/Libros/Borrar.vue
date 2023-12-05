<template>
    <div>
    <h2>Eliminar Libro</h2>
    <p>¿Está seguro de que desea eliminar este libro?</p>


    <button @click="confirmarEliminar" class="boton eliminar">Confirmar Eliminación</button>
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
        async confirmarEliminar() {
            try {
                // hAcer un DELETE del libro, aca seguro rompemos la consistencia de la bbdd si borramos asi nomas
                await axios.delete(`http://127.0.0.1:8001/apiv1/libros/${this.libro.id}`);

                // probando redirigir a la página de listado de libros después de eliminar
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