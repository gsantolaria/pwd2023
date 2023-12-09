
<template>
  <h1>Listado de Socios</h1>
  <input v-model="busqueda" @input="filtrarSocios" type="text" placeholder="Buscar socios...">
  <RouterLink class="crear" to="socios/crear"><img src="../../assets/editar.svg" alt="">Crear Socio</RouterLink>

  <select v-model="activo" name="is_activo" id="activo">
    <option value="activo">Activos</option>
    <option value="inactivo">Inactivos</option>
    <option value="todos">Todos</option>
  </select>

  <table>
    <thead>
      <tr>
        <th>id</th>
        <th>nombre</th>
        <th>fecha alta</th>
        <th>direccion</th>
        <th>telefono</th>
        <th>acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="socio in filtrarSocios()" :key="socio.id">
        <td>{{ socio.id }}</td>
        <td>{{ socio.nombre_apellido }}</td>
        <td>{{ socio.fecha_alta }}</td>
        <td>{{ socio.direccion }}</td>
        <td>{{ socio.telefono }}</td>
        <td>
          <router-link :to="{ name: 'ActualizarSocio', params: { id: socio.id } }">
            <Boton texto="editar" v-bind:class="{ edit: true }"></Boton>
          </router-link>
          <Boton texto="eliminar" v-bind:class="{ warning: true }" @click="confirmarEliminar(socio.id)"></Boton>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script lang="ts">
import axios from 'axios';
import Boton from '../Boton.vue';
import Swal from 'sweetalert2'; 

export default {
  components: { Boton },
  data() {
    return {
      items: [],
      socios: [],
      busqueda: '',
      activo: 'todos',
    };
  },
  created() {
    this.listarSocios();
  },
  methods: {
    async listarSocios() {
      try {
        const response = await axios.get('http://127.0.0.1:8001/apiv1/socios');
        this.socios = response.data;
        //console.log(this.socios);
      } catch (error) {
        console.error(error);
      }
    },
    filtrarSocios() {
      const busqueda = this.busqueda.toLowerCase();
      const estadoFiltrado = this.activo === 'todos' ? this.socios : this.socios.filter(socio => socio.activo === (this.activo === 'activo' ? 1 : 0));
      
      return estadoFiltrado.filter(socio => {
        const nombre = socio.nombre_apellido.toLowerCase();
        const direccion = socio.direccion.toLowerCase();
        return nombre.includes(busqueda) || direccion.includes(busqueda);
      });
    },
    borrar(id) {
      axios
        .delete('http://localhost:8001/apiv1/socios/delete/' + id)
        .then(response => {
          if (response.data === null) {
            Swal.fire({
              icon: 'success',
              title: 'Socio eliminado con éxito',
              showConfirmButton: false,
              timer: 1500,
            });
          }
          this.listarSocios();
        })
        .catch(error => {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'El socio no puede eliminarse porque tiene registros de préstamos.',
            });
        });
    },
    confirmarEliminar(id) {
      /* if (window.confirm('¿Seguro que deseas eliminar este socio?')) {
        this.borrar(id);
      } */
        Swal.fire({
          title: '¿Seguro que deseas eliminar este socio?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar',
        }).then((result) => {
          if (result.isConfirmed) {
            this.borrar(id);
          }
        });
      },
    },
  };
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
</style>