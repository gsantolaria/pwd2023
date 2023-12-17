<template>
    <div>
      <h2>Crear Categoría</h2>
      <form @submit.prevent="crearCategoria">
        <div class="form-group">
          <label for="nombre">Nombre:</label>
          <input v-model="nuevaCategoria.nombre" type="text" required>
        </div>
        <button type="submit">Crear Categoría</button>
      </form>
    </div>
  </template>
  
  <script lang="ts">

  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        nuevaCategoria: {
          nombre: '',
        },
      };
    },
    methods: {
      crearCategoria() {
        axios.post('http://localhost:8001/apiv1/categorias/nuevo', this.nuevaCategoria)
          .then(response => {
            console.log('Categoría creada: ', response.data);
            this.mostrarCartelExito();
          })
          .catch(error => {
            console.error('Error al crear la categoría: ', error);
            this.mostrarCartelError();
          });
      },
      mostrarCartelExito() {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'success',
            title: 'Categoría creada con éxito',
            showConfirmButton: false,
            timer: 1600,
        });
      },
      mostrarCartelError() {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'error',
            title: 'Error al crear la categoría',
            text: 'Hubo un problema, intenta de nuevo.',
        });
      },
    },
  };
  </script>

<style scoped>
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
</style>