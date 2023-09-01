<template>
  <button>{{buttonLabel}}</button>
</template>
<script setup>
const props = defineProps({
  buttonLabel: String
});
</script>
<style scoped>
button{
  padding: 10px 20px;
  border-radius: 20px;
  border: none;
  background-color: #009879;
  color: white;
  margin-bottom: 20px;
  transition: all 0.5s;
}

button:hover{
  background-color: grey;
  cursor: pointer;
}

</style>