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

    <boton class="edit" @click="ActualizarSocio(Socio)" texto="Actualizar"></boton>
    <router-link :to='{ name: "Socios" }'>
        <boton class="primary" texto="Volver"></boton>
    </router-link>
    
</template>

<script lang="ts">
import axios from 'axios';
import Boton from '../Boton.vue';
import Swal from 'sweetalert2';

export default {
    components: { Boton },
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
    created() {
        this.buscar()
    },
    methods: {
        async ActualizarSocio(Socio) {
            try {
                //console.log(Socio);
                await axios.put('http://127.0.0.1:8001/apiv1/socios/' + this.$route.params.id, Socio);

                Swal.fire({
                    icon: 'success',
                    title: 'Socio actualizado con éxito',
                    showConfirmButton: false,
                    timer: 1600,
                });

                this.$router.push('/socios');
            } catch (error) {
                console.error(error);

                Swal.fire({
                    icon: 'error',
                    title: 'Error al actualizar el socio',
                    text: 'Hubo un problema al actualizar el socio. Por favor, intenta de nuevo.',
                });
            }
        },
        async buscar() {
            const res = await axios.get('http://127.0.0.1:8001/apiv1/socios/' + this.$route.params.id);
            this.Socio = res.data;
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
</style>