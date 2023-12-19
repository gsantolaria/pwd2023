<template>
  <div class="menu-container">
    <div class="form-group">
      <h2>Listado de Géneros</h2>
      <clip-loader v-show="cargando" />
      <button @click.prevent="abrirFormulario('agregar')" class="guardar">Agregar Género</button>
      <table v-if="generos.length > 0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="genero in generos" :key="genero.id">
            <td>{{ genero.id }}</td>
            <td>{{ genero.descripcion }}</td>
            <td>
              <button @click.prevent="abrirFormulario('editar', genero)" class="editar">Editar</button>
              <button @click.prevent="abrirFormulario('eliminar', genero)" class="eliminar">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-show="!cargando" v-else>No hay géneros disponibles.</p>
    </div>

    <div v-if="mostrarFormulario">
      <h3>{{ tipoAccion === 'agregar' ? 'Agregar Género' : tipoAccion === 'editar' ? 'Editar Género' : 'Eliminar Género' }}</h3>
      <form @submit.prevent="submitForm">
        <label for="nombreGenero">Nombre del Género:</label>
        <input type="text" id="nombreGenero" v-model="generoSeleccionado.descripcion" required />
        <button type="submit" class="guardar" v-if="tipoAccion === 'editar' || tipoAccion === 'agregar'">Guardar Cambios</button>
        <button type="submit" class="eliminar" v-if="tipoAccion === 'eliminar'">Eliminar Género</button>
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
  name: 'Generos',
  data() {
    return {
      generos: [],
      cargando: true,
      mostrarFormulario: false,
      tipoAccion: 'editar',
      generoSeleccionado: null,
    };
  },
  mounted() {
    this.cargarGeneros();
  },
  methods: {
    async cargarGeneros() {
      try {
        const response = await axios.get('http://localhost:8001/apiv1/generos');
        this.generos = response.data;
      } catch (error) {
        console.error(error);
      }
      this.cargando = false;
    },
    abrirFormulario(tipo, genero = null) {
      this.tipoAccion = tipo;
      this.generoSeleccionado = tipo === 'agregar' ? { descripcion: '' } : { ...genero };
      this.mostrarFormulario = true;
    },
    submitForm() {
      if (this.tipoAccion === 'agregar') {
        this.agregarGenero();
      } else if (this.tipoAccion === 'editar') {
        this.guardarGenero();
      } else if (this.tipoAccion === 'eliminar') {
        this.eliminarGenero();
      }
    },
    volver() {
      this.mostrarFormulario = false;
    },
    async agregarGenero() {
      try {
        const response = await axios.post('http://localhost:8001/apiv1/generos/nuevo', { id: 0, 
          descripcion: this.generoSeleccionado.descripcion,
        });
        const nuevoGenero = response.data;
        this.generos.push(nuevoGenero);
        this.cargarGeneros();
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          title: 'Género creado con éxito',
          showConfirmButton: false,
          timer: 1600,
        });
      } catch (error) {
        console.error(error);
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Error al crear el género',
          text: 'Hubo un problema, inténtalo de nuevo.',
        });
      }
      this.cerrarFormulario();
    },
    async guardarGenero() {
      try {
        const response = await axios.put(`http://localhost:8001/apiv1/generos/${this.generoSeleccionado.id}`, {
          id: this.generoSeleccionado.id,
          descripcion: this.generoSeleccionado.descripcion,
        });
        const generoActualizado = response.data;
        const index = this.generos.findIndex(gen => gen.id === this.generoSeleccionado.id);
        if (index !== -1) {
          this.generos.splice(index, 1, generoActualizado);
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Género editado con éxito',
            showConfirmButton: false,
            timer: 1600,
          });
          this.cargarGeneros();
        }
      } catch (error) {
        console.error(error);
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Error al editar el género',
          text: 'Hubo un problema, inténtalo de nuevo.',
        });
      }
      this.cerrarFormulario();
    },
    async eliminarGenero() {
      if (this.generoSeleccionado) {
        try {
          await axios.delete(`http://localhost:8001/apiv1/generos/${this.generoSeleccionado.id}`);
          const index = this.generos.findIndex(gen => gen.id === this.generoSeleccionado.id);
          if (index !== -1) {
            this.generos.splice(index, 1);
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'Género eliminado con éxito',
              showConfirmButton: false,
              timer: 1600,
            });
          }
        } catch (error) {
          console.error(error);
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Error al eliminar el género',
            text: 'Hubo un problema, inténtalo de nuevo.',
          });
        }
        this.cerrarFormulario();
      }
    },
    cerrarFormulario() {
      this.mostrarFormulario = false;
      this.generoSeleccionado = null;
    },
  },
}
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