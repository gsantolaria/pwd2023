<template>
    <div class="devolucion">
      <h1>Devolución de Libro</h1>
      <form @submit.prevent="devolverLibro">
        <div class="form-group">
          <label for="prestamoId">ID de Préstamo:</label>
          <input type="text" id="prestamoId" v-model="prestamoId" required>
        </div>
        <div class="form-group">
          <label for="fechaDevolucion">Fecha de Devolución:</label>
          <input type="date" id="fechaDevolucion" v-model="fechaDevolucion" required>
        </div>
        <button type="submit" class="btn-devolver">Devolver Libro</button>
      </form>
    </div>
  </template>
  
  <script lang="ts">
  import Swal from 'sweetalert2';
  import axios from 'axios';
  
  export default {
    data() {
      return {
        prestamoId: '',
        fechaDevolucion: '',
      };
    },
    methods: {
      async devolverLibro() {
        try {
          const response = await axios.put(`http://localhost:8001/apiv1/prestamos/${this.prestamoId}/librodevuelto`, {
            fecha_dev: this.fechaDevolucion,
          });
          console.log(response.data);
  
          Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'success',
            title: 'Libro devuelto con éxito',
            showConfirmButton: false,
            timer: 1500,
          });
        } catch (error) {
          console.error(error);
  
          Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'error',
            title: 'Error al devolver el libro',
            text: 'Hubo un problema, intenta de nuevo.',
          });
        }
      },
    },
  };
  </script>
  
  <style scoped>
    
  </style>