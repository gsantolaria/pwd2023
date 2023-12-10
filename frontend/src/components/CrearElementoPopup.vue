<template>
    <modal v-if="mostrar" @close="cerrarPopup">
      <template v-slot:header>
        <h2>{{ titulo }}</h2>
      </template>
      <template v-slot:body>
        <label>{{ etiqueta }}</label>
        <input v-model="nuevoElemento" required>
      </template>
      <template v-slot:footer>
        <button class="btn-green" @click="crearElemento">Guardar</button>
      </template>
    </modal>
  </template>
  
  <script lang="ts">

  import Modal from './Modal.vue';
  
  export default {
    components: {
      Modal,
    },
    props: {
      titulo: String,
      etiqueta: String,
      mostrar: Boolean,
      guardar: Function,
      cerrar: Function,
      tipo: String,
    },
    data() {
      return {
        nuevoElemento: "",
      };
    },
    methods: {
      guardarElemento() {
        this.guardar(this.tipo, this.nuevoElemento);
    },
      cerrarPopup() {
        this.cerrar();
        this.nuevoElemento = "";
      },
      crearElemento() {
        this.guardar(this.nuevoElemento);
        this.cerrarPopup();
      },
    },
  };
  </script>
  
  <style scoped>
    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        margin-left: 15px;
    }

    input {
        width: 80%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 16px;
    }
</style>