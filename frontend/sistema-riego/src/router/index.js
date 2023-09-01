import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ProgramadoresView from '../views/ProgramadoresView.vue'
import AddClientView from '../views/AddClientView.vue'
import AddProgramadorView from '../views/AddProgramadorView.vue'
import SensoresView from '../views/SensoresView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/programadores/:codigo',
      name: 'programadores',
      component: ProgramadoresView
    },
    {
      path: '/anadir/cliente',
      name: 'anadir-cliente',
      component: AddClientView
    },
    {
      path: '/anadir/programador/:codigo',
      name: 'anadir-programador',
      component: AddProgramadorView
    },
    {
      path: '/sensores/:numero-serie',
      name: 'sensores',
      component: SensoresView
    }

  ]
})

export default router
