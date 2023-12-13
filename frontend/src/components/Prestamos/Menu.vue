<template>
    <div class="menu-container">
      <h1>Menu de prestamos y devoluciones</h1>
      <h3>Que accion desea realizar?</h3>
      <div class="menu-options">
        <router-link to="/prestamos/prestamo" class="menu-option">
          <button class="btn-option">Prestar libro</button>
        </router-link>
        <router-link to="/prestamos/devolucion" class="menu-option">
          <button class="btn-option">Devolver libro</button>
        </router-link>
      </div>
    </div>
  </template>
  
  <script lang="ts">

  export default {
    name: 'Menu',
  };
  </script>
  
  <style scoped>
  .menu-container {
    text-align: center;
    margin-top: 50px;
  }
  
  .menu-options {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
  }
  
  .btn-option {
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
  }
  </style>
  