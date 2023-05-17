<!-- <template>
    <div class="grid grid-flow-col gap-1 h-scree w-screen bg-slate-100">
        <div class="bg-gray-50 col-span-1" style="width: 250px">
            <div
                style="border-radius: 0px 0px 100px 0px"
                class="top-0 left-0 h-screen m-0 flex flex-col bg-blue-900 text-white text-center"
            >
                <img
                    src="../assets/images/CMSlogoWhite.png"
                    width="250"
                    height="250"
                />

                <div
                    class="h-screen"
                    style="
                        display: flex;
                        justify-content: space-between;
                        flex-direction: column;
                        height: 70%;
                    "
                >
                    <div style="width: 100px; margin: 10px">
                        <div v-for="menu in menu" style="padding: 30px">
                            <RouterLink :to="menu.destination">{{
                                menu.title
                            }}</RouterLink>
                        </div>
                    </div>

                    <div style="width: 100%">
                        <div class="grid grid-flow-row gap-2">
                            <div>
                                <img
                                    class="mx-auto h-10 w-10 rounded-full"
                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt=""
                                />
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    Judith Black
                                </p>
                                <p class="text-gray-600">CEO of Workcation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12">
            <RouterView />
        </div>
    </div>
</template> -->

<template>
    <v-card>
      <v-layout>
        <v-navigation-drawer
        expand-on-hover
        rail
      >
    
      <v-list>
          <v-list-item> 
            <img
                src="../assets/images/CMSlogo.png"
                width="200"
                height="200"
                />
        </v-list-item>
        </v-list>
  
          <v-divider></v-divider>
  
          <v-list
            :lines="false"
            density="compact"
            nav
          >
            <v-list-item
              v-for="(menu, i) in menu"
              :key="i"
              :value="menu"
              active-color="primary"
            >
              <template v-slot:prepend>
                <!-- <v-icon :icon="menu.icon"></v-icon> -->
              </template>
            <RouterLink :to="menu.destination">{{menu.title}}</RouterLink>
         
        
            
            
          
            </v-list-item>
          </v-list>
        </v-navigation-drawer>
        <v-main style="height: 100vh">   <RouterView /></v-main>
      </v-layout>
    </v-card>
  </template>

<script>
import { RouterLink, RouterView } from "vue-router";
import HomeView from "../views/HomeView.vue";
import Departments from "../views/Admin/Departments.vue";

export default {
    props: ["menu"],
    components:{
        Departments

    },
    data () {
      return {
        drawer: true,
        items: [
          { title: 'Home', icon: 'mdi-home-city' },
          { title: 'My Account', icon: 'mdi-account' },
          { title: 'Users', icon: 'mdi-account-group-outline' },
        ],
        rail: true,
      }
    },
};
</script>
