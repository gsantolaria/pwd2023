<template>
    <div class="crear-libro">
        <h1>Crear Libro</h1>
        <form @submit.prevent="crearLibro">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" v-model="libro.titulo" required>
            </div>
            <div class="form-group">
                <label for="autor">Autor:</label>
                <select v-model="libro.autor" multiple required>
                    <option v-for="autor in autores" :key="autor.id" :value="{id: autor.id}">{{ autor.nombre_apellido }}</option>
                </select>
                <button @click.prevent="mostrarFormularioAutorNuevo">Agregar nuevo autor</button>
            </div>
            <div v-if="mostrarFormularioNuevoAutor">
                <label for="nuevoAutor">Nuevo Autor:</label>
                <input id="nuevoAutor" v-model="nuevoAutor" required>
                <button @click.prevent="agregarNuevoAutor">Guardar Autor</button>
            </div>
            <div class="form-group">
                <label for="editorial">Editorial:</label>
                <select v-model="libro.editoriales" required>
                    <option v-for="editorial in editoriales" :key="editorial.id" :value="{ id: editorial.id, nombre: editorial.nombre }">
                        {{ editorial.nombre }}
                    </option>
                </select>
                <button @click.prevent="abrirPopup('editorial')">Agregar nueva editorial</button>
                <crear-elemento-popup
                    v-if="mostrarPopupEdi"
                    titulo="Crear nueva editorial"
                    etiqueta="Nombre de la editorial"
                    tipo="editorial"
                    :mostrar="mostrarPopupEdi"
                    :guardar="guardarEditorial"
                    :cerrar="cerrarPopupEdi">
                </crear-elemento-popup>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select v-model="libro.categorias" required>
                    <option v-for="categoria in categorias" :key="categoria.id" :value="{ id: categoria.id, descripcion: categoria.descripcion }">
                        {{ categoria.descripcion }}
                    </option>
                </select>
                <button @click.prevent="abrirPopup('categoria')">Agregar nueva categoria</button>
                <crear-elemento-popup
                    v-if="mostrarPopupCat"
                    titulo="Crear nueva categoria"
                    etiqueta="Nombre de la categoria"
                    tipo="categoria"
                    :mostrar="mostrarPopupCat"
                    :guardar="guardarCategoria"
                    :cerrar="cerrarPopupCat">
                </crear-elemento-popup>
            </div>
            <div class="form-group">
                <label for="genero">Género:</label>
                <select v-model="libro.generos" required>
                    <option v-for="genero in generos" :key="genero.id" :value="{ id: genero.id, descripcion: genero.descripcion }">
                        {{ genero.descripcion }}
                    </option>
                </select>
                <button @click.prevent="abrirPopup('genero')">Agregar nuevo genero</button>
                <crear-elemento-popup
                    v-if="mostrarPopupGen"
                    titulo="Crear nuevo genero"
                    etiqueta="Nombre del genero"
                    tipo="genero"
                    :mostrar="mostrarPopupGen"
                    :guardar="guardarGenero"
                    :cerrar="cerrarPopupGen">
                </crear-elemento-popup>
            </div>
            <div class="form-group">
                <label for="anio">Año de publicación:</label>
                <input type="number" id="anio" v-model="libro.anio" required>
            </div>
            <div class="form-group">
                <label for="cant_paginas">Cantidad de páginas:</label>
                <input type="number" id="cant_paginas" v-model="libro.cant_paginas" required>
            </div>
            <div>
                <button type="submit" class="btn-crear">Crear Libro</button>
                <router-link to="/libros" class="routerlink">
                    <button class="btn-primary">Volver</button>
                </router-link>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
import Swal from 'sweetalert2';
import axios from 'axios';
import CrearElementoPopup from '../CrearElementoPopup.vue';


export default {
    components: {
        CrearElementoPopup,
  },
    data() {
        return {
            libro: {
                titulo: '',
                autor: [],
                generos: null,
                editoriales: null,
                categorias: null,
                anio: null,
                cant_paginas: null
            },
            editoriales: [],
            categorias: [],
            generos: [],
            autorBuscado: '', 
            autores: [],
            mostrarFormularioNuevoAutor: false,
            nuevoAutor: '',
            mostrarPopupEdi: false,
            mostrarPopupCat: false,
            mostrarPopupGen: false,
            tipoElemento: "",
        };
    },
    mounted() {
        // Cargar autores
        axios.get('http://localhost:8001/apiv1/autores')
            .then(response => this.autores = response.data)
            .catch(error => console.error(error));

        // Cargar editoriales
        axios.get('http://localhost:8001/apiv1/editoriales')
            .then(response => this.editoriales = response.data)
            .catch(error => console.error(error));

        // Cargar categorías
        axios.get('http://localhost:8001/apiv1/categorias')
            .then(response => this.categorias = response.data)
            .catch(error => console.error(error));

        // Cargar géneros
        axios.get('http://localhost:8001/apiv1/generos')
            .then(response => this.generos = response.data)
            .catch(error => console.error(error));
    },
    methods: {
        mostrarCartelExito() {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: 'success',
                title: 'Libro creado con éxito',
                showConfirmButton: false,
                timer: 1600,
            });
        },
        abrirPopup(tipo) {
            switch (tipo) {
                case 'editorial':
                this.mostrarPopupEdi = true;
                break;
                case 'categoria':
                this.mostrarPopupCat = true;
                break;
                case 'genero':
                this.mostrarPopupGen = true;
                break;
                default:
                break;
            }
        },
        cerrarPopupEdi() {
            this.mostrarPopupEdi = false;
        },
        cerrarPopupCat() {
            this.mostrarPopupCat = false;
        },
        cerrarPopupGen() {
            this.mostrarPopupGen = false;
        },
        crearLibro() {
            // probamos esto porque me estaba llegando null en vez de un array de autores
            const nuevoLibro = {
                titulo: this.libro.titulo,
                autor: Array.isArray(this.libro.autor) ? this.libro.autor : [this.libro.autor],
                editoriales: {
                    id: this.libro.editoriales.id,
                    nombre: this.libro.editoriales.nombre
                },
                generos: {
                    id: this.libro.generos.id,
                    nombre: this.libro.generos.descripcion
                },
                categorias: {
                    id: this.libro.categorias.id,
                    nombre: this.libro.categorias.descripcion
                },
                anio: this.libro.anio,
                cant_paginas: this.libro.cant_paginas
            };
            //console.log(nuevoLibro);
            axios
                .post('http://localhost:8001/apiv1/libros/nuevo', nuevoLibro)
                .then(response => {
                    //console.log(response.data);
                    this.mostrarCartelExito();
                    //alert('Libro creado exitosamente') lo cambie por sweetalert2 que eran visualmente mas lindos;
                    this.$router.push('/libros')
                })
                .catch(error => {
                    console.error(error);
                    alert('Error al crear el libro');
                });
        },
        mostrarFormularioAutorNuevo() {
            this.mostrarFormularioNuevoAutor = true;
        },
        async listarAutores() {
            try {
                const response = await axios.get('http://localhost:8001/apiv1/autores');
                this.autores = response.data;
                } catch (error) {
                    console.error(error);
            }
        },
        async agregarNuevoAutor() {
                const autorExiste = this.autores.find(autor => autor.nombre_apellido === this.nuevoAutor);
                if (autorExiste) {
                    // si el autor existe, asignamos el ID al libro
                    this.libro.autor = autorExiste.id;
                    //console.log(this.libro.autor);
                } else {
                    // si el autor no existe, crea un nuevo autor y obtenemos el ID
                    try {
                        const response = await axios.post('http://localhost:8001/apiv1/autores/nuevo', {id: 0, nombre_apellido: this.nuevoAutor});
                        const nuevoAutor = response.data;

                        this.libro.autores.push(nuevoAutor.id);
                        this.autores.push(nuevoAutor);

                        this.nuevoAutor = '';
                        this.mostrarFormularioNuevoAutor = false;
                        this.listarAutores(); // hice esta carga adicional pq a veces fallaba al crear el libro pq enviaba null

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Autor creado con éxito',
                            showConfirmButton: false,
                            timer: 1600,
                        });
                        //console.log(this.libro.autor);
                    } catch (error) {
                        console.error(error);
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: 'error',
                            title: 'Error al crear el autor',
                            text: 'Hubo un problema, intenta de nuevo.',
                        });
                        return;
                    }
                }
                this.mostrarFormularioNuevoAutor = false;
                this.listarAutores();
        },
        async guardarEditorial(nuevaEditorial) {
            try {
                const response = await axios.post('http://localhost:8001/apiv1/editoriales/nuevo', { id: 0, nombre: nuevaEditorial });
                const nuevaEditorialGuardada = response.data;
                
                this.editoriales.push(nuevaEditorialGuardada);
                this.libro.editoriales = { id: nuevaEditorialGuardada.id, nombre: nuevaEditorialGuardada.nombre };

                axios.get('http://localhost:8001/apiv1/editoriales') // hice esta carga adicional pq a veces fallaba al crear el libro pq enviaba null
                    .then(response => this.editoriales = response.data)
                    .catch(error => console.error(error));

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: `Editorial creada con éxito`,
                    showConfirmButton: false,
                    timer: 1600,
                });
            } catch (error) {
                console.error(error);
                
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: 'error',
                    title: 'Error al crear la editorial',
                    text: 'Hubo un problema, intenta de nuevo.',
                });
                } finally {
                    this.cerrarPopupEdi();
            }
        },
        async guardarGenero(nuevoGenero) {
            try {
                const response = await axios.post('http://localhost:8001/apiv1/generos/nuevo', { id: 0, descripcion: nuevoGenero });
                const nuevoGeneroGuardado = response.data;

                this.generos.push(nuevoGeneroGuardado);
                this.libro.generos = { id: nuevoGeneroGuardado.id, descripcion: nuevoGeneroGuardado.descripcion };

                axios.get('http://localhost:8001/apiv1/generos') // hice esta carga adicional pq a veces fallaba al crear el libro pq enviaba null
                    .then(response => this.generos = response.data)
                    .catch(error => console.error(error));

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: `Genero creado con éxito`,
                    showConfirmButton: false,
                    timer: 1600,
                });
            } catch (error) {
                console.error(error);
                
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: 'error',
                    title: 'Error al crear el genero',
                    text: 'Hubo un problema, intenta de nuevo.',
                });
                } finally {
                    this.cerrarPopupGen();
            }
        },
        async guardarCategoria(nuevaCategoria) {
            try {
                const response = await axios.post('http://localhost:8001/apiv1/categorias/nuevo', { id: 0, descripcion: nuevaCategoria });
                const nuevaCategoriaGuardada = response.data;

                this.categorias.push(nuevaCategoriaGuardada);
                this.libro.categorias = { id: nuevaCategoriaGuardada.id, descripcion: nuevaCategoriaGuardada.descripcion };

                axios.get('http://localhost:8001/apiv1/categorias') // hice esta carga adicional pq a veces fallaba al crear el libro pq enviaba null
                    .then(response => this.categorias = response.data)
                    .catch(error => console.error(error));

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: `Categoria creada con éxito`,
                    showConfirmButton: false,
                    timer: 1600,
                });
            } catch (error) {
                console.error(error);
                
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: 'error',
                    title: 'Error al crear la categoria',
                    text: 'Hubo un problema, intenta de nuevo.',
                });
                } finally {
                    this.cerrarPopupCat();
            }
        },
    },
};
</script>

<style scoped>
    .crear-libro {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #adcfbe;
        border-radius: 5px;
        background-color: #fff;
    }

    h2 {
        margin-top: 0;
    }

    .form-group {
        margin-bottom: 10px;
        display: block;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    button {
        margin-top: 5px;
    }

    input[type="text"],
    select {
        width: 80%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    .btn-crear {
        display: block;
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #079d46;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-crear:hover {
        background-color: #079d46;
    }
    .btn-primary {
        display: block;
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: rgb(33, 112, 177);
        color: #fff;
        font-weight: bold;
        cursor: pointer;
    }
    .routerlink{
        text-decoration: none;
    }
</style>