<template>
    <h2>Actualizar Socio</h2>
    
    <input v-model=Socio.nombre_apellido type="text" label='nombre y apellido' placeholder="apellido y nombre">
    <input v-model=Socio.telefono type="text" label='Telefono' placeholder="telefono">
    <input v-model=Socio.direccion type="text" label='direccion' placeholder="Direccion">
    <div class="form-group">
        <label for="activo">Estado:</label>
        <select v-model="Socio.activo" id="activo" class="form-control">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>
    </div>
    
    <button class="actualizar" @click="ActualizarSocio(Socio)">Actualizar</button>
    <router-link :to='{ name: "Socios" }'>
        <button class="volver">Volver</button>
    </router-link>
    <clip-loader v-show="cargando" />
</template>

<script lang="ts">
import axios from 'axios';
import ClipLoader from 'vue-spinner/src/ClipLoader.vue'
import Swal from 'sweetalert2';

export default {
    components: {
        ClipLoader,
    },
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
            },
            cargando: true,
        }
    },
    created() {
        this.buscar();
    },
    methods: {
        async ActualizarSocio(Socio) {
            try {
                //console.log(Socio);
                await axios.put('http://127.0.0.1:8001/apiv1/socios/' + this.$route.params.id, Socio);
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: 'success',
                    title: 'Socio actualizado con éxito',
                    showConfirmButton: false,
                    timer: 1600,
                });

                this.$router.push('/socios');
            } catch (error) {
                console.error(error);
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: 'error',
                    title: 'Error al actualizar el socio',
                    text: 'Hubo un problema al actualizar el socio. Por favor, intenta de nuevo.',
                });
            }
        },
        async buscar() {
            const res = await axios.get('http://127.0.0.1:8001/apiv1/socios/' + this.$route.params.id);
            this.Socio = res.data;
            this.cargando = false;
            //console.log(this.Socio)
        }
    }
}
</script>

<style scope>
    .form-group {
        margin-bottom: 10px;
        display: block;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    select {
        width: 55%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }
    input {
        width: 50%;
        font-size: 1.2em;
        display: flex;
        align-content: center;
        padding: 10px;
        margin: 15px;
    }
    button {
        padding: 8px 16px;
        margin-right: 8px;
        font-size: 14px;
        cursor: pointer;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .actualizar {
        background-color: #079d46;
        color: #fff;
        border: 1px solid #079d46;
        cursor: pointer;
    }
    .volver {
        background-color: #2170b1;
        color: #fff;
        border: 1px solid #2170b1;
        cursor: pointer;
    }
</style>