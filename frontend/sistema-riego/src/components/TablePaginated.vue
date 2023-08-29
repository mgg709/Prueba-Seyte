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
<style scoped></style>