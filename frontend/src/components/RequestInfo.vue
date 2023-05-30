<template>
       
       <!-- <v-card
    class="mx-auto"
    width="400"
    prepend-icon="mdi-home"
  > -->
  <v-card title="Request Title" subtitle="requestID" class="ma-10 w-[600px]">


  <!-- </v-card> -->
  <v-card-title>Description</v-card-title>
  <div class="text--primary p-5">
        relating to or dependent on charity; charitable
        "an eleemosynary educational institution."
      </div>


      <v-btn
        :disabled="loading"
        :loading="loading"
        block
        class="text-none  w-6 "
        color="indigo-darken-3"
        
        variant="flat"
        @click="handelOpenFile"
      >
        Open File
      </v-btn>
    <button class="btn btn-default" @click="openDialog=true">
        open File 
       </button>
  
  </v-card>
        
       
     


      <v-dialog v-model="openDialog">
        <div class="absolute top-0 right-0 h-16 w-16 ">
          <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" @click="openDialog = false">
             
             
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
        </div>
       
        <iframe id="if1" width="95%" height="900" style="visibility:visible" src="https://www.africau.edu/images/default/sample.pdf"></iframe>
      </v-dialog>
</template>
<script>

export default{
    data(){
        return{
            openDialog:false,
            loading: false,
        }
    },
    methods:{
      handelOpenFile(){
        this.loading = true
        this.openDialog = true;
        this.loading = false
      }
    }
}
</script>