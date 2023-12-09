<template>
    <div>
    <h2>Eliminar Libro</h2>
    <p>¿Está seguro de que desea eliminar este libro?</p>

    
    <button @click="confirmarEliminar" class="boton eliminar">Confirmar eliminaciòn</button>
    
    <transition name="fade" mode="out-in">
      <div v-if="libroEliminado" class="cartel-exito">
        <p>Libro eliminado con éxito</p>
        <button @click="volverALibros" class="boton volver">Volver a Libros</button>
      </div>
    </transition>

    </div>
</template>

<script lang="ts">

import axios from 'axios';

export default {
    data() {
    return {
        libro: {},
        libroEliminado: false,
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
                this.libroEliminado = true;
                
            } catch (error) {
                console.error(error);
            }
        },
        volverALibros() {
            // probando redirigir a la página de listado de libros después de eliminar
            this.$router.push({ name: 'Libros' });
        },
    },
};
</script>

<style scoped>
    .boton {
        padding: 8px 16px;
        margin-right: 8px;
        font-size: 14px;
        cursor: pointer;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .eliminar {
        background-color: #dc3545;
        color: #fff;
        border: 1px solid #dc3545;
        cursor: pointer;
    }

</style> 