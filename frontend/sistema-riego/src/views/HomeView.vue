<template>
  <div class="home-content">

    <h1>SISTEMA DE GESTIÓN DE RIEGO</h1>
    <span>Buscador</span>
    <div class="search-bar">
       <input id="search" type="search" placeholder="Search..." class="searcher" v-model="busqueda"/>
      <NormalButton buttonLabel="Buscar" @click="search"></NormalButton>
      <label for="razon">Razón social</label>
      <input type="checkbox" id="razon" name="razon" checked v-model="razon">
      <label for="municipio">Municipio</label>
      <input type="checkbox" id="municipio" name="municipio" v-model="municipio">
    </div>
    <Spinner v-if="loading"/>
    <table class="clients-table" v-if="!loading">
      <thead>
        <tr>
          <th>Código</th>
          <th>Razón social</th>
          <th>CIF</th>
          <th>Direccion</th>
          <th>Municipio</th>
          <th>Provincia</th>
          <th>Fecha de inicio</th>
          <th>Fecha de fin</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cliente in clientes.slice(inicio, fin)" :key="cliente.codigo">
          
          <td><RouterLink :to="`/programadores/${cliente.codigo}`">{{ cliente.codigo }}</RouterLink></td>
          <td>{{ cliente.razon_social }}</td>
          <td>{{ cliente.cif }}</td>
          <td>{{ cliente.direccion }}</td>
          <td>{{ cliente.municipio }}</td>
          <td>{{ cliente.provincia }}</td>
          <td>{{ cliente.fecha_inicio}}</td>
          <td>{{ cliente.fecha_expiracion}}</td>
          <td><button @click="deleteClient(cliente)" class="btn-delete-client">Eliminar</button></td>
        </tr>
      </tbody>
    </table>
    <TablePaginated @next="next" @previous="previous" :inicio="inicio" :fin="fin" :longitud="maxLength"/>
    <div  v-if="messages.length > 0" v-for="message in messages" class="messages">
      <p>{{ message }}</p>
    </div>
    <RouterLink to="/anadir/cliente"><NormalButton :buttonLabel="'Añadir cliente'" class="btn-add-client"></NormalButton></RouterLink>
  </div>
</template>
<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import TablePaginated from '../components/TablePaginated.vue';
import axios from 'axios';
import { RouterLink } from 'vue-router';
import NormalButton from '../components/NormalButton.vue';
import Spinner from '../components/Spinner.vue';

const clienteXpage = 10;
const inicio = ref(0);
const fin = ref(clienteXpage);
const clientes = ref([]);
let maxLength = computed(() => clientes.value.length);
const busqueda = ref('');
const razon = ref(true);
const municipio = ref(false);
const loading = ref(false);
const messages = ref([]);

const next = () => {
  inicio.value += clienteXpage;
  fin.value += clienteXpage;
}

const previous = () => {
  inicio.value -= clienteXpage;
  fin.value -= clienteXpage;
}

async function getData() {
  loading.value = true;
  try {
    const { data } = await axios.get('http://localhost/api/clientes');
    clientes.value = data;
  } catch (error) {
    messages.value.push(error.response.data.message);
  } finally {
    loading.value = false;
  }
}

async function deleteClient(cliente) {
  try{
    await axios.delete(`http://localhost/api/clientes/delete/${cliente.codigo}`);
    const index = this.clientes.indexOf(cliente);
    clientes.value.splice(index, 1);
  } catch (error) {
    messages.value.push(error.response.data.message);
  }
}

watch(razon, (value) => {
  if (value === true) {
    municipio.value = false;
  }
});
watch(municipio, (value) => {
  if (value === true) {
    razon.value = false;
  }
});

async function search() {
  loading.value = true;
  try {
    if (razon.value === true && busqueda.value !== '') {
      console.log(razon.value)
      console.log(busqueda.value)
      const { data } = await axios.get(`http://localhost/api/clientes/search?razon=${busqueda.value}`);
      clientes.value = data;
      console.log(data);
    } else if (municipio.value === true && busqueda.value !== '') {
      console.log('municipio')
      const { data } = await axios.get(`http://localhost/api/clientes/search?municipio=${busqueda.value}`);
      clientes.value = data;
      console.log(data);
    } else {
      const { data } = await axios.get('http://localhost/api/clientes');
      clientes.value = data;
    }
  } catch (error) {
    messages.value.push(error.response.data.message);
  } finally {
    loading.value = false;
  }
}

onMounted(getData);
</script>

<style scoped>
.home-content{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.data{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.clients-table{
  width: 80%;
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
  color: #009879;
  display: flex;
  flex-direction: column;
  justify-content: center;
  height: 100%;
}

.btn-add-client{
  margin-top: 20px;
  margin-bottom: 20px;
}

.btn-delete-client{
  padding: 10px 20px;
  border-radius: 20px;
  border: none;
  background-color: red;
  color: white;
  margin-bottom: 20px;
  transition: all 0.3s;
}

.btn-delete-client:hover{
  background-color: grey;
  cursor: pointer;
}

.searcher{
  width: 20rem;
  padding: 7px;
  border-radius: 5px;
  border: 1px solid #c8c8c8;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
  margin-right: 10px;
}

.search-bar{
  display: flex;
  flex-direction: row;
  width: 100%;
  justify-content: center;
  margin-top: 15px;
}

.search-bar button{
  margin-right: 10px;
}

input[type="checkbox"]{
  width: 20px;
  margin-right: 10px;
} 

 .messages p{
    color: red;
  }
</style>