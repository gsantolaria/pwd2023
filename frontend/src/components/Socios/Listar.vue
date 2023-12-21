
<template>
  <h1>Listado de Socios</h1>
  <div id="busqueda">
    <RouterLink class="crear" to="socios/crear"><img src="../../assets/editar.svg" alt="">Crear Socio</RouterLink>
    <input v-model="busqueda" @input="filtrarSocios" type="text" placeholder="Buscar socios...">
    <select v-model="activo" name="is_activo" id="activo">
      <option value="activo">Activos</option>
      <option value="inactivo">Inactivos</option>
      <option value="todos">Todos</option>
    </select>
  </div>

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
            <button class="editar">Editar</button>
          </router-link>
            <button class="eliminar" @click="confirmarEliminar(socio.id)">Eliminar</button>
        </td>
      </tr>
    </tbody>
  </table>
  <clip-loader v-show="cargando" />
</template>

<script lang="ts">
import axios from 'axios';
import Swal from 'sweetalert2';
import ClipLoader from 'vue-spinner/src/ClipLoader.vue'

export default {
  components: {
    ClipLoader,
  },
  data() {
    return {
      items: [],
      socios: [],
      busqueda: '',
      activo: 'todos',
      prestamos: [],
      cargando: true,
    };
  },
  created() {
    this.listarSocios();
    this.cargarPrestamos();
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
      this.cargando = false;
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
    async cargarPrestamos() {
      try {
        const response = await axios.get('http://localhost:8001/apiv1/prestamos');
        this.prestamos = response.data;
      } catch (error) {
          console.error(error);
      }
      this.cargando = false;
    },
    borrar(id) {
      axios
        .delete('http://localhost:8001/apiv1/socios/delete/' + id)
        .then(response => {
          if (response.data === null) {
            Swal.fire({
              toast: true,
              position: "top-end",
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
              toast: true,
              position: "top-end",
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
      // aca arme la logica para chequear si un socio tiene prestamos activos antes de eliminarlo,
      // sin embargo, no los estaba eliminando porque fallaba la FK en la bbdd al intentar borrarlo
      // teniendo un prestamo activo.
      /* Este error veo en consola:
        file: "/var/www/html/src/Bd/ConectarBD.php"
        line: 61 
        message
        "SQLSTATE[23503]: Foreign key violation: 7 ERROR:  update or delete on table \"socios\" violates foreign key constraint \"fk_socio\" on table \"prestamos\"\nDETAIL:  Key (id)=(4) is still referenced from table \"prestamos\"."
        type: 
        "PDOException" */

        const tienePrestamoActivo = this.prestamos.some(prestamo => prestamo.socio_id === id);
        if (tienePrestamoActivo) {
          Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'error',
            title: 'Error',
            text: 'El socio no puede eliminarse porque tiene un préstamo activo.',
          });
        } else {
            Swal.fire({
              title: '¿Seguro que deseas eliminar este socio?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ff0000',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Sí, eliminar',
              cancelButtonText: 'Cancelar',
            }).then((result) => {
              if (result.isConfirmed) {
                this.borrar(id);
              }
          });
        }
      },
    },
};
</script>

<style scoped>
h1 {
  text-align: center;
  margin-top: 50px;
}
#busqueda {
  display: flex;
  align-items: center;
  justify-content: center;
}
select {
  margin: 10px;
  padding: 12px;
  font-size: 1em;
  width: 200px;
}
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
  text-align: center;
  white-space: nowrap; 
  min-width: auto;
  background: #079d46;
  padding: 13px 20px;
  border-radius: 5px;
  color: #fff
}

.crear img {
  margin-right: 10px;
}

tr .acciones {
  text-aling: center;
  background: #ccc;
}
button {
    padding: 8px 16px;
    margin-right: 8px;
    font-size: 14px;
    cursor: pointer;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.eliminar {
    background-color: #ff0000;
    color: #fff;
    border: 1px solid #ff0000;
    cursor: pointer;
}
.editar {
    background-color: #2170b1;
    color: #fff;
    border: 1px solid #2170b1;
    cursor: pointer;
}
</style>