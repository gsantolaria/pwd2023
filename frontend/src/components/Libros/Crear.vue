<script lang="ts">
import axios from 'axios'

export default {
    data() {
        return {
            Libro:
            {
                id: "",
                titulo: "",
                autores: [],
                editorial: [],
                cant_paginas: "",
                categoria: [],
                anio: "",
                activo: 1,
            }

        }
    },
    methods: {
        async crearLibro() {
            const libro = {
                id: this.libro.id,
                titulo: this.libro.titulo,
                autores: [{ nombre_apellido: this.autor }],
                editorial: [{ nombre: this.editorial }],
                cant_paginas: this.libro.cant_paginas,
                categoria: this.libro.categoria.map((categoria) => ({ descripcion: categoria })),
                anio: this.libro.anio,
                estado: this.libro.activo === 1 ? "Activo" : "Inactivo",
            };

            console.log(libro);
            await axios.post('http://127.0.0.1:8001/apiv1/libros/nuevo', libro).
                then((response) => {
                    console.log(response.data)
                    this.$router.push('/libros')
                })
                .catch()
        }

    }
}
</script>

<template>
    <h2>Crear nuevo libro</h2>

    <input v-model=Libro.titulo type="text" label='titulo' placeholder="titulo">
    <input v-model=Libro.autores.nombre_apellido type="text" label='autor' placeholder="autor">
    <input v-model=Libro.editorial.nombre type="text" label='editorial' placeholder="editorial">
    <input v-model=Libro.cant_paginas type="text" label='cant_paginas' placeholder="cant_paginas">
    <input v-model=Libro.anio type="text" label='anio' placeholder="año">

    <button @click="crearLibro()">guardar</button>
    <router-link :to='{ name: "Libros" }'><button>Volver</button></router-link>
</template>

<style scope>
input {
    width: 50%;
    font-size: 1.2em;
    display: flex;
    align-content: center;
    padding: 10px;
    margin: 15px;
}
</style>