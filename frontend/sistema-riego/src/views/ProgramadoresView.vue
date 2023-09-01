<template>
  <div class="programadores-content">
    <h1>Cliente</h1>
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
  <span>Buscador</span>
   <!-- <div class="search-bar">
       <input id="search" type="search" placeholder="Search..." class="searcher" v-model="busqueda"/>
      <button @click="search">Buscar</button>
      <label for="razon">Razón social</label>
      <input type="checkbox" id="razon" name="razon" checked v-model="razon">
      <label for="municipio">Municipio</label>
      <input type="checkbox" id="municipio" name="municipio" v-model="municipio">
    </div> -->

    <!-- <table class="clients-table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Cliente</th>
          <th>Fecha</th>
          <th>Direccion</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cliente in programadores.slice(inicio, fin)" :key="cliente.codigo">
          
        </tr>
      </tbody>
    </table>
     <TablePaginated @next="next" @previous="previous" :inicio="inicio" :fin="fin" :longitud="maxLength"/> -->
     </div>
</template>
<script setup>
import { computed, onBeforeMount, onMounted, ref } from 'vue';
import TablePaginated from '../components/TablePaginated.vue';
import axios from 'axios';
import { useRoute } from 'vue-router';
import NormalButton from '../components/NormalButton.vue';


const client = ref({});
const route = useRoute();
const router = useRouter();
async function getClient(){
  const {data} = await axios.get(`http://localhost/api/clientes/${route.params.codigo}`);
  client.value = data[0];
}
onBeforeMount(() => {
  getClient();
});

async function saveClient() {
  const {data} = await axios.put(`http://localhost/api/clientes/update/${route.params.codigo}`, client.value);
  router.push('/');
}
</script>
<style scoped>
.programadores-content{
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
a{
  text-decoration: none;
  color: black;
}

input[type="text"],
input[type="date"]{
  font-size: 16px;
  margin-bottom: 10px;
}
label{
  margin-bottom: 5px;
}
</style>