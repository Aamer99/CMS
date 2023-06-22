<template>
    <SearchBar type="Managers" @open-dialog="showDialog" />
    <p class="text-4xl text-gray-900 font-extralight m-3">Managers:</p>

    <!-- <v-container>
        <v-row>
            <v-col md="auto" sm="12">
                <Card type="Departments" />
            </v-col>
            <v-col md="auto" sm="12">
                <Card type="Departments" />
            </v-col>
            <v-col md="auto" sm="12">
                <Card type="Departments" />
            </v-col>
        </v-row>
    </v-container> -->
    <!-- Add New Manager  -->
    <!-- <v-dialog v-model="dialog" width="500">
        <v-card style="padding: 5px">
            <v-card-title class="headline">Add New Manager</v-card-title>
            <v-card-text>
                <v-text-field
                            label="Name"
                            v-model="managerName"
                            :error="this.error.name" 
                            :error-messages="this.error.name&& this.error.name[0]"

                        ></v-text-field>
                <v-text-field
                            label="Email"
                            v-model="managerEmail"
                            :error="this.error.email" 
                            :error-messages="this.error.email  && this.error.email[0]"
                         

                        ></v-text-field>
                <v-text-field
                    label="Phone Number"
                    v-model="managerPhoneNumber"
                    required
                />
                <v-select
                    v-model="select"
                    :items="departments"
                    label="Department"
                    item-title="name"
                    item-value="id"
                    required
                ></v-select>
   
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="red-darken-1"
                    variant="text"
                    @click="handelCancel"
                >
                    Cancel
                </v-btn>
                <v-btn
                    color="green-darken-1"
                    variant="text"
                    @click="addManager"
                    :disabled = "select  == null || managerName == ''|| managerPhoneNumber == '' || managerEmail ==''"
                >
                    Add
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog> -->

    <createUser :openDialog="dialog" @open-dialog="showDialog" />

    <!-- <v-dialog v-model="showAlert" width="500">
                <v-card style="padding: 5px">
  
     

          <v-divider></v-divider>
  
          <div class="py-12 text-center">
            <v-icon
              class="mb-6"
              color="success"
              icon="mdi-check-circle-outline"
              size="128"
            ></v-icon>
  
            <div class="text-h5 font-weight-bold">The Manager added Successfully</div>
          </div>
  
          <v-divider></v-divider>
  
          <div class="pa-4 text-end">
            <v-btn
              class="text-none"
              color="medium-emphasis"
              min-width="92"
              rounded
              variant="outlined"
              @click="dialog = false"
            >
              Close
            </v-btn>
          </div>
        </v-card>
    
</v-dialog> -->

<v-container>
        <v-row align="center">

            <v-col v-for="manager in managers" :key="manager.id" cols="12" sm="3">
                <!-- <button @click="openDialog = true ">  -->
                  
                    <Card :data="manager" type="Managers"/>
                   
                <!-- </button> -->
               
            </v-col>

        </v-row>
    </v-container>

    <!-- if there no managers -->
     <main
        class="grid min-h-full place-items-center px-6 py-24 sm:py-32 lg:px-8" v-show="managers.length == 0"
    >
        <div class="text-center">
            <img
                src="../../assets/icons/error.png"
                class="h-auto max-w-lg mx-auto"
            />
            <p class="text-4xl font-normal text-gray-900">
                You Don't Have Managers
            </p>
            <p class="mt-6 text-base leading-7 text-gray-600">
                Sorry, we couldn’t find Managers.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <button
                    @click="dialog = true"
                    class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Create Manager
                </button>
            </div>
        </div>
    </main> 
</template>

<script>
import Card from "../../components/Card.vue";
import SearchBar from "../../components/SearchBar.vue";
import admin from "../../api/admin";
import createUser from "../../components/createUser.vue";
import store from "../../store";
export default {
    components: {
        Card,
        SearchBar,
        createUser,
    },
    data() {
        return {
            dialog: false,
            departments: [],
            managers: [],
            select: null,
            managerName: "",
            managerEmail: "",
            managerPhoneNumber: "",
            showAlert: false,
            error: [],
        };
    },
    methods: {
        handelCancel() {
            this.dialog = false;
            this.managerEmail = "";
            this.managerName = "";
            this.managerPhoneNumber = "";
            this.error = [];
            this.select = null;
        },
        showDialog() {
            this.dialog = !this.dialog;
        },
        addManager(){
            const managerData= {
                name:this.managerName,
                email:this.managerEmail,
                phoneNumber:this.managerPhoneNumber,
                department_id:this.select
            }
               console.log(managerData)
               console.log("hh")
            admin.createManager(managerData)
            .then((response)=>{
                this.dialog = false;
                this.showAlert = true
                
            })
            .catch((error)=>{

                this.error =error.response.data.errors;
                console.log(JSON.stringify(this.error.name.toString()));
            })

        }
    },
    created() {

        if(store.state.managers.length >0 ){

             this.managers = store.state.managers;
        }else {
        admin.getAllManager()
            .then((response) => {
                this.managers = response.data.managers;
                store.commit("setManagers",response.data.managers);
                
            })
            .catch((error) => {
                console.log(error);
            });
        }
    },
};
</script>
