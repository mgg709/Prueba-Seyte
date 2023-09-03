<template>
  <div class="btn-group">
    <button @click="emits('previous')" :disabled=" inicio <= 0 ? true : false" class="left-button">Anterior</button>
    <button @click="emits('next')" :disabled="fin >= longitud  ? true : false " class="right-button">Siguiente</button>
  </div>
</template>
<script setup>

const props = defineProps({
  inicio: {
    type: Number,
    required: true
  },
  fin: {
    type: Number,
    required: true
  },
  longitud: {
    type: Number,
    required: true
  }
})
const emits = defineEmits(['previous', 'next'])

</script>
<style scoped>

.left-button{
  padding: 10px 20px;
  border-radius: 20px;
  border: none;
  background-color: #2898ee;
  color: white;
  transition: all 0.5s;
  margin-right: 20px;
}
.right-button{
  padding: 10px 20px;
  border-radius: 20px;
  border: none;
  background-color: #2898ee;
  color: white;
  transition: all 0.5s;
}

.left-button:disabled{
  padding: 10px 20px;
  border-radius: 20px;
  border: none;
  background-color: rgba(40, 152, 238, 0.5);
  color: white;
  transition: all 0.5s;
  margin-right: 20px;
}
.right-button:disabled{
  padding: 10px 20px;
  border-radius: 20px;
  border: none;
  background-color: rgba(40, 152, 238, 0.5);
  color: white;
  transition: all 0.5s;
}
button:hover{
  background-color: grey;
  cursor: pointer;
}
</style>