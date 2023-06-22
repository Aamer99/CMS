<template>
<h1 class="text-1xl font-extrabold tracking-tight leading-none text-white md:text-4xl lg:text-5xl m-4"> Welcome, <span class="text-lg font-normal text-gray-500 lg:text-3xl ">{{currentUser.name}} </span></h1>
<dashboardTable
        :row="myRequestListKey"
        :data="myRequests"
        :tab="1"
        title = "MY Request:"
        type = "1"
    />
</template>

<script>
import dashboardTable from '../../components/DashboardTable.vue';
import requests from "../../api/requests"
export default{
    
    components: {
        dashboardTable,
    },

    data(){
        return{
            currentUser:null,
            myRequests: [],
            myRequestListKey:["","Request Number","Description","Status"],
        }
    },
    created() {
       
        const user = JSON.parse(localStorage.getItem("currentUser")); 
        this.currentUser = user; 
        console.log(this.currentUser);
        console.log("hi")

        requests
            .myRequests(user.id)
            .then((res) => {
                console.log(res.data);
                this.myRequests = res.data.data;
                localStorage.setItem("myRequests", this.myRequests);
            })
            .catch((err) => {
                console.log(err);
            });
    },
}

</script>