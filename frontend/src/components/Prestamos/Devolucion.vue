<template>
  <div class="devolucion">
    <h1>Devolución de Libro</h1>
    <form @submit.prevent="devolverLibro">
      <div class="form-group">
        <label for="prestamoId">Seleccionar Préstamo:</label>
        <select v-model="prestamoId" @change="mostrarDetalles"   required>
          <option v-for="prestamo in prestamos" :key="prestamo.id" :value="prestamo.id">
            {{ prestamo.id }} - {{ prestamo.libro.titulo }} - {{ prestamo.socio.nombre_apellido }}
          </option>
        </select>
      </div>
      <div class="form-group" v-if="detallePrestamo">
        <h2>Detalles del Préstamo Seleccionado:</h2>
        <ul>
          <li><strong>ID del Préstamo:</strong> {{ detallePrestamo.id }}</li>
          <li><strong>Libro:</strong> {{ detallePrestamo.libro.titulo }}</li>
          <li><strong>Socio:</strong> {{ detallePrestamo.socio.nombre_apellido }}</li>
          <li><strong>Fecha de Inicio:</strong> {{ detallePrestamo.fecha_desde }}</li>
          <li><strong>Fecha de Devolución:</strong> {{ detallePrestamo.fecha_hasta }}</li>
        </ul>
      </div>
      <div class="form-group">
        <label for="fechaDevolucion">Fecha de Devolución:</label>
        <input type="date" id="fechaDevolucion" v-model="fechaDevolucion" required>
      </div>
      <button type="submit" class="guardar">Realizar devolucion</button>
      <router-link to="/prestamos/menu">
        <button class="editar">Volver atrás</button>
      </router-link>
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
      prestamos: [],
      detallePrestamo: null,
    };
  },
  mounted() {
    this.cargarPrestamos();
  },
  methods: {
    async cargarPrestamos() {
      try {
        const response = await axios.get('http://localhost:8001/apiv1/prestamos');
        this.prestamos = response.data;

        console.log(this.prestamos);
        
      } catch (error) {
        console.error(error);
      }
    },
    mostrarDetalles() {
      this.detallePrestamo = this.prestamos.find(prestamo => prestamo.id === this.prestamoId  );
    },
    async devolverLibro() {
      try {
        const response = await axios.delete(`http://localhost:8001/apiv1/prestamos/${this.prestamoId}`);
        console.log(response.data);
        this.$router.push('/prestamos/menu')

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
input {
  width: 50%;
  font-size: 1.2em;
  display: flex;
  align-content: center;
  padding: 10px;
  margin: 15px;
}

button {
  padding: 8px 16px;
  margin-right: 8px;
  font-size: 14px;
  cursor: pointer;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.guardar {
  background-color: #079d46;
  color: #fff;
  border: 1px solid #079d46;
  cursor: pointer;
}

.editar {
  background-color: #2170b1;
  color: #fff;
  border: 1px solid #2170b1;
  cursor: pointer;
}
</style>
