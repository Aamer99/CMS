<template>
 
  <v-card class="ma-10 w-[600px]">

    <p class="text-4xl font-thin text-gray-900 p-8">

      {{request.request_number}} 
    </p>

    <v-container class=" mb-6" style=" padding: margin:10px;">

      <v-row align="start" no-gutters style=" padding: 20px;">
        <v-col cols="3">
          <p class="text-1xl text-gray-900 font-extralight ">Status</p>

        </v-col>

        <v-col>
          <v-chip v-if="request.status == 1" style="color: orange; background-color: #ffff99"> Pending </v-chip>
          <v-chip v-else-if="request.status == 2" style="color: green; background-color: #aeecad"> Done </v-chip>
        </v-col>

      </v-row>
      <v-row align="start" no-gutters style="padding: 20px;">
        <v-col cols="3">
          <p class="text-1xl text-gray-900 font-extralight ">Created By</p>
        </v-col>

        <v-col>
          <div class="flex items-center space-x-4">
            <img class="w-10 h-10 rounded-full"
              src="https://politics.princeton.edu/sites/default/files/styles/square/public/images/p-5.jpeg?h=87dbaab7&itok=ub6jAL5Q"
              alt="">
            <div class="font-medium dark:text-white">
              <div>{{ request.owner.name }}</div>

            </div>
          </div>
        </v-col>

      </v-row>
      <v-row align="start" no-gutters style="padding: 20px;">
        <v-col cols="3">
          <p class="text-1xl text-gray-900 font-extralight ">Created At</p>
        </v-col>

        <v-col>
          <p>{{ formateDate(request.created_at)}} </p>
        </v-col>

      </v-row>

    </v-container>
    <!-- </v-card> -->
    <v-divider :thickness="2" class="border-opacity-75 m-5" color="primary" />
    <p class="text-2xl text-gray-900 font-extralight p-4">Description</p>
    <p class="tracking-tighter text-gray-500 md:text-lg p-3 m-5">{{ request.description }}</p>

 <Alert :open="openAlert" @open-dialog="handelOpenOtp" :message="message"/>
 
   


  <div class="mt-6 flex items-center justify-end gap-x-6 p-5" v-show="type == 0 ">
    <button type="button" class="rounded-md  px-3 py-2 text-sm font-semibold leading-6 text-red-500 bg-red-600" @click="denyRequest">Deny</button>
    <button type="submit" class="rounded-md  px-3 py-2 text-sm font-semibold leading-6 text-green-500 bg-green-600" @click="approvedRequest" >Approve</button>
  </div>

</v-card>





  <!-- <v-dialog v-model="openDialog">
        <div class="absolute top-0 right-0 h-16 w-16 ">
          <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" @click="openDialog = false">
             
             
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
        </div>
       
        <iframe id="if1" width="95%" height="900" style="visibility:visible" src="https://www.africau.edu/images/default/sample.pdf"></iframe>
      </v-dialog> -->
</template>
<script>
import admin from '../api/admin';
import manager from '../api/manager';
import requests from '../api/requests';
import Alert from "./Alert.vue";


export default {
  props: ["request","type","currentUserRole"],
  components:{
    Alert
  },
  data() {
    return {
      openDialog: false,
      loading: false,
      request: this.request,
      openAlert:false,
      message:""
    }
  },
  methods: {
    handelOpenFile() {
      // this.loading = true
      // this.openDialog = true;
      // this.loading = false
      alert("hi")
    },
    approvedRequest(){

      if(this.currentUserRole == 1 ){

       
        const data = { request_type: 2, request_id: this.request.id };
        
        admin.approveManagerRequest(data)
        .then(()=>{
             
             this.openAlert = true;
             this.message="this request is approved successfully"
        })
      
        
      } else if(this.currentUserRole == 2){
        manager.approvedEmployeeRequests(this.request.id)
        .then(() =>{
          this.openAlert = true;
             this.message="this request is approved successfully"
        })
      }
    },
    denyRequest(){

      if(this.type == 1 && this.currentUserRole == 1){

        admin.denyAddNewEmployeeRequest(this.request.id)
        .then(()=>{
         this.openAlert = true;
         this.message="this request is denied successfully"
      })
      }
      requests.denyRequest(this.request.id)
      .then(()=>{
        this.openAlert = true;
        this.message="this request is denied successfully"
      })
    },

    handelOpenOtp(){
      this.openAlert = false;
      this.$emit("openDialog");

    },
    formateDate(date){
      console.log(date)
      var d = new Date(date),
      month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

      if (month.length < 2) 
        month = '0' + month;
      if (day.length < 2) 
        day = '0' + day;

      return [year, month, day].join('-');
    }
    

  },

}
</script>