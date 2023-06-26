<script lang="ts" setup>

import { RouterLink } from 'vue-router';

</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <img src="./assets/vue.svg" class="logo vue" alt="Vue logo" />
      <a class="navbar-brand" href="/">Gestión de libros - PWD 2023</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <RouterLink class="nav-link active" aria-current="page" to="/"> Inicio </RouterLink>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Libros
            </a>
            <ul class="dropdown-menu">
              <li>
                <RouterLink class="dropdown-item" to="/CrearLibro"> Crear Libro </RouterLink>
              </li>
              <li>
                <RouterLink class="dropdown-item" to="/EditarLibro"> Editar Libro </RouterLink>
              </li>
              <li>
                <RouterLink class="dropdown-item" to="/EliminarLibro"> Eliminar Libro </RouterLink>
              </li>
            </ul>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Buscar libro" aria-label="Buscar">
          <button class="btn btn-outline-secondary bg-light" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <RouterView />
  </div>
  
</template>

<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Outfit&display=swap');

</style>
