
<template>
    <div class="h-screen" style="padding: 10px">
    
        <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center" @click="handelClickTab">
            <v-tab :value="1" >New Employee</v-tab>
            <v-tab :value="2">New Requests</v-tab>
        </v-tabs>

            <dashboardTable v-if="tab==1" :row="employeesListKey" :data="employees" :tab="tab"   type = 0 />
            <dashboardTable  v-else-if="tab == 2" :row="requestListKey" :data="requests" :tab="tab" type = 0 />


        
    </div>
</template>
<script>
import dashboardTable from '../../components/DashboardTable.vue';
import admin from '../../api/admin';
import requests from "../../api/requests";
import store from '../../store';
import { useRouter } from 'vue-router';

// console.log("the stor is "+store.state.name);
// console.log("user is "+store.state.user); 
// console.log("token is "+ store.state.token);
// store.commit("setUser",[{id:0,name:"aaa"},{id:1,name:"dd"}]);
// store.commit("setToken","SSSSS");

export default{

    data(){
        return{
            tab: 1,
            employees:[],
            employeesListKey:[" ","name","email","department","phone number"," "],
            requestListKey:[" ","Request Number	","Description","Status"," "],
            requests:[],
            currentData:[],
            row:[]
        }
    },
    components:{
        dashboardTable
    },

created(){

    admin.allAddEmployeeRequest()

     .then((response)=>{
       
       this.employees = response.data.data;
       this.currentData = response.data.data;
       this.row = this.employeesListKey;
       console.log(response)
      })
    .catch((error)=>{
   console.log(error)
    })


    requests.getManagerRequests().then((response) => {
                this.requests = response.data.request;
                console.log(response.data.request);
            });
},
methods:{
    handelClickTab(){
        if(this.tab ==1){
            this.currentData = this.employees;
            this.row = this.employeesListKey
        }else if(this.tab ==2){
            this.currentData == this.requests;
            this.row = this.requestListKey;
        }
    }
},
mounted(){
    const router = useRouter();
    console.log("the router is", router);
}


}

</script>