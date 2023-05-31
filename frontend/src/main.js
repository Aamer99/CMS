import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './style.css'
// import store from "./store"
import ApexCharts from 'apexcharts'
import {createStore} from "vuex"

//import './plugins/bootstrap-vue'
// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import "@mdi/font/css/materialdesignicons.css";

// 

const store = createStore({
  state(){
    return{
    counter : 0
 }
  }
})


const vuetify = createVuetify({
  components,
  directives,
})

const app = createApp(App)
app.use(store);
app.use(router)
app.use(vuetify)

app.mount('#app')
