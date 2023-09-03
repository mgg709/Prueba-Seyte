<template>
  <div class="form-add-client">
    <h1>Añadir Cliente</h1>
    <form action="POST" class="client-form">
      <label for="razon">Razón social</label>
      <input type="text" name="razon" id="razon" v-model="razon">
      <label for="cif">CIF</label>
      <input type="text" name="cif" id="cif" v-model="cif">
      <label for="direccion">Dirección</label>
      <input type="text" name="direccion" id="direccion" v-model="direccion">
      <label for="municipio">Municipio</label>
      <input type="text" name="municipio" id="municipio" v-model="municipio">
      <label for="provincia">Provincia</label>
      <input type="text" name="provincia" id="provincia" v-model="provincia">
      <label for="fecha-inicio">Fecha de inicio del contrato</label>
      <input type="date" name="fecha-inicio" id="fecha-inicio" v-model="fechaInicio">
      <label for="fecha-fin">Fecha de fin del contrato</label>
      <input type="date" name="fecha-fin" id="fecha-fin" v-model="fechaFin">
    </form>
    <Spinner v-if="loading"/>
    <button @click="register" class="create-client">Crear cliente</button>
  </div>
</template>
<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Spinner from '../components/Spinner.vue';

const razon = ref('');
const cif = ref('');
const direccion = ref('');
const municipio = ref('');
const provincia = ref('');
const fechaInicio = ref('');
const fechaFin = ref('');
const router = useRouter();
const loading = ref(false);

let client = {
  razon_social: razon.value,
  cif: cif.value,
  direccion: direccion.value,
  municipio: municipio.value,
  provincia: provincia.value,
  fecha_inicio: fechaInicio.value,
  fecha_expiracion: fechaFin.value
}

async function register() {

  loading.value = true;
  client ={
  razon_social: razon.value,
  cif: cif.value,
  direccion: direccion.value,
  municipio: municipio.value,
  provincia: provincia.value,
  fecha_inicio: fechaInicio.value,
  fecha_expiracion: fechaFin.value
}
  console.log(client);
  const { data } = await axios.post('http://localhost/api/clientes/register', client);
  loading.value = false;
  router.push('/');

}
</script>
<style>
  .form-add-client{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .client-form{
    display: flex;
    align-items: center;
    flex-direction: column;
  }

  .create-client{
    padding: 10px 20px;
    border-radius: 20px;
    border: none;
    background-color: #009879;
    color: white;
    margin-top: 20px;
    transition: all 0.5s;
  }

  .create-client:hover{
    background-color: white;
    color: black;
    border: 1px solid #009879;
  }

  input{
    padding: 5px 20px;
    width: 15vw;
  }
</style>
