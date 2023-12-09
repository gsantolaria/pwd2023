<template>
    <div>
      <h2>Crear Editorial</h2>
      <form @submit.prevent="crearEditorial">
        <div class="form-group">
          <label for="nombre">Nombre:</label>
          <input v-model="nuevaEditorial.nombre" type="text" required>
        </div>
        <button type="submit">Crear Editorial</button>
      </form>
    </div>
  </template>
  
  <script lang="ts">

  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        nuevaEditorial: {
          nombre: '',
        },
      };
    },
    methods: {
      crearEditorial() {
        axios.post('http://localhost:8001/apiv1/editoriales/nuevo', this.nuevaEditorial)
          .then(response => {
            console.log('Editorial creada:', response.data);
            this.mostrarCartelExito();
          })
          .catch(error => {
            console.error('Error al crear la editorial:', error);
            this.mostrarCartelError();
          });
      },
      mostrarCartelExito() {
        Swal.fire({
          toast: true,
          position: "top-end",  
          icon: 'success',
          title: 'Editorial creada con éxito',
          showConfirmButton: false,
          timer: 1600,
        });
      },
      mostrarCartelError() {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'error',
            title: 'Error al crear la editorial',
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