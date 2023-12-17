<script lang="ts">
import Footer from "../src/components/Footer.vue";
import DropdownMenu from "./components/Dropdown-menu.vue";

export default {
  components: { Footer, DropdownMenu },
  data() {
    return {
      mostrarMenu: false
    };
  }
};
</script>
<template>
  <body>

    <nav>
       <!--  <button @click="mostrarMenu = !mostrarMenu" class="boton-menu">MENU</button>
        <ul v-if="mostrarMenu" class="menu-desplegable" @click="mostrarMenu = !mostrarMenu">
          <li><router-link to="/socios">Socios</router-link></li>
          <li><router-link to="/libros">Libros</router-link></li>
          <li><router-link to="/prestamos/menu">Prestamos</router-link></li>
          <li><router-link to="/autores">Autores</router-link></li>
          <li><router-link to="/editoriales">Editoriales</router-link></li>
          <li><router-link to="/categorias">Categorías</router-link></li>
          <li><router-link to="/generos">Géneros</router-link></li>
        </ul>  --> 
        <dropdown-menu menu-title="MENU" dark-mode="auto">
            <section class="option">
              <router-link to="/">Inicio</router-link>
            </section>
            <section class="option">
              <router-link to="/socios">Socios</router-link>
            </section>
            <section class="option">
              <router-link to="/libros">Libros</router-link>
            </section>
            <section class="option">
              <router-link to="/prestamos/menu">Prestamos</router-link>
            </section>
            <section class="option">
              <router-link to="/autores">Autores</router-link>
            </section>
            <section class="option">
              <router-link to="/editoriales">Editoriales</router-link>
            </section>
            <section class="option">
              <router-link to="/categorias">Categorías</router-link>
            </section>
            <section class="option">
              <router-link to="/generos">Generos</router-link>
            </section>
        </dropdown-menu>
        <div class="logo">
          <img src="../src/assets/logo_libro.svg" alt="logo">
          <h1>Prestamos de Libros</h1>
        </div>
    </nav>

    <section> 
      <router-view></router-view>
    </section>
    <Footer></Footer>
  </body>
</template>


<style scoped>
* {
  padding: 0px;
  margin: 0px;
  box-sizing: content-box;
}
.logo {
  padding: 30px;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  justify-content: center;
  width: 70%;
  color: #faebd7;
}
.logo img{
  padding: 20px;
  width: 40px;
  height: 40px;
}

nav {
  top: 0;
  display: flex;
  align-items: center;
  height: 10%;
  background: #079d46;
  color: #f0f8ff;
  display: flex;
  font-family: 'Times', Times, serif;
  font-size: 18px;
}

nav a {
  padding: 10px;
  text-transform: uppercase;
  text-decoration: none;
  color: #faebd7;
}
nav a:hover {
  padding: 10px;
  text-transform: uppercase;
  color: #9ed300;
}
section {
  height: 85%;
  padding: 25px;
}
.boton-menu {
  background-color: #079d46;
  color: #faebd7;
  border: none;
  padding: 10px;
  cursor: pointer;
  font-family: 'Times', Times, serif;
  font-size: 16px;
}
.boton-menu a:hover {
  padding: 10px;
  text-transform: uppercase;
  color: #9ed300;
}
.boton-menu:hover {
  padding: 10px;
  text-transform: uppercase;
  color: #9ed300;
}
.menu-desplegable {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  list-style-type: none;
  background-color: #079d46;
  border: 1px solid #ddd;
  border-radius: 10px;
  padding: 10px;
}
</style>