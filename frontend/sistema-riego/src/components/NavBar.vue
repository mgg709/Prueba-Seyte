<template>
  <div class="nav-bar-content">
    <span>Sistema de Gestión</span>
    <div class="nav-links">
      <RouterLink to="/">Clientes</RouterLink>
      <RouterLink to="/about">Programadores</RouterLink>
    </div>
  </div>
</template>
<script setup>
import { RouterLink } from 'vue-router'
</script>
<style scoped>

.nav-bar-content{
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #473BF0;
  height: 5rem;
  padding: 20px;
  color: white;
  font-size: 22px;
}

a{
  color: white;
  text-decoration: none;
  margin-left: 20px;
}

.nav-links{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 30%;
}

</style>