<template>
    <div class="menu-container">
      <h1>Menu de prestamos y devoluciones</h1>
      <div class="form-group">
        <h2>Préstamos activos:</h2>
          <table v-if="prestamos.length > 0">
          <thead>
            <tr>
              <th>ID del Préstamo</th>
              <th>Libro</th>
              <th>Socio</th>
              <th>Fecha de Inicio</th>
              <th>Fecha de Devolución</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="prestamo in prestamos" :key="prestamo.id">
              <td>{{ prestamo.id }}</td>
              <td>{{ prestamo.libro.titulo }}</td>
              <td>{{ prestamo.socio.nombre_apellido }}</td>
              <td>{{ prestamo.fecha_desde }}</td>
              <td>{{ prestamo.fecha_hasta }}</td>
            </tr>
          </tbody>
        </table>
        <p v-else>No hay préstamos activos.</p>
      </div>
      <h3>Que accion desea realizar?</h3>
      <div class="menu-options">
        <router-link to="/prestamos/prestamo" class="menu-option">
          <button class="guardar">Prestar libro</button>
        </router-link>
        <router-link to="/prestamos/devolucion" class="menu-option">
          <button class="editar">Devolver libro</button>
        </router-link>
      </div>
    </div>
  </template>

<script lang="ts">
import axios from 'axios';

export default {
  name: 'Menu',
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
  },
};
</script>

<style scoped>
  .menu-container {
    text-align: center;
    margin-top: 50px;
  }

  .menu-options {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
  }s

  table {
    background: #fff;
    border-radius: 10px;
    inset: 10px 50px 10px;
    box-shadow: 5px 5px 50px rgb(4, 96, 96, 0.2);
    width: 100%;
    color: black;
    margin: 20px;
    padding: 15px;
  }

  th {
    text-align: center;
    text-transform: uppercase;
    font-size: 1.6;
    color: rgb(4, 96, 96);
    background: #ccc;
  }

  td,
  tr {
    text-align: center;
    border: 1px solid #ddd;
    padding: 8px;
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
  