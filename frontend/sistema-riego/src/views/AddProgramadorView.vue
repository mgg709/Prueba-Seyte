<template>
  <div class="form-add-programador">
    <h1>Añadir Programador</h1>
    <form action="POST" class="programador-form">
      <label for="modelo">Modelo</label>
      <select name="modelo" id="modelo" v-model="model">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
      </select>
      <label for="numero-serie">Número de serie</label>
      <input type="number" name="numero-serie" id="numero-serie" v-model="numero_serie">
      <label for="fecha-alta">Fecha de alta</label>
      <input type="date" name="fecha-alta" id="fecha-alta" v-model="fecha_alta">
    </form>
    <NormalButton class="btn-programador-form" :buttonLabel="'Añadir programador'" @click="registerProgramador"></NormalButton>
    </div>
</template>
<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import NormalButton from '../components/NormalButton.vue';


const model = ref('');
const numero_serie = ref(0);
const fecha_alta = ref('');
const fecha_conexion = new Date();
const ano = fecha_conexion.getFullYear();
const mes = (fecha_conexion.getMonth() + 1).toString();
const dia = fecha_conexion.getDate().toString();

let fecha_ultima_conexion = ano + '-' + mes + '-' + dia;

const route = useRoute();
const router = useRouter();

let programador = {
  modelo: model.value,
  numero_serie: numero_serie.value,
  fecha_alta: fecha_alta.value,
  fecha_ultima_conexion: fecha_ultima_conexion
}

async function registerProgramador() {
  programador = {
    modelo: model.value,
    numero_serie: numero_serie.value,
    fecha_alta: fecha_alta.value,
    fecha_ultima_conexion: fecha_ultima_conexion,
    clientes_codigo: route.params.codigo
  }
  const { data } = await axios.post('http://localhost/api/programadores/register', programador);
  router.push(`/programadores/${route.params.codigo}`);
}

</script>
<style scoped>
.form-add-programador{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.programador-form{
    display: flex;
    align-items: center;
    flex-direction: column;
  }

.btn-programador-form{
  margin-top: 20px;
}
</style>