<template>
  <div class="programadores-content">
    <div class="header-programadores">
      <h1>Cliente</h1>
      <RouterLink to="/">
        <NormalButton :buttonLabel="'Volver a inicio'"></NormalButton>
      </RouterLink>
    </div>


    
    <form class="client-form">
      <label for="razon">Razón social</label>
      <input type="text" name="razon" id="" v-model="client.razon_social">
      <label for="cif">CIF</label>
      <input type="text" name="cif" id="cif" v-model="client.cif">
      <label for="direccion">Dirección</label>
      <input type="text" name="direccion" id="direccion" v-model="client.direccion">
      <label for="municipio">Municipio</label>
      <input type="text" name="municipio" id="municipio" v-model="client.municipio">
      <label for="provincia">Provincia</label>
      <input type="text" name="provincia" id="provincia" v-model="client.provincia">
      <label for="fecha-inicio">Fecha de inicio del contrato</label>
      <input type="date" name="fecha-inicio" id="fecha-inicio" v-model="client.fecha_inicio">
      <label for="fecha-fin">Fecha de fin del contrato</label>
      <input type="date" name="fecha-fin" id="fecha-fin" v-model="client.fecha_expiracion">
    </form>
    <NormalButton :buttonLabel="'Guardar cambios'" @click="saveClient"></NormalButton>
    <span>Filtrado por modelo</span>
    <div class="programadores-filters">
      <label for="a">Modelo A</label>
      <input type="checkbox" id="a" name="a" checked v-model="modeloA">
      <label for="b">Modelo B</label>
      <input type="checkbox" id="b" name="b" v-model="modeloB">
       <label for="c">Modelo C</label>
      <input type="checkbox" id="c" name="c" v-model="modeloC">
      <NormalButton :buttonLabel="'Filtrar'" @click="filter"></NormalButton>
    </div>
    <table class="clients-table">
      <thead>
        <tr>
          <th>Modelo</th>
          <th>Número de Serie</th>
          <th>Fecha de alta</th>
          <th>Fecha última conexión</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="programador in programadores.slice(inicio, fin)" :key="programador.numero_serie">
          <td>{{ programador.modelo }}</td>
          <td><RouterLink :to="`/sensores/${programador.numero_serie}`">{{ programador.numero_serie }}</RouterLink></td>
          <td>{{ programador.fecha_alta }}</td>
          <td>{{ programador.fecha_ultima_conexion }}</td>
          <td><button @click="deleteProgramador(programador)" class="btn-delete-programador">Eliminar</button></td>
        </tr>
      </tbody>
    </table>
     <TablePaginated @next="next" @previous="previous" :inicio="inicio" :fin="fin" :longitud="maxLength"/>
        <RouterLink :to="`/anadir/programador/` + route.params.codigo">
          <NormalButton :buttonLabel="'Añadir programador'" class="btn-add-programador"></NormalButton>
        </RouterLink>
     </div>
</template>
<script setup>
import { computed, onBeforeMount, onMounted, ref } from 'vue';
import TablePaginated from '../components/TablePaginated.vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import NormalButton from '../components/NormalButton.vue';
import { RouterLink } from 'vue-router';


const client = ref({});
const route = useRoute();
const router = useRouter();
async function getClient(){
  const {data} = await axios.get(`http://localhost/api/clientes/${route.params.codigo}`);
  client.value = data[0];
}
const programadores = ref([]);
const inicio = ref(0);
const fin = ref(10);
const programadoresXpage = 10;
let maxLength = computed(() => programadores.value.length);
const modeloA = ref(true);
const modeloB = ref(false);
const modeloC = ref(false);

onBeforeMount(() => {
  getClient();
});

async function saveClient() {
  const {data} = await axios.put(`http://localhost/api/clientes/update/${route.params.codigo}`, client.value);
  router.push('/');
}

async function getProgramadoresData() {
  const { data } = await axios.get(`http://localhost/api/programadores?codigo=${route.params.codigo}`);
  programadores.value = data;
}

const next = () => {
  inicio.value += programadoresXpage;
  fin.value += programadoresXpage;
}

const previous = () => {
  inicio.value -= programadoresXpage;
  fin.value -= programadoresXpage;
}

async function deleteProgramador(programador) {
  const { data } = await axios.delete(`http://localhost/api/programadores/delete/${programador.numero_serie}`);
  const index = this.programadores.indexOf(programador);
  programadores.value.splice( index ,1);
}

async function filter() { 

  let api_request = 'http://localhost/api/programadores/filter'

  const queryParams = {};
  queryParams.codigo = route.params.codigo;

  if (modeloA.value === true) {
    queryParams.modeloA = 'A';
  }
  if (modeloB.value === true) {
    queryParams.modeloB = 'B';
  }
  if (modeloC.value === true) {
    queryParams.modeloC = 'C';
  }

  const url = new URL(api_request);
  url.search = new URLSearchParams(queryParams).toString();
  const { data } = await axios.get(url);
  programadores.value = data;
}

onMounted(() => {
  getProgramadoresData();
});
</script>
<style scoped>
.programadores-content{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.header-programadores{
  display: flex;
  align-items: center;
  justify-content: center;
}

.header-programadores a{
  display: flex;
  align-items: center;
  justify-content: center;
  margin-left: 20px;
}

.data{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.clients-table{
  width: 70%;
  border-collapse: collapse;
  margin: 25px 0;
  font-size: 0.9em;
  min-width: 400px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.clients-table thead tr {
  background-color: #009879;
  color: #ffffff;
  text-align: left;
}

.clients-table th,
.clients-table td {
  padding: 12px 15px;
}

.clients-table tbody tr {
  border-bottom: 1px solid #dddddd;
}

.clients-table tbody tr:nth-of-type(even) {
  background-color: #f3f3f3;
}

.clients-table tbody tr:last-of-type {
  border-bottom: 2px solid #009879;
}
a{
  text-decoration: none;
  color: green;
}

input[type="text"],
input[type="date"]{
  font-size: 16px;
  margin-bottom: 10px;
}
label{
  margin-bottom: 5px;
}

.btn-add-programador{
  margin-top: 20px;
}

.btn-delete-programador{
  padding: 10px 20px;
  border-radius: 20px;
  border: none;
  background-color: red;
  color: white;
  margin-bottom: 20px;
  transition: all 0.3s;
}

.btn-delete-programador:hover{
  background-color: grey;
  cursor: pointer;
}
input[type="checkbox"]{
  width: 50px;
} 
</style>