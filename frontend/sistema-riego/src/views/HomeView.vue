<template>
  <div class="home-content">

    <h1>SISTEMA DE GESTIÓN DE RIEGO</h1>
    <span>Buscador</span>
    <SearchInput />
   

    <table class="clients-table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Cliente</th>
          <th>Fecha</th>
          <th>Direccion</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cliente in clientes.slice(inicio, fin)" :key="cliente.codigo">
          <td>{{ cliente.codigo }}</td>
          <td>{{ cliente.razon_social }}</td>
          <td>{{ cliente.cif }}</td>
          <td>{{ cliente.direccion }}</td>
        </tr>
      </tbody>
    </table>
     <TablePaginated @next="next" @previous="previous" :inicio="inicio" :fin="fin" :longitud="maxLength"/>
  </div>
</template>
<script setup>
import { computed, onMounted, ref } from 'vue';
import TablePaginated from '../components/TablePaginated.vue';
import axios from 'axios';
import SearchInput from '../components/SearchInput.vue';

const clienteXpage = 10;
const inicio = ref(0);
const fin = ref(clienteXpage);
const clientes = ref([]);
let maxLength = computed(() => clientes.value.length);


const next = () => {
  inicio.value += clienteXpage;
  fin.value += clienteXpage;
}

const previous = () => {
  inicio.value -= clienteXpage;
  fin.value -= clienteXpage;
}

async function getData(){
  const { data } = await axios.get('http://localhost/api/clientes'); 
  clientes.value = data;
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
</style>