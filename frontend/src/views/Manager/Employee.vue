<template>
    <SearchBar type="Managers" @open-dialog="showDialog" />

<p class="text-4xl text-gray-900 font-extralight m-3">Employee:</p>


<div class="flex items-center p-2" >
                        <div class="rounded-full focus:outline-none focus:ring-2   focus:bg-indigo-50 focus:ring-indigo-800"  v-for="department ,index in employeeList">
                            <button :class="currentDepartment == index ?  'bg-indigo-100 rounded-full text-indigo-700 py-2 px-8': 'text-gray-600 py-2 px-8'" @click="onclickDepartment(department.employees,index)">
                                <p>{{ department.name}}</p>
                            </button>
                        </div>
                        <!-- <a class="rounded-full focus:outline-none focus:ring-2 focus:bg-indigo-50 focus:ring-indigo-800 ml-4 sm:ml-8" href="javascript:void(0)">
                            <div class="py-2 px-8 text-gray-600 hover:text-indigo-700 hover:bg-indigo-100 rounded-full ">
                                <p>Done</p>
                            </div>
                        </a>
                        <a class="rounded-full focus:outline-none focus:ring-2 focus:bg-indigo-50 focus:ring-indigo-800 ml-4 sm:ml-8" href="javascript:void(0)">
                            <div class="py-2 px-8 text-gray-600 hover:text-indigo-700 hover:bg-indigo-100 rounded-full ">
                                <p>Pending</p>
                            </div>
                        </a> -->
                    </div>


<v-container>
        <v-row align="center">

            <v-col v-for="user in departmentEmployeeList" :key="user.id" cols="12" sm="3"> 
                <!-- <button @click="openDialog = true ">  -->
                    <Card :data={user}  type="employee"/>
                   
                <!-- </button> -->
               
             </v-col>

        </v-row>
    </v-container>

    <!--  create new employee --> 
    
    <createUser  :openDialog="dialog" @open-dialog="showDialog"/>

    <!--    if there no data -->
    <main class="grid min-h-full place-items-center px-6 py-24 sm:py-32 lg:px-8" v-if="employeeList.length == 0">
        <div class="text-center">
            <img src="../../assets/icons/nothing.png" class="h-25 w-25 mx-auto"/>
            <p class="text-4xl font-normal text-gray-900">
                You Don't Have Departments
            </p>
            <p class="mt-6 text-base leading-7 text-gray-600">
                Sorry, we couldn’t find the Employees.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <button
                    @click="dialog = true"
                    class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" >
                    Create Employee
                </button>
            </div>
        </div>
    </main>


</template>

<script>
import manager from '../../api/manager';

import Card from '../../components/Card.vue';
import createUser from '../../components/createUser.vue';
import SearchBar from '../../components/SearchBar.vue';
export default {
    components:{Card,createUser,SearchBar},
    data(){
        return{
            employeeList:[],
            dialog:false,
            createUser:[],
            currentDepartment: 0,
            departmentEmployeeList:[]
        }
    },
    methods:{
        showDialog(){
            this.dialog = !this.dialog
            console.log(this.dialog)
        },

        onclickDepartment(departmentUsers,index){
           console.log(departmentUsers,index);
           this.currentDepartment = index;
           this.departmentEmployeeList = departmentUsers;
        }
    },
    created() {
         console.log("hi")
        const user = JSON.parse(localStorage.getItem("currentUser"));
        console.log(user.id) 
        manager.getEmployee(user.id)
            .then((response) => {
               console.log(response)
               this.employeeList = response.data.data 
                this.departmentEmployeeList= this.employeeList[0].employees;
               
                
            })
            .catch((error) => {
                console.log(error);
            });
        

        
    }
}

</script>