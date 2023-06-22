import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import store from '../store'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior() {
    return { top: 0, left: 0 }
  },
  routes: [
  
    {
      path: '/reset-password',
      name: 'ResetPassword',
      component: ()=> import('../views/RestPasswordView.vue')
    },
      {
      path: '/login',
      name: 'Login',
      component: ()=> import('../views/LoginView.vue')
    },
    {
      path: '/admin/',
      name: 'AdminHome',
      redirect:{path:"/admin/"},
      props:true,
      component: ()=> import('../components/SideBar.vue'),
     
      //props:{ menu:[{"title":"Dashboard","destination":"/admin"},{"title":"Departments","destination":"/admin/department"},{"title":"Managers","destination":"/admin/managers"},{"title":"Requests","destination":"/admin/requests"},{"title":"Send Message","destination":"/admin/send-message"}]},
      children:[
        {
          path: '/admin/department',
          name: 'Department',
          component: ()=> import('../views/Admin/Departments.vue')
        },
        {
          path: '/admin/',
          name: 'Dashboard',
          component: ()=> import('../views/Admin/Dashboard.vue'),
          props:true,
        },
        {
          path: '/admin/requests',
          name: 'ManagerRequests',
          component: ()=> import('../views/Admin/ManagerRequests.vue')
        },
        {
          path: '/admin/managers',
          name: 'Managers',
          component: ()=> import('../views/Admin/Managers.vue')
        },
        {
          path: '/admin/send-message',
          name: 'adminSendMessage',
          component: ()=> import('../components/SendMessage.vue')
        },
        {
          path: '/:name/profile',
          name: 'Profile',
          component: ()=> import('../components/Profile.vue'),
          props: {type:0},
          meta:{requiresAuth: true,}
        }
      ]
    },

    {
      path:"/manager",
      name:"Manager",
      redirect:"/manager/",
      component: ()=> import('../components/SideBar.vue'),
      children:[
        {
          path:"/manager/",
          name:"ManagerDashboard",
          component:()=> import("../views/Manager/Dashboard.vue")
        },
        {
          path:"/manager/employee",
          name:"Employee",
          component:()=> import("../views/Manager/Employee.vue")
        },
        {
          path:"/manager/employee/requests",
          name:"EmployeeRequests",
          component: ()=> import('../views/Admin/ManagerRequests.vue')
        },
        {
          path:"/manager/my-request",
          name:"MyRequest",
          component: ()=> import('../views/Manager/MyRequests.vue')
        },
        {
          path: '/manager/send-message',
          name: 'SendMessage',
          component: ()=> import('../components/SendMessage.vue')
        },
      ]
    },

    {
      path:"/employee",
      name:"EmployeeHome",
      redirect:"/employee/",
      component: ()=> import('../components/SideBar.vue'),
      children:[
        {
          path:"/employee/",
          name:"EmployeeDashboard",
          component:()=> import("../views/Employee/Dashboard.vue")
        },
       
        {
          path:"/employee/my-request",
          name:"MyRequests",
          component: ()=> import('../views/Manager/MyRequests.vue')
        },
      ]
    },

 
  
  ]
})

// router.beforeEach(async (to, from) => {
//   if (
    
//     !store.state.token &&
    
//     to.name !== 'Login'
//   ) {
    
//     return { name: 'Login' }
//   }
// })

export default router
