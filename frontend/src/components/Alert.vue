<template>

<v-dialog v-model="this.open" width="500">
        <v-card style="padding: 5px">
  
     
     
          <!-- <template v-slot:append>
            <v-btn icon="$close" variant="text" @click="dialog = false"></v-btn>
          </template> -->
  
          <v-divider></v-divider>
  
          <div class="py-12 text-center">
            <v-icon
              class="mb-6"
              color="success"
              icon="mdi-check-circle-outline"
              size="128"
            ></v-icon>
  
            <div class="text-h4 font-weight-bold">{{this.message}}</div>
          </div>
  
          <v-divider></v-divider>
  
          <div class="pa-4 text-end">
            <v-btn
              class="text-none"
              color="medium-emphasis"
              min-width="92"
              rounded
              variant="outlined"
              @click="$emit('openDialog')"
            >
              Close
            </v-btn>
          </div>
        </v-card>
    
</v-dialog>
  </template>

  <script>

export default{
    name:"Alert",
    props:["open","message"],
    data(){
        return{
            dialog:this.open
        }
    }
}

</script>