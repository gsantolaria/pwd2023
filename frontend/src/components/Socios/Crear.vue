<script lang="ts">
import Swal from 'sweetalert2';
import axios from 'axios'

export default {
    data() {
        return {
            Socio:
            {
                id: "",
                nombre_apellido: "",
                direccion: "",
                telefono: "",
                fecha_alta: new Date().toISOString().substring(0, 10),
                activo: 1,
            }

        }
    },
    methods: {
        async crearSocio() {
            let socio =
            {
                id: this.Socio.id,
                nombre_apellido: this.Socio.nombre_apellido,
                direccion: this.Socio.direccion,
                telefono: this.Socio.telefono,
                activo: this.Socio.activo,
                fecha_alta: this.Socio.fecha_alta
            }

            try {
                const response = await axios.post('http://127.0.0.1:8001/apiv1/socios/nuevo', socio);
                console.log(response.data);

                Swal.fire({
                    icon: 'success',
                    title: 'Socio creado con éxito',
                    showConfirmButton: false,
                    timer: 1600,
                });

                this.$router.push('/socios');
            } catch (error) {
                
                console.error(error);

                Swal.fire({
                    icon: 'error',
                    title: 'Error al crear socio',
                    text: 'Hubo un problema al crear el socio. Por favor, intenta de nuevo.',
                });
            }

        },
    },
};
</script>

<template>
    <h2>Crear nuevo Socio</h2>

    <input v-model=Socio.nombre_apellido type="text" label='nombre y apellido' placeholder="apellido y nombre">
    <input v-model=Socio.telefono type="text" label='Telefono' placeholder="telefono">
    <input v-model=Socio.direccion type="text" label='direccion' placeholder="Direccion">

    <button @click="crearSocio()" class="boton guardar">Guardar</button>
    <router-link :to='{ name: "Socios" }'>
        <button class="boton editar">Volver</button>
    </router-link>
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
    .boton {
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
        background-color: rgb(33, 112, 177);
        color: #fff;
        border: 1px solid #079d46;
        cursor: pointer;
    }
</style>