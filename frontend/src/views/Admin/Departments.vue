<template>
    <SearchBar type="Department" @open-dialog="showDialog" />
    <p class="text-4xl text-gray-900 font-extralight m-3">Departments:</p>

    <v-container>
        <v-row>
            <v-dialog v-model="dialog" width="500">
                <v-card style="padding: 5px">
                    <v-card-title class="headline"
                        >Add New Department</v-card-title
                    >
                    <v-card-text>
                        <v-text-field
                            label="Department Name"
                            v-model="departmentName"
                            :error="error"
                            :error-messages="errorMessage"
                        />
                        <v-select
                            v-model="select"
                            :items="managers"
                            label="Manager"
                            item-title="name"
                            item-value="id"
                            required
                        />
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="red-darken-1"
                            variant="text"
                            @click="
                                dialog = false;
                                error = false;
                                departmentName = '';
                                errorMessage = '';
                                select = null;
                            "
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            color="green-darken-1"
                            variant="text"
                            @click="createDepartment"
                            :disabled="departmentName == '' || select == null"
                        >
                            Add
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </v-container>

    <Alert :open="showAlert" />
    

    <!-- when the no departments  -->
    <v-container>
        <v-row align="center">
            <v-col
                v-for="department in departmentList"
                :key="department.id"
                cols="12"
                sm="3"
            >
                <!-- <button @click="openDialog = true ">  -->
                <Card :data="{ department }" type="Departments" />

                <!-- </button> -->
            </v-col>
        </v-row>
    </v-container>

    <main
        class="grid min-h-full place-items-center px-6 py-24 sm:py-32 lg:px-8"
       
    >

    <div class="px-5 py-2 text-xs font-medium leading-none text-center text-blue-800 bg-blue-200 rounded-full animate-pulse " v-show="showLoading">loading...</div>
        <div class="text-center"  v-if="departmentList.length == 0 && showLoading == false">
            <img
                src="../../assets/icons/nothing.png"
                class="h-25 w-25 mx-auto"
            />
            <p class="text-4xl font-normal text-gray-900">
                You Don't Have Departments
            </p>
            <p class="mt-6 text-base leading-7 text-gray-600">
                Sorry, we couldn’t find the Departments.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <button
                    @click="dialog = true"
                    class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Create Department
                </button>
            </div>
        </div>
        
      
    </main>
    <!-- </v-app> -->

    <v-dialog v-model="showAlert" width="500">
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

                <div class="text-h5 font-weight-bold">
                    The Department added Successfully
                </div>
            </div>

            <v-divider></v-divider>

            <div class="pa-4 text-end">
                <v-btn
                    class="text-none"
                    color="medium-emphasis"
                    min-width="92"
                    rounded
                    variant="outlined"
                    @click="
                        showAlert = false;
                        dialog = false;
                    "
                >
                    Close
                </v-btn>
            </div>
        </v-card>
    </v-dialog>
</template>

<script>
import Card from "../../components/Card.vue";
import SearchBar from "../../components/SearchBar.vue";

// import department from "../../api/department.js";
import admin from "../../api/admin";
import Alert from "../../components/Alert.vue";
import user from "../../api/user";
import store from "../../store";
export default {
    components: {
        Card,
        SearchBar,
        Alert,
    },
    data() {
        return {
            dialog: false,
            departmentList: [],
            departmentName: "",
            showAlert: false,
            error: false,
            errorMessage: "",
            managers: [],
            select: null,
            showLoading:true
        };
    },
    methods: {
        showDialog() {
            this.dialog = !this.dialog;
        },
        createDepartment() {
            const data = 
                {
                    name: this.departmentName,
                    manager_id: this.select,
                };
            

            console.log(data);

            admin
                .createDepartment(data)
                .then((response) => {
                    console.log(response.data);
                    this.showAlert = true;
                    this.departmentName = "";
                    this.error = false;
                    this.errorMessage = "";
                    this.select = null;

                    this.departmentList.push(response.data.data)
                    store.commit("setDepartments",this.departmentList);
                })
                .catch((error) => {
                    this.errorMessage = error.response.data.message;
                    this.error = true;
                });
        },
    },
    created() {

        if(store.state.departments.length > 0){

            this.departmentList = store.state.departments;
             
        }else {

            admin
            .getAllDepartment()
            .then((response) => {
                this.departmentList = response.data.data;
                store.commit("setDepartments",response.data.data);
            })
            .catch((error) => {
                console.log(error);
            });
        }
        
        if(store.state.managers.length>0){
                this.managers = store.state.managers;
        }else {

        admin.getAllManager().then((response) => {
            this.managers = response.data.managers;
            store.commit("setManagers",response.data.managers);
        });
    }
        this.showLoading = false; 

    },
};
</script>
