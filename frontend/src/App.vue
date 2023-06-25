<script lang="ts" setup>
import { RouterLink } from 'vue-router';


</script>

<template>
  <div>
    <a href="https://vuejs.org/" target="_blank">
      <img src="./assets/vue.svg" class="logo vue" alt="Vue logo" />
    </a>
  </div>
  <nav>
    <RouterLink to="/"> Home </RouterLink>
    <RouterLink to="/BuscarLibro"> Buscar </RouterLink>
  </nav>
  <RouterView></RouterView>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Outfit&display=swap');

h1 {
  font-family: 'Outfit', sans-serif;
}

.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}

.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}

.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
