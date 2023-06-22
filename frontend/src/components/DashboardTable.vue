<template>
    
        <!-- <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center">
            <v-tab :value="1">New Employee</v-tab>
            <v-tab :value="2">New Requests</v-tab>
        </v-tabs> -->

        <v-window>
            <div class="grid grid-flow-col w-full">
                <div class="col-span-11">
                    <p class="text-4xl text-gray-900 font-extralight m-3"> {{ this.title }}</p>
                        
                    
                </div>
                <div class="col-span-1">
                    <div class="grid grid-flow-col text-center">
                        <div>
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                                Pending
                            </h5>
                            <h1>{{requests.length}}</h1>
                        </div>
                        <div>
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                                Done
                            </h5>
                            <h1>20</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 10px" >
                <div class="overflow-hidden">
                    <table class="min-w-full text-left text-sm font-light" v-show=" tab == 1 && requests.length !=0">
                        <thead class="border-b bg-white font-medium">
                            <tr>
                                <th scope="col" class="px-6 py-4" v-for="key in row">
                                    {{ key }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b bg-neutral-100 "
                                v-for="(item, index) in requests">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">
                                    {{ index + 1 }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ type == 0 ? item.name  : item.request_number}}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ type == 0 ? item.email : item.description  }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <!-- {{ item.department_id  }} -->
                                    <p v-if="type == 0"> {{ item.department_name }} </p>
                                    <span v-else>
                                      
                                          <v-chip v-if="item.status == 1" style="color: orange; background-color: #ffff99"> Pending </v-chip>
                                          <v-chip v-else-if="item.status == 2" style="color: green; background-color: #aeecad"> Done </v-chip>
       
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-1 py-1" v-show="type == 0">
                                    {{  item.phone_number }}
                                </td>
                                <td v-show="type == 0">
                                    <v-btn @click="handelOnclick(item)" size="x-small" icon="mdi-eye" />
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="min-w-full text-left text-sm font-light" v-show=" tab == 2 && requests.length !=0">
                        <thead class="border-b bg-white font-medium">
                            <tr>
                                <th scope="col" class="px-6 py-4" v-for="key in row">
                                    {{ key }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b bg-neutral-100 "
                                v-for="(item, index) in requests">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">
                                    {{ index + 1 }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ item.request_number}}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{  item.description  }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <!-- {{ item.department_id  }} -->
                                    <!-- {{ item.status  }} -->
                                    <v-chip v-if="item.status == 1" style="color: orange; background-color: #ffff99"> Pending </v-chip>
                                          <v-chip v-else-if="item.status == 2" style="color: green; background-color: #aeecad"> Done </v-chip>
                                </td>
                              
                                <td >
                                    <v-btn @click="handelOnclick(item)" size="x-small" icon="mdi-eye" />
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    
                </div>
            </div>
            <main class="grid min-h-full place-items-center px-6 py-24 sm:py-32 lg:px-8" v-if="requests.length == 0">
        <div class="text-center">
            <img src="../assets/icons/nothing.png" class="h-25 w-25 mx-auto"/>
            <p class="text-4xl font-normal text-gray-900">
                No Data
            </p>
            <p class="mt-6 text-base leading-7 text-gray-600">
                Sorry, we couldn’t find the Data.
            </p>
           
        </div>
    </main>
        </v-window>
   

      


    <v-dialog v-model="openUserInfoDialog" width="auto">
        <UserInfo :userInfo="currentData" type="1" @close-dialog="handelDialog" />
    </v-dialog>

    <v-dialog v-model="openRequestInfoDialog" width="auto">
        <RequestInfo :request="currentData" :type="this.type" :currentUserRole = "currentUserRole" @open-dialog="handelDialog"  />
    </v-dialog>
    
</template>
<script>
import UserInfo from "./UserInfo.vue";
import RequestInfo from "./RequestInfo.vue";
import admin from "../api/admin";

export default {
    name: "DashboardCard",
    props: ["data", "row","tab","type","title"],
    components: { UserInfo,RequestInfo },
    data() {
        return {
            
            requests: this.data,
            openUserInfoDialog: false,
            openRequestInfoDialog: false,
            currentData: [],
            currentUserRole:0
        };
    },
    methods: {
        handelOnclick(e) {
            
            this.currentData = e;
            // console.log(e)
             if(this.tab == 1 && this.type == 0){
                 this.openUserInfoDialog = true;
                 
            } else {
            console.log(this.currentData.request_number , "Open")
              this.openRequestInfoDialog = true; 
            }
           
        },
        handelDialog(value){
            console.log(value);

            const newRequest = this.requests.filter((request)=>{
                return request._id != value 
            });
            console.log(newRequest);
            this.requests = newRequest;
            if(this.tab == 1 && this.type == 0){
                this.openUserInfoDialog = false;
            } else {
                this.openRequestInfoDialog = false;
            }
           
           
        }
       
    },
    mounted(){
       const user = JSON.parse(localStorage.getItem("currentUser"));
        this.currentUserRole = user.role;
        console.log(this.requests)
    }

   
  
};
</script>
