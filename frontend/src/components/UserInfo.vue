<template>
    <v-card class="ma-10 w-[600px]">
        <p class="text-4xl font-thin text-gray-900 p-8">
            {{ userInfo.name }}
        </p>

        <v-container class="mb-6" style=" padding: margin:10px;">
            <v-row align="start" no-gutters style="padding: 20px">
                <v-col cols="3">
                    <p class="text-1xl text-gray-900 font-extralight">
                        Full Name
                    </p>
                </v-col>

                <v-col>
                    <p>{{ userInfo.name }}</p>
                </v-col>
            </v-row>

            <v-row align="start" no-gutters style="padding: 20px">
                <v-col cols="3">
                    <p class="text-1xl text-gray-900 font-extralight">Email</p>
                </v-col>

                <v-col>
                    <p>{{ userInfo.email }}</p>
                </v-col>
            </v-row>
            <v-row align="start" no-gutters style="padding: 20px">
                <v-col cols="3">
                    <p class="text-1xl text-gray-900 font-extralight">
                        Phone Number
                    </p>
                </v-col>

                <v-col>
                    <p>{{ userInfo.phone_number }}</p>
                </v-col>
            </v-row>

            <v-row align="start" no-gutters style="padding: 20px">
                <v-col cols="3">
                    <p class="text-1xl text-gray-900 font-extralight">
                        Department
                    </p>
                </v-col>

                <v-col>
                    <p>{{ userInfo.department_id }}</p>
                </v-col>
            </v-row>

          
        </v-container>
       
        <v-divider
            :thickness="2"
            class="border-opacity-75 m-5"
            color="primary"
        />

        <Alert :open="openAlert" @open-dialog="handelOpenAlert" :message="message"/>

        <div class="mt-6 flex items-center justify-end gap-x-6 p-5">
            <button
                type="button"
                class="rounded-md px-3 py-2 text-sm font-semibold leading-6 text-red-500 bg-red-600"
                @click="handelDenyRequest(userInfo._id)"
            >
                Deny
            </button>
            <button
                type="submit"
                class="rounded-md px-3 py-2 text-sm font-semibold leading-6 text-green-500 bg-green-600"
                v-on:click="handelApproveRequest(userInfo._id)"
            >
                Approve
            </button>
        </div>
    </v-card>
</template>

<script>
import admin from "../api/admin";
import requests from "../api/requests";
import Alert from "./Alert.vue";
export default {
    name: "UserInfo",
    props: ["userInfo", "type"],
    components:{Alert},
    data() {
        return {
            requestType: this.type,
            currentUserRole: 0,
            openAlert: false,
            message:""
        };
    },
    methods: {
        handelApproveRequest(id) {
            if (this.currentUserRole == 1) {
              
                if (this.type == 1) {
                    const data = { request_type: this.type, user_id: `${id}` };
                    admin
                        .approveManagerRequest(data)
                        .then((response) => {
                            // console.log(response);
                           
                            // this.$emit("closeDialog");
                            this.openAlert = true;
                            this.message = "the employee approved successfully"
                        })
                        .catch((error) => {
                            console.log(error);
                        });

                } else if (this.type == 2) {
                   console.log("hi");
                }

               
            }
        },
        handelDenyRequest(id) {
            console.log(id)
          admin.denyAddNewEmployeeRequest(id)
        .then(()=>{
         this.openAlert = true;
         this.message="this request is denied successfully"
      })
           
            
        },
        handelOpenAlert(){
               this.openAlert= false; 
              const user_id = this.userInfo._id
             
               this.$emit("closeDialog",user_id);

        },
    },
    mounted() {
        const currentUser = JSON.parse(localStorage.getItem("currentUser"));
        this.currentUserRole = currentUser.role;
    },
};
</script>
