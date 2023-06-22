<template>
    <v-dialog v-model="this.openDialog" width="500">
        <v-card style="padding: 5px">
            <v-card-title class="headline">{{ currentUserRole == 1 ? "Add New Manager" : "Add New Employee" }}</v-card-title>
            <v-card-text>
                <v-text-field label="Name" v-model="userName" :error="this.error.name"
                    :error-messages="this.error.name && this.error.name[0]"></v-text-field>
                <v-text-field label="Email" v-model="userEmail" :error="this.error.email"
                    :error-messages="this.error.email && this.error.email[0]"></v-text-field>
                <v-text-field label="Phone Number" v-model="userPhoneNumber" required />
                <v-select v-model="userDepartment" :items="departments" label="Department" item-title="name" item-value="id"
                    required></v-select>

            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red-darken-1" variant="text" @click="handelCancel">
                    Cancel
                </v-btn>
                <v-btn color="green-darken-1" variant="text" @click="addManager"
                    :disabled="userDepartment == null || userName == '' || userPhoneNumber == '' || userEmail == ''">
                    Add
                </v-btn>
            </v-card-actions>
        </v-card>

        <Alert :open="openAlert" @open-dialog = "handelOpenAlert" :message="message"/>
    </v-dialog>
</template>

<script>

import admin from '../api/admin';
import manager from '../api/manager';
import store from '../store';
import Alert from './Alert.vue';
export default {
    name: "createUser",
    props: ["openDialog"],
    components:{Alert},
    data() {
        return {
            userName: "",
            userEmail: "",
            userPhoneNumber: "",
            userDepartment: null,
            error: [],
            currentUserRole: 0,
            dialog: "true",
            departments: [],
            message:"",
            openAlert:false,

        }
    },
    mounted() {
        const currentUser = JSON.parse(localStorage.getItem("currentUser"));
        this.currentUserRole = currentUser.role;

        if (this.currentUserRole == 1) {
           
            admin.getAllDepartment()
                .then((response) => {
                    this.departments = response.data.data;
                })
                .catch((error) => {
                    console.log(error)
                })
        } 
           else if (this.currentUserRole == 2) {
            manager.getMyDepartments(currentUser.id)
                .then((response) => {
                    this.departments = response.data.data;
                })
        }

    },
   
    methods: {

        handelCancel() {
            this.error = [];
            this.userName = "";
            this.userEmail = "";
            this.userPhoneNumber = "";
            this.userDepartment = null;
            this.$emit('openDialog')
        },
        addManager() {

            const userData = {
                name: this.userName,
                email: this.userEmail,
                phoneNumber: this.userPhoneNumber,
                department_id: this.userDepartment
            }

            console.log(userData);
            
            if (this.currentUserRole == 1) {

                admin.createManager(userData)
                    .then((response) => {

                        this.openAlert = true;
                        this.message = "the manager created successfully"
                        
                        store.state.managers.push(response.data.data);
                        this.error = [];
                        this.userName = "";
                        this.userEmail = "";
                        this.userPhoneNumber = "";
                        this.userDepartment = null;


                    })
                    .catch((error) => {

                        this.error = error.response.data.errors;

                    })

            } else if (this.currentUserRole == 2) {
                manager.requestAddEmployee(userData)
                    .then((response) => {

                        this.openAlert = true;
                        console.log(response.data.message)
                        this.message = response.data.message.message

                        this.error = [];
                        this.userName = "";
                        this.userEmail = "";
                        this.userPhoneNumber = "";
                        this.userDepartment = null;

                    })
                    .catch((error) => {

                        this.error = error.response.data.errors;

                    })
            }

        },
        handelOpenAlert(){
               this.openAlert= false; 
               this.$emit('openDialog');
        },
    }


}

</script>