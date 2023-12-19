<template>
  <div class="menu-container">
    <div class="form-group">
      <h2>Listado de Categorías</h2>
      <clip-loader v-show="cargando" />
      <button @click.prevent="abrirFormulario('agregar')" class="guardar">Agregar Categoría</button>
      <table v-if="categorias.length > 0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="categoria in categorias" :key="categoria.id">
            <td>{{ categoria.id }}</td>
            <td>{{ categoria.descripcion }}</td>
            <td>
              <button @click.prevent="abrirFormulario('editar', categoria)" class="editar">Editar</button>
              <button @click.prevent="abrirFormulario('eliminar', categoria)" class="eliminar">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-show="!cargando" v-else>No hay categorías disponibles.</p>
    </div>

    <div v-if="mostrarFormulario">
      <h3>{{ tipoAccion === 'agregar' ? 'Agregar Categoría' : tipoAccion === 'editar' ? 'Editar Categoría' : 'Eliminar Categoría' }}</h3>
      <form @submit.prevent="submitForm">
        <label for="nombreCategoria">Nombre de la Categoría:</label>
        <input type="text" id="nombreCategoria" v-model="categoriaSeleccionada.descripcion" required />
        <button type="submit" class="guardar" v-if="tipoAccion === 'editar' || tipoAccion === 'agregar'">Guardar Cambios</button>
        <button type="submit" class="eliminar" v-if="tipoAccion === 'eliminar'">Eliminar Categoría</button>
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
  name: 'Categorias',
  data() {
    return {
      categorias: [],
      cargando: true,
      mostrarFormulario: false,
      tipoAccion: 'editar',
      categoriaSeleccionada: null,
    };
  },
  mounted() {
    this.cargarCategorias();
  },
  methods: {
    async cargarCategorias() {
      try {
        const response = await axios.get('http://localhost:8001/apiv1/categorias');
        this.categorias = response.data;
      } catch (error) {
        console.error(error);
      }
      this.cargando = false;
    },
    abrirFormulario(tipo, categoria = null) {
      this.tipoAccion = tipo;
      this.categoriaSeleccionada = tipo === 'agregar' ? { decripcion: '' } : { ...categoria };
      this.mostrarFormulario = true;
    },
    submitForm() {
      if (this.tipoAccion === 'agregar') {
        this.agregarCategoria();
      } else if (this.tipoAccion === 'editar') {
        this.guardarCategoria();
      } else if (this.tipoAccion === 'eliminar') {
        this.eliminarCategoria();
      }
    },
    volver() {
      this.mostrarFormulario = false;
    },
    async agregarCategoria() {
      try {
        const response = await axios.post('http://localhost:8001/apiv1/categorias/nuevo', { id: 0,
          descripcion: this.categoriaSeleccionada.descripcion,
        });
        const nuevaCategoria = response.data;
        this.categorias.push(nuevaCategoria);
        this.cargarCategorias();
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          title: 'Categoría creada con éxito',
          showConfirmButton: false,
          timer: 1600,
        });
      } catch (error) {
        console.error(error);
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Error al crear la categoría',
          text: 'Hubo un problema, inténtalo de nuevo.',
        });
      }
      this.cerrarFormulario();
    },
    async guardarCategoria() {
      try {
        const response = await axios.put(`http://localhost:8001/apiv1/categorias/${this.categoriaSeleccionada.id}`, { id: this.categoriaSeleccionada.id, 
          descripcion: this.categoriaSeleccionada.descripcion,
        });
        const categoriaActualizada = response.data;
        const index = this.categorias.findIndex(cat => cat.id === this.categoriaSeleccionada.id);
        if (index !== -1) {
          this.categorias.splice(index, 1, categoriaActualizada);
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Categoría editada con éxito',
            showConfirmButton: false,
            timer: 1600,
          });
          this.cargarCategorias();
        }
      } catch (error) {
        console.error(error);
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Error al editar la categoría',
          text: 'Hubo un problema, inténtalo de nuevo.',
        });
      }
      this.cerrarFormulario();
    },
    async eliminarCategoria() {
      if (this.categoriaSeleccionada) {
        try {
          await axios.delete(`http://localhost:8001/apiv1/categorias/${this.categoriaSeleccionada.id}`);
          const index = this.categorias.findIndex(cat => cat.id === this.categoriaSeleccionada.id);
          if (index !== -1) {
            this.categorias.splice(index, 1);
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'Categoría eliminada con éxito',
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
            title: 'Error al eliminar la categoría',
            text: 'Hubo un problema, inténtalo de nuevo.',
          });
        }
        this.cerrarFormulario();
      }
    },
    cerrarFormulario() {
      this.mostrarFormulario = false;
      this.categoriaSeleccionada = null;
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