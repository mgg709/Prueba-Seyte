<template>
  <div class="sensores-content">
    <div class="header-sensores">
      <h1>Programador</h1>
      <RouterLink to="/">
        <NormalButton :buttonLabel="'Volver a inicio'"></NormalButton>
      </RouterLink>
    </div>
    <div class="btns-medidas">
      <NormalButton buttonLabel="Tomar medida S1" @click="tomarMedida('S1')"></NormalButton>
      <NormalButton buttonLabel="Tomar medida S2" @click="tomarMedida('S2')"></NormalButton>
      <NormalButton buttonLabel="Tomar medida S3" @click="tomarMedida('S3')"></NormalButton>
      <NormalButton buttonLabel="Tomar medida S4" @click="tomarMedida('S4')"></NormalButton>
    </div>
    <table class="sensores-table">
      <thead>
        <tr>
          <th>Sonda</th>
          <th>Fecha de medida</th>
          <th>Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="sensor in sensores.slice(inicio, fin)" :key="sensor.id">
          <td>{{ sensor.sonda }}</td>
          <td>{{ sensor.fecha_medida }}</td>
          <td>{{ sensor.valor }}</td>
        </tr>
      </tbody>
    </table>
    <Spinner v-if="loading"/>
    <TablePaginated @next="next" @previous="previous" :inicio="inicio" :fin="fin" :longitud="maxLength"/>
    <div  v-if="messages.length > 0" v-for="message in messages" class="messages">
        <p>{{ message }}</p>
      </div>
  </div>
</template>
<script setup>
import { useRoute } from 'vue-router';
import NormalButton from '../components/NormalButton.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Spinner from '../components/Spinner.vue';
import TablePaginated from '../components/TablePaginated.vue';


const route = useRoute();
const sensores = ref([]);
const loading = ref(false);
const inicio = ref(0);
const fin = ref(10);
const sensoresXpage = 10;
const maxLength = ref(0);
const messages = ref([]);
const currentSensoresPage = ref(1);
const lastSensoresPage = ref(1);


const next = async() => {
  inicio.value += sensoresXpage;
  fin.value += sensoresXpage;
  currentSensoresPage.value += 1;
  loading.value = true;
  console.log(currentSensoresPage.value);
  try {
    if (currentSensoresPage.value > lastSensoresPage.value) {
      const { data } = await axios.get(`http://localhost/api/sensores?numero_serie=${route.params.numero_serie}&page=${currentSensoresPage.value}`);
      data.sensores.data.map((sensor) => {
        sensores.value.push(sensor);
      });
      lastSensoresPage.value += 1;
    }
  } catch (error) {
    messages.value.push(error.response.data.message);
  } finally {
    
    loading.value = false;
  }
}

const previous = () => {
  inicio.value -= sensoresXpage;
  fin.value -= sensoresXpage;
  currentSensoresPage.value -= 1;
}

async function tomarMedida(sonda) {
  loading.value = true;
  try {
    const { data } = await axios.post(`http://localhost/api/sensores/medida?numero_serie=${route.params.numero_serie}&sonda=${sonda}`);
    sensores.value.push(data);
  } catch (error) {
    messages.value.push(error.response.data.message);
  }finally{
    loading.value = false;
  }
}


async function getSensores() {
  loading.value = true;
  try {
    const { data } = await axios.get(`http://localhost/api/sensores?numero_serie=${route.params.numero_serie}&page=1`);
    sensores.value = data.sensores.data;
    maxLength.value = data.totalSensores;
  } catch (error) {
    messages.value.push(error.response.data.message);
  } finally {
    loading.value = false;
  }
}

onMounted(() => {
  getSensores();
});
</script>
<style scoped>
.sensores-content{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.header-sensores{
  display: flex;
  align-items: center;
  justify-content: center;
}

.header-sensores a{
  display: flex;
  align-items: center;
  justify-content: center;
  margin-left: 20px;
  text-decoration: none;
}

.sensores-table{
  width: 70%;
  border-collapse: collapse;
  margin: 25px 0;
  font-size: 0.9em;
  min-width: 400px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.sensores-table thead tr {
  background-color: #009879;
  color: #ffffff;
  text-align: left;
}

.sensores-table th,
.sensores-table td {
  padding: 12px 15px;
}

.sensores-table tbody tr {
  border-bottom: 1px solid #dddddd;
}

.sensores-table tbody tr:nth-of-type(even) {
  background-color: #f3f3f3;
}

.sensores-table tbody tr:last-of-type {
  border-bottom: 2px solid #009879;
}

.btns-medidas button{
  margin-right: 20px;
}

.messages p{
    color: red;
  }
</style>