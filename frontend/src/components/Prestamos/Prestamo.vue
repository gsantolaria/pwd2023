<template>
    <div class="prestamo-form">
      <h1>Nuevo Préstamo</h1>
      <form @submit.prevent="realizarPrestamo">
        <div class="form-group">
          <label for="libro">Libros disponibles:</label>
          <select v-model="libroSeleccionado" required>
            <option v-for="libro in librosDisponibles" :key="libro.id" :value="libro.id">{{ libro.titulo }}</option>
          </select>
        </div>
        <div class="form-group">
          <label for="socio">Socio:</label>
          <select v-model="socioSeleccionado" required>
            <option v-for="socio in socios" :key="socio.id" :value="socio.id">{{ socio.nombre_apellido }}</option>
          </select>
        </div>
        <div class="form-group">
          <label for="fechaDesde">Fecha de inicio:</label>
          <input type="date" v-model="fechaDesde" required>
        </div>
        <div class="form-group">
          <label for="fechaHasta">Fecha de devolución:</label>
          <input type="date" v-model="fechaHasta" required>
        </div>
        <button type="submit">Realizar préstamo</button>
      </form>
    </div>
  </template>
  
  <script lang="ts">

  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        libros: [],
        socios: [],
        libroSeleccionado: null,
        socioSeleccionado: null,
        fechaDesde: '',
        fechaHasta: '',
      };
    },
    mounted() {
      this.cargarLibros(); 
      this.cargarSocios(); // y socios por lo pronto vamos a omitir su estado y permitir que todos saquen prestamos
    },
    computed: {
        librosDisponibles() {
            console.log(this.libros);
            return this.libros.filter(libro => (libro.estado.toLowerCase() !== 'prestado')); // por ahora solo descartamos libros que estan prestados, no importa si esta activo o no
        },
  },
    methods: {
      cargarLibros() {
        axios.get('http://localhost:8001/apiv1/libros')
          .then(response => this.libros = response.data)
          .catch(error => console.error(error));
      },
      cargarSocios() {
        axios.get('http://localhost:8001/apiv1/socios')
          .then(response => this.socios = response.data)
          .catch(error => console.error(error));
      },
      realizarPrestamo() {

        const socio = this.socios.find(soc => soc.id === this.socioSeleccionado);
        const libro = this.libros.find(lib => lib.id === this.libroSeleccionado);

        const nuevoPrestamo = {
          libro: libro.id,
          socio: socio.id,
          fecha_desde: this.fechaDesde,
          fecha_hasta: this.fechaHasta,
        };
        console.log(nuevoPrestamo);
  
        axios.post('http://localhost:8001/apiv1/prestamos/nuevo', nuevoPrestamo)
          .then(response => {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: 'success',
                title: 'Préstamo realizado con éxito',
                text: 'Préstamo registrado correctamente.',
          });
            console.log(response.data);
          })
          .catch(error => {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: 'error',
                    title: 'Error al realizar el préstamo',
                    text: 'Hubo un problema. Inténtalo de nuevo.',
                });

                console.error(error);
            });
        
      },
    },
  };
  </script>
  
  <style scoped>

  </style>
  