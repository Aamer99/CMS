<template>
    <v-tabs
        v-model="tab"
        color="deep-purple-accent-4"
        align-tabs="center"
        @click="handelClickTab"
    >
        <v-tab :value="1">My Requests</v-tab>
        <v-tab :value="2">New Employee Requests</v-tab>
    </v-tabs>

    <dashboardTable
        v-if="tab == 1"
        :row="myRequestListKey"
        :data="myRequests"
        :tab="tab"
        type = "1"
    />
    <dashboardTable
        v-else-if="tab == 2"
        :row="employeeRequestsListKey"
        :data="employeeRequests"
        :tab="tab"
        type="0"
    />
</template>

<script>

import requests from '../../api/requests';
import dashboardTable from '../../components/DashboardTable.vue';
import store from '../../store';
export default {
    components: {
        dashboardTable,
    },
    data(){
        return{
         tab:1,
        myRequestListKey:["","Request Number","Description","Status"],
        myRequests:[],
        employeeRequests:[],
        employeeRequestsListKey:["","Request Number","Description","Status",""],
        }
    },
    created(){
        const user =  JSON.parse(localStorage.getItem("currentUser"));
        requests.myRequests(user.id)
        .then((res)=>{
            console.log(res.data);
            this.myRequests = res.data.data;
            localStorage.setItem("myRequests", JSON.stringify(this.myRequests));
        })
        .catch((err)=>{
            console.log(err);
        })

         requests.getEmployeeRequests(user.id)
            .then((response) => {
                console.log(response.data.data[0].requests);
                 const requests = response.data.data;

                 this.employeeRequests = requests[0].requests
            })
            .catch((error) => {
               console.log(error); 
            })
    }
};
</script>
