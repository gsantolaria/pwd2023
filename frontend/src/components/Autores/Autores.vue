<template>
  <div class="menu-container">
    <div class="form-group">
      <h2>Listado de Autores</h2>
      <clip-loader v-show="cargando" />
      <button @click.prevent="abrirFormulario('agregar', autor)" class="guardar">Agregar autor</button>
      <table v-if="autores.length > 0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre y Apellido</th>
            <th>Acciones</th>

          </tr>
        </thead>
        <tbody>
          <tr v-for="autor in autores" :key="autor.id">
            <td>{{ autor.id }}</td>
            <td>{{ autor.nombre_apellido }}</td>
            <td>
              <button @click.prevent="abrirFormulario('editar', autor)" class="editar">Editar</button>
              <button @click.prevent="abrirFormulario('eliminar', autor)" class="eliminar">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-show="!cargando" v-else>No hay autores disponibles.</p>
    </div>

    <div v-if="mostrarFormulario">
      <h3>{{ tipoAccion === 'agregar' ? 'Agregar Autor' : tipoAccion === 'editar' ? 'Editar Autor' : 'Eliminar Autor' }}</h3>
      <form @submit.prevent="submitForm">
        <label for="nombreApellido">Nombre y Apellido:</label>
        <input type="text" id="nombreApellido" v-model="autorSeleccionado.nombre_apellido" required />
        <button type="submit" class="guardar" v-if="tipoAccion === 'editar'|| tipoAccion === 'agregar'">Guardar Cambios</button>
        <button type="submit" class="eliminar" v-if="tipoAccion === 'eliminar'">Eliminar Autor</button>
        <button @click.prevent="volver" class="volver">Volver</button>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import Swal from 'sweetalert2';
import ClipLoader from 'vue-spinner/src/ClipLoader.vue';
import axios from 'axios';

export default {
  components: {
    ClipLoader,
  },
  name: 'Autores',
  data() {
    return {
      autores: [],
      cargando: true,
      mostrarFormulario: false,
      tipoAccion: 'editar',
      autorSeleccionado: null,
    };
  },
  mounted() {
    this.cargarAutores();
  },
  methods: {
    async cargarAutores() {
      try {
        const response = await axios.get('http://localhost:8001/apiv1/autores');
        this.autores = response.data;
      } catch (error) {
        console.error(error);
      }
      this.cargando = false;
    },
    abrirFormulario(tipo, autor = null) {
      this.tipoAccion = tipo;
      this.autorSeleccionado = tipo === 'agregar' ? { nombre_apellido: '' } : { ...autor };
      this.mostrarFormulario = true;
    },
    submitForm() {
      if (this.tipoAccion === 'agregar') {
        this.agregarAutor();
      } else if (this.tipoAccion === 'editar') {
        this.guardarAutor();
      } else if (this.tipoAccion === 'eliminar') {
        this.eliminarAutor();
      }
    },
    volver() {
      this.mostrarFormulario = false;
    },
    async agregarAutor() {
      try {
        const response = await axios.post('http://localhost:8001/apiv1/autores/nuevo', {id: 0, 
          nombre_apellido: this.autorSeleccionado.nombre_apellido,});
        const nuevoAutor = response.data;
        this.autores.push(nuevoAutor);
        this.cargarAutores();
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Autor creado con éxito',
            showConfirmButton: false,
            timer: 1600,
        });
      } catch (error) {
        console.error(error);
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'error',
            title: 'Error al crear el autor',
            text: 'Hubo un problema, intenta de nuevo.',
        });
      }
      this.cerrarFormulario();
    },
    async guardarAutor() {
      try {
        const response = await axios.put(`http://localhost:8001/apiv1/autores/${this.autorSeleccionado.id}`, 
        {id: this.autorSeleccionado.id, nombre_apellido: this.autorSeleccionado.nombre_apellido,
        });
        const autorActualizado = response.data;
        const index = this.autores.findIndex(aut => aut.id === this.autorSeleccionado.id);
        if (index !== -1) {
          this.autores.splice(index, 1, autorActualizado);
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Autor editado con éxito',
            showConfirmButton: false,
            timer: 1600,
          });
          this.cargarAutores();
        }
      } catch (error) {
        console.error(error);
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'error',
            title: 'Error al editar el autor',
            text: 'Hubo un problema, intenta de nuevo.',
        });
      }
      this.cerrarFormulario();
    },
    async eliminarAutor() {
      if (this.autorSeleccionado) {
        try {
          await axios.delete(`http://localhost:8001/apiv1/autores/${this.autorSeleccionado.id}`);
          const index = this.autores.findIndex(aut => aut.id === this.autorSeleccionado.id);
          if (index !== -1) {
            this.autores.splice(index, 1);
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'Autor eliminado con éxito',
              showConfirmButton: false,
              timer: 1600,
            });
          }
        } catch (error) {
          console.error(error);
          Swal.fire({
            toast: true,
            position: "top-end",
            icon: 'error',
            title: 'Error al eliminar el autor',
            text: 'Hubo un problema, intenta de nuevo.',
        });
        }
        this.cerrarFormulario();
      }
    },
    cerrarFormulario() {
      this.mostrarFormulario = false;
      this.autorSeleccionado = null;
    },
  },
    // aca en eliminar deberia solucionar el problema de eliminar un autor que este en un libro con un prestamo activo
    // ya que al borrarlo sin control, en el libro se muestra en blanco y como la relacion es con el ID, por mas que lo
    // agregue nuevamente, no aparece pq tiene un nuevo ID.
};
</script>

<style scoped>
  .menu-container {
    text-align: center;
    margin-top: 50px;
  }

  .menu-options {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }
  table {
    background: #fff;
    border-radius: 10px;
    inset: 10px 50px 10px;
    box-shadow: 5px 5px 50px rgb(4, 96, 96, 0.2);
    color: black;
    width: 50%;
    margin: 20px auto;
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
  .eliminar {
      background-color: #ff0019;
      color: #fff;
      border: 1px solid #ff0019;
      cursor: pointer;
  }
  form {
    margin-top: 150px;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 5px 5px 50px rgb(4, 96, 96, 0.2);
    padding: 20px;
  }
  input {
    width: 80%;
    font-size: 1.2em;
    display: flex;
    align-content: center;
    padding: 10px;
    margin: 15px;
  }
</style>