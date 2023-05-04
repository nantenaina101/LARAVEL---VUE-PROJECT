import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Students from '../views/students/Students.vue'
import AddStudent from '../views/students/AddStudent.vue'
import EditStudent from '../views/students/EditStudent.vue'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      alias: ['/home', '/homepage'],
    },
    /*{
        path: '/home',
        redirect: '/',
    },*/
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/students',
      name: 'students',
      component: Students
    },
    {
      path: '/add',
      name: 'addStudent',
      component: AddStudent
    },
    {
      path: '/edit/:id',
      name: 'editStudent',
      component: EditStudent
    }
  ]
})

export default router
