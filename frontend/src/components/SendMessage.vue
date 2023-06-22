<template>
    <p class="text-4xl text-gray-900 font-extralight m-5">Send Message:</p>

    <main class="grid min-h-full place-items-center py-24 lg:px-8">
        <div
            class="p-6 bg-white border border-gray-200 rounded-lg shadow md:w-5/6 lg:w-1/2 max-md:w-full sm:w-full sm:bg-gray-900"
        >
            <v-container class="mb-6">
                <v-row justify="space-between">
                    <v-col clos="4">
                        <p>From</p>
                    </v-col>
                    <v-col cols="8">
                        <p>{{ currentUserEmail }}</p>
                    </v-col>
                </v-row>

                <v-row justify="space-between" v-show="currentUserRole == 2">
                    <v-col cols="4">
                        <p>Department</p>
                    </v-col>
                    <v-col cols="8">
                        <v-select
                            v-model="selectedDepartment"
                            :items="departmentList"
                            label="Department"
                            item-title="name"
                            item-value="name"
                            required
                        ></v-select>
                    </v-col>
                </v-row>

                <v-row
                    justify="space-between"
                    v-show="currentUserRole == 1 || users.length > 0"
                >
                    <v-col cols="4">
                        <p>To</p>
                    </v-col>
                    <v-col cols="8">
                        <v-select
                            v-model="selectedUsers"
                            :items="users"
                            label="User"
                            item-title="name"
                            item-value="id"
                            required
                            multiple
                            persistent-hint
                            return-object
                        >
                            <template v-slot:prepend-item>
                                <v-list-item
                                    title="Select All"
                                    @click="handelOnSelectAllUsers"
                                >
                                    <template v-slot:prepend>
                                        <v-checkbox-btn :model-value="selectedAllUsers"></v-checkbox-btn>
                                    </template>
                                </v-list-item>

                                <v-divider class="mt-2"></v-divider>
                            </template>
                        </v-select>
                     
                    </v-col>
                </v-row>

                <v-row justify="space-between">
                    <v-col clos="12">
                        <v-textarea
                            clearable
                            label="Type Here..."
                            
                            v-model="message"
                        ></v-textarea>
                    </v-col>
                </v-row>
                <hr
                    class="my-5 h-px border-t-0 bg-transparent bg-gradient-to-r from-transparent via-neutral-500 to-transparent opacity-50"
                />

                <v-row justify="flex-start">
                    <v-col cols="12">
                        <v-btn
                            prepend-icon="mdi-send"
                            variant="tonal"
                            style="color: blue"
                            @click="sendMessage"
                            :disabled="selectedUsers.length == 0 || message == ''"
                        >
                            Send
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </div>
        <Alert :open="openAlert" @open-dialog="handelOpenAlert" :message="alertMessage"/>
    </main>

</template>

<script>
import user from "../api/user";
import store from "../store";
import manager from "../api/manager";
import Alert from "./Alert.vue";
export default {
    components:{Alert},
    data() {
        return {
            selectedUsers: [],
            message: "",
            currentUserEmail: store.state.user.email,
            currentUserRole: 0,
            users: [],
            selectedAllUsers: false,
            departmentList: [],
            selectedDepartment: null,
            openAlert:false,
            alertMessage:""
        };
    },
    methods: {
        sendMessage() {
            const data = {
                received_id: this.selectedUsers,
                message: this.message,
            };

            user.sendMessage(data).then((response) => {
                this.selectedUsers = [];
                this.message = null;
                this.openAlert = true;
                this.alertMessage = "Massage send successfully"
                
            });
        },
        handelOnSelectAllUsers() {
             console.log(this.selectedUsers);
            this.selectedAllUsers = !this.selectedAllUsers

            if(this.selectedAllUsers){
                this.selectedUsers = [];
            for(var i = 0; i < this.users.length; i++){
                console.log(this.users[i].id);
                this.selectedUsers.push({"id":this.users[i].id,"email":this.users[i].email,"name":this.users[i].name});
            }
            console.log(this.selectedUsers);
        } else {
            this.selectedUsers = [];
        }
 
        },
        handelOpenAlert(){
               this.openAlert= false; 
               this.$emit("closeDialog");

        },
    },
    watch: {
        selectedDepartment(newValue) {
            console.log(this.departmentList);
            const index = this.departmentList.findIndex(
                (index) => index.name === newValue
            );
            this.users = this.departmentList[index].employees;
        },
    },
    created() {
        const currentUser = JSON.parse(localStorage.getItem("currentUser"));
        this.currentUserEmail = currentUser.email;
        this.currentUserRole = currentUser.role;
        console.log(currentUser.role);

        if (currentUser.role == 1) {
            user.getAllUsers().then((response) => {
                console.log(response.data);
                this.users = response.data.data.users;
            });
        } else {
            manager.getEmployee(currentUser.id).then((response) => {
                this.departmentList = response.data.data;
                console.log(this.departmentList);
            });
        }
    },
    mounted() {
        const currentUser = JSON.parse(localStorage.getItem("currentUser"));
        this.currentUserEmail = currentUser.email;
    },
};
</script>
