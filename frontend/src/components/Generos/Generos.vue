<template>
    <div>
      <h2>Crear Género</h2>
      <form @submit.prevent="crearGenero">
        <div class="form-group">
          <label for="descripcion">Descripción:</label>
          <input v-model="nuevoGenero.descripcion" type="text" required>
        </div>
        <button type="submit">Crear Género</button>
      </form>
    </div>
  </template>
  
  <script lang="ts">

  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        nuevoGenero: {
          descripcion: '',
        },
      };
    },
    methods: {
      crearGenero() {
        axios.post('http://localhost:8001/apiv1/generos/nuevo', this.nuevoGenero)
          .then(response => {
            console.log('Género creado: ', response.data);
            this.mostrarCartelExito();
          })
          .catch(error => {
            console.error('Error al crear el género: ', error);
            this.mostrarCartelError();
          });
      },
      mostrarCartelExito() {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'success',
            title: 'Género creado con éxito',
            showConfirmButton: false,
            timer: 1600,
        });
      },
      mostrarCartelError() {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'error',
            title: 'Error al crear el género',
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