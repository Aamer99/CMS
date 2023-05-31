<template>
   
    <SearchBar type="Department" @open-dialog="showDialog"/>
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
                        ></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="red-darken-1"
                            variant="text"
                            @click="dialog = false"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            color="green-darken-1"
                            variant="text"
                            @click="dialog = false"
                        >
                            Add
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </v-container>
    <!-- when the no departments  -->
    <main class="grid min-h-full place-items-center px-6 py-24 sm:py-32 lg:px-8" >
        <div class="text-center">
            <img src="../../assets/icons/nothing.png" class="h-25 w-25 mx-auto"/>
            <p class="text-4xl font-normal text-gray-900">
                You Don't Have Departments
            </p>
            <p class="mt-6 text-base leading-7 text-gray-600">
                Sorry, we couldn’t find the Departments.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <button
                    @click="dialog = true"
                    class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" >
                    Create Department
                </button>
            </div>
        </div>
    </main>
    <!-- </v-app> -->
</template>

<script>
import Card from "../../components/Card.vue";
import SearchBar from "../../components/SearchBar.vue";
import departmentAPI from "../../api/department.js";
import department from "../../api/department.js";
export default {
    components: {
        Card,
        SearchBar,
    },
    data() {
        return {
            dialog: false,
            departmentList:[],
        };
    },
    methods: {
        showDialog() {
            this.dialog = !this.dialog;
        },
    },
    mounted(){
    //     department.all()
    //     .try((res)=>{
    //         console.log(res);
    //     })
    //     .catch((err)=>{
    //         console.log("hi")
    //         console.log(err);
    //     })
    console.log("hi")
     }
    
};
</script>
