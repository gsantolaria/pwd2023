<template>
    <div>
    <h2>Eliminar Libro</h2>
    <p>¿Está seguro de que desea eliminar este libro?</p>
    
    <button @click="confirmarEliminar" class="eliminar">Confirmar eliminación</button>
    <router-link to="/libros" class="routerlink">
        <button class="volver">Volver</button>
    </router-link>

    </div>
</template>

<script lang="ts">
import Swal from 'sweetalert2';
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
                if (this.libro.estado.toLowerCase() === 'prestado') {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: 'error',
                        title: 'No se puede eliminar',
                        text: 'El libro está prestado y no puede ser eliminado',
                    });
                    return;
                }
                await axios.delete(`http://127.0.0.1:8001/apiv1/libros/${this.libro.id}`);
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: 'success',
                    title: 'Libro eliminado con éxito',
                    showConfirmButton: false,
                    timer: 1600,
                });
                this.$router.push({ name: 'Libros' });

                } catch (error) {
                    console.error(error);
                }
        },
    },
};
</script>

<style scoped>
    .button {
        padding: 8px 16px;
        margin-right: 8px;
        font-size: 14px;
        cursor: pointer;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .eliminar {
        background-color: #ff0019;
        color: #fff;
        border: 1px solid #ff0019;
        cursor: pointer;
    }
    .volver {
        background-color: #2170b1;
        color: #fff;
        border: 1px solid #2170b1;
        cursor: pointer;
    }

</style> 