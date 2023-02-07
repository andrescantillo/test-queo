import { createRouter, createWebHistory } from 'vue-router'
import MainLayout from '../layouts/MainLayout.vue'
import HomeView from '../views/HomeView.vue'
import EmployeesView from '../views/EmployeesView.vue'
import CompaniesView from '../views/CompaniesView.vue'
import LoginView from '../views/LoginView.vue'

const routes = [
  {
    path: '/',
    component : LoginView
  },{
    path: '/home',
    name: 'Inicio',
    component: MainLayout,
    children : 
    [
      {
        path: '/companies',
        name: 'Empresas',
        component: CompaniesView
      },
      {
        path: '/employees',
        name: 'Empleados',
        component: EmployeesView
      }
    ],
  },

]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
