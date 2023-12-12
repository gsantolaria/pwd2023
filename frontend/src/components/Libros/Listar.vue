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
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="libro in librosFiltrados" :key="libro.id">
          <td>{{ libro.id }}</td>
          <td>{{ libro.titulo }}</td>
          <!-- en consola veo que me llega un array vacio de autores, editoriales y generos, revisar como lo traigo de la bbdd, SOLUCIONADO -->
          <td>{{ libro.autores.map(autor => autor.nombre_apellido).join(' ') }}</td> 
          <td>{{ libro.editoriales.nombre }}</td>
          <td>{{ libro.cant_paginas }}</td>
          <td>{{ libro.anio }}</td>
          <td>{{ libro.estado }}</td>
          <td>
              <router-link :to="{ name: 'ActualizarLibro', params: { id: libro.id } }">
                <Boton texto="editar" v-bind:class="{ edit: true }"></Boton>
              </router-link>
              <router-link :to="{ name: 'EliminarLibro', params: { id: libro.id } }">
                <Boton texto="eliminar" v-bind:class="{ warning: true }"></Boton>
              </router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">
import Boton from '../Boton.vue';
import axios from 'axios';

export default {
  components: { Boton },
  data() {
    return {
      libros: [],
      busqueda: ''
    };
  },
  created() {
    this.obtenerLibros();
  },
  methods: {
    async obtenerLibros() {
      try {
        const response = await axios.get('http://127.0.0.1:8001/apiv1/libros');
        this.libros = response.data;
        //console.log(this.libros);
      } catch (error) {
        console.error(error);
      }
    },
    buscarLibros() {
      const busqueda = this.busqueda.toLowerCase();
      this.libros.forEach(libro => {
        const autores = libro.autores;
        const editorial = libro.editoriales.nombre.toLowerCase();

        if (
          autores.some(autor => autor.nombre_apellido.toLowerCase().includes(busqueda)) ||
          libro.titulo.toLowerCase().includes(busqueda) ||
          autores.some(autor => autor.nombre_apellido.toLowerCase().includes(busqueda)) ||
          editorial.includes(busqueda)
        ) {
          libro.mostrar = true;
        } else {
          libro.mostrar = false;
        }
      });
    },
    async editarLibro(libroId) {
      try {
        const response = await axios.get(`http://127.0.0.1:8001/apiv1/libros/actualizar/${libroId}`);
        const libroEditar = response.data;

        this.$router.push({ name: 'editarLibro', params: { id: libroId, libro: libroEditar } });
      } catch (error) {
        console.error(error);
      }
    },
    async eliminarLibro(libroId) {
      try {
        await axios.delete(`http://127.0.0.1:8001/apiv1/libros/${libroId}`);
        
        this.obtenerLibros();
      } catch (error) {
        console.error(error);
      }
    },
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
  text-decoration: none;
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
.boton {
    padding: 8px 16px;
    margin-right: 8px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 4px;
  }
  .editar {
    background-color: #079d46;
    color: #fff;
    border: 1px solid #079d46;
    cursor: pointer;
  }
  .eliminar {
    background-color: #dc3545;
    color: #fff;
    border: 1px solid #dc3545;
    cursor: pointer;
  }
</style>