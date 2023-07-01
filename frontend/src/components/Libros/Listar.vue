<!-- <template>
  <h1>Listado de Libros</h1>

  <RouterLink class="crear" to="libros/crear"><img src="../../assets/editar.svg" alt="">Agregar libro</RouterLink>


  <select v-model=activo name="is_activo" id="activo">
    <option value='activo'>Activos</option>
    <option value='inactivo'>Inactivos</option>
    <option value='prestados'>Prestados</option>
  </select>

  <table>
    <thead>
      <tr>
        <td>id</td>
        <td>Titulo</td>
        <td>Autor</td>
        <td>Editorial</td>
        <td>Cant páginas</td>
        <td>Categoría</td>
        <td>Año</td>
      </tr>
    </thead>
    <tbody>

      <tr v-for="libro in items" :key="libro">

        <template v-if="activo === 'activo'">
          <template v-if='libro.activo === 1'>
            <td>{{ libro.id }}</td>
            <td>{{ libro.nombre_apellido }}</td>
            <td>{{ libro.autor.nombre_apellido }}</td>
            <td>{{ libro.editorial.nombre }}</td>
            <td>{{ libro.cant_paginas }}</td>
            <td>{{ libro.categoria }}</td>
            <td>{{ libro.anio }}</td>
      <tr>

        <td>
          <router-link :to="{ name: 'ActualizarLibro', params: { id: libro.id } }">
            <Boton texto="editar" v-bind:class="{ primary: true }"></Boton>
          </router-link>
        </td>
        <td>
          <Boton texto="eliminar" v-bind:class="{ warning: true }" @click="borrar(libro.id)"></Boton>
        </td>
        <td>
          <Boton texto="abrir" v-bind:class="{ alert: true }"></Boton>
        </td>
      </tr>
      </template>
      </template>
      <template v-if="activo === 'inactivo'">
        <template v-if='libro.activo === 0'>
          <td>{{ libro.id }}</td>
          <td>{{ libro.nombre_apellido }}</td>
          <td>{{ libro.autor.nombre_apellido }}</td>
          <td>{{ libro.editorial.nombre }}</td>
          <td>{{ libro.cant_paginas }}</td>
          <td>{{ libro.categoria }}</td>
          <td>{{ libro.anio }}</td>
          <tr>

            <td>
              <router-link :to="{ name: 'ActualizarLibro', params: { id: libro.id } }">
                <Boton texto="editar" v-bind:class="{ primary: true }"></Boton>
              </router-link>
            </td>
            <td>
              <Boton texto="eliminar" v-bind:class="{ warning: true }" @click="borrar(libro.id)"></Boton>
            </td>
            <td>
              <Boton texto="abrir" v-bind:class="{ alert: true }"></Boton>
            </td>
          </tr>
        </template>
      </template>
      <template v-if="activo === 'prestados'">
        <td>{{ libro.id }}</td>
        <td>{{ libro.titulo }}</td>
        <td>{{ libro.autor.nombre_apellido }}</td>
        <td>{{ libro.editorial.nombre }}</td>
        <td>{{ libro.cant_paginas }}</td>
        <td>{{ libro.categoria }}</td>
        <td>{{ libro.anio }}</td>
        <tr class="acciones">

          <td>
            <router-link :to="{ name: 'ActualizarLibro', params: { id: libro.id } }">
              <Boton texto="editar" v-bind:class="{ primary: true }"></Boton>
            </router-link>
          </td>
          <td>
            <Boton texto="eliminar" v-bind:class="{ warning: true }" @click="borrar(libro.id)"></Boton>
          </td>
          <td>
            <Boton texto="abrir" v-bind:class="{ alert: true }"></Boton>
          </td>
        </tr>
      </template>
      </tr>
    </tbody>
  </table>
</template>

<script lang="ts">

import axios from 'axios';
import Boton from '../Boton.vue';

export default {
  components: { Boton },
  data() {
    return {
      items: [],
      activo: 'activo'

    };
  },
  computed: {

  },
  created() {
    this.listarLibros();
  },
  methods: {

    buscarLibro(Items) {
      Items.find()

    },
    async listarLibros() {
      const res = await axios.get('http://127.0.0.1:8001/apiv1/libros');
      this.items = res.data;
      console.log(res.data);
    },
    borrar(id) {
      axios.delete('http://localhost:8001/apiv1/libros/delete/' + id)
        .then((response) => {
          console.log(response)
          if (response.data === null) { alert("Libro eliminado con éxito") }
          this.listarLibros();
        })
        .catch((error) => { alert('El libro no puede eliminarse porque tiene registro de prestamos') });
    }
  }
}
</script>-->

<template>
  <div>
    <h2>Listado de libros</h2>
    <input v-model="busqueda" @input="buscarLibros" type="text" placeholder="Buscar libros...">
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
          <td>{{ libro.autor.nombre_apellido }}</td>
          <td>{{ libro.editorial.nombre }}</td>
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
        console.log(this.libros);
      } catch (error) {
        console.error(error);
      }
    },
    buscarLibros() {
      const busqueda = this.busqueda.toLowerCase();
      this.libros.forEach(libro => {
        const autores = this.obtenerAutores(libro.autor);
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
        return autores.map(autor => autor.nombre_apellido);
      }
      return [];
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
  background: #272ef6;
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
</style>