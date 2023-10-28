<template>
  <div>
    <h2>Listado de libros</h2>
      <div id="busqueda">
        <RouterLink class="crear" to="libros/crear"><img src="../../assets/editar.svg" alt="">Crear libro</RouterLink>
        <input v-model="busqueda" @input="buscarLibros" type="text" placeholder="Buscar libros...">
      </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Autor</th>
          <th>Editorial</th>
          <th>N° páginas</th>
          <th>Año</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="libro in librosFiltrados" :key="libro.id">
          <td>{{ libro.id }}</td>
          <td>{{ libro.titulo }}</td>
          <!-- en consola veo que me llega un array vacio de autores, editoriales y generos, revisar como lo traigo de la bbdd -->
          <td><ul>
                <li v-for="autor in libro.autores" :key="autor.id">{{ autor.nombre_apellido }}</li>
              </ul>
          </td> 
          <td>{{ libro.editoriales.nombre }}</td>
          <td>{{ libro.cant_paginas }}</td>
          <td>{{ libro.anio }}</td>
          <td>{{ libro.estado }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">

import axios from 'axios';

export default {
  data() {
    return {
      libros: [],
      busqueda: ''
    };
  },
  mounted() {
    this.obtenerLibros();
  },
  methods: {
    async obtenerLibros() {
      try {
        const response = await axios.get('http://127.0.0.1:8001/apiv1/libros');
        this.libros = response.data;
        console.log(response.data);
      } catch (error) {
        console.error(error);
      }
    },
    buscarLibros() {
      const busqueda = this.busqueda.toLowerCase();
      this.libros.forEach(libro => {
        const autores = this.obtenerAutores(libro.autores);
        const editorial = libro.editorial.nombre.toLowerCase();

        if (
          libro.titulo.toLowerCase().includes(busqueda) ||
          autores.some(autor => autor.toLowerCase().includes(busqueda)) ||
          editorial.includes(busqueda)
        ) {
          libro.mostrar = true;
        } else {
          libro.mostrar = false;
        }
      });
    }, 
    obtenerAutores(autores) {
      if (Array.isArray(autores)) {
        return autores.map(autor => autor.nombre_apellido).join(', ');
      }
      return '';
    }
  },
  computed: {
    librosFiltrados() {
      if (this.busqueda === '') {
        return this.libros;
      } else {
        return this.libros.filter(libro => libro.mostrar);
      }
    }
  }
}
</script>

<style scoped>
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

.crear {
  background: #079d46;
  padding: 10px 20px;
  color: #fff
}

.crear img {
  margin-right: 10px;
}

select {
  margin: 10px;
  padding: 10px;
  font-size: 1em
}

tr .acciones {
  text-aling: center;
  background: #ccc;
}

#busqueda {
  display: flex;
  align-items: center;
}
</style>