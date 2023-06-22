<template>
    <SearchBar type="Department" @open-dialog="handleOpenCreateRequestDialog" />

    <p class="text-4xl text-gray-900 font-extralight m-3">My Requests:</p>

    <v-container>
        <v-row align="center">
            <v-col
                v-for="request in myRequests"
                :key="request.id"
                cols="12"
                sm="3"
                md="3"
            >
                <RequestCard
                    :request="request"
                    @open-dialog="handleOpenDialog"
                />
            </v-col>
        </v-row>
    </v-container>

    <v-dialog v-model="dialog" width="auto">
        <RequestInfo :request="selectedRequest" type="1" />
    </v-dialog>

    <v-dialog v-model="openCreateRequestDialog" width="500">
        <v-card>
            <p class="text-3xl font-thin text-gray-900 p-8">Add New Request</p>
            <v-container class="mb-6">
                
                <v-row>
                    <v-col clos="12">
                        <v-text-field
                            v-model="title"
                            label="Title"
                            :error="this.errors.title"
                            :error-messages = "this.errors.title && this.errors.title[0]"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col clos="12">
                        <v-textarea
                            clearable
                            label="Description"
                            v-model="description"
                            :error= "this.errors.description"
                            :error-messages = "this.errors.description && this.errors.description[0]"
                        ></v-textarea>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col clos="12">
                        <v-file-input
                            label="File input"
                            accept="application/pdf,image/png , image/jpeg"
                            hint="the accepted file: pdf,png,jpeg"
                            v-model="file"
                            :error = "this.errors.requestFile"
                            :error-messages = "this.errors.requestFile && this.errors.requestFile[0]"
                        ></v-file-input>
                    </v-col>
                </v-row>
                <v-divider
                    :thickness="2"
                    class="border-opacity-75 m-5"
                    color="primary"
                />

                <div
                    class=" flex items-center justify-end gap-x-6 "
                   
                >
                    <button
                        type="button"
                        class="rounded-md px-3 py-2 text-sm font-semibold leading-6 text-red-500 bg-red-500"
                        @click="handelCancel"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="rounded-md px-3 py-2 text-sm font-semibold leading-6 text-green-500 bg-green-500"
                        @click="createRequest"
                        :disabled = "title == '' || description == '' || file == ''"
                    >
                        Approve
                    </button>
                </div>
          
            </v-container>
        </v-card>
    </v-dialog>
    <Alert :open="openAlert" @open-dialog="handelOpenAlert" :message="message"/>

</template>

<script>
import requests from "../../api/requests";
import SearchBar from "../../components/SearchBar.vue";
import store from "../../store";
import RequestCard from "../../components/RequestCard.vue";
import RequestInfo from "../../components/RequestInfo.vue";
import Alert from "../../components/Alert.vue";
export default {
    components: { SearchBar, RequestCard, RequestInfo ,Alert},

    data() {
        return {
            myRequests: [],
            dialog: false,
            selectedRequest: [],
            openCreateRequestDialog: false,
            description:"",
            file: '',
            title:"",
            currentUser:null,
            errors:[],
            openAlert:false,
            message:""
        };
    },
    methods: {
        handleOpenDialog(value) {
            this.dialog = !this.dialog;
            this.selectedRequest = value;
            console.log(value);
        },
        handleOpenCreateRequestDialog() {
            this.openCreateRequestDialog = !this.openCreateRequestDialog;
        },
        createRequest(){

            console.log(this.file[0].type);
            const data = new FormData();
            data.append("requestFile",this.file[0]);
            data.append("description",this.description)
            data.append("department_id",2)
            data.append("file_type",this.file[0].type);
            data.append("title",this.title);
            
            
            requests.createRequest(data)
            .then((response)=>{
                this.description = "";
                this.file = "";
                this.title="";
                this.errors=[];
                this.myRequests.push(response.data.data.request);
                
                this.openAlert = true;
                this.message= "the request created successfully"
                // this.myRequests
                
               
            })
            .catch((error)=>{
                this.errors = error.response.data.errors;
               
            })
        },

        handelCancel (){
                this.description = "";
                this.file = "";
                this.title="";
                this.errors=[];
                this.openCreateRequestDialog = false;
        },
        handelOpenAlert(){
            this.openCreateRequestDialog = false;
               this.openAlert= false; 
               
               this.$emit("openDialog");

        },


    },

    created() {
        // if(localStorage.getItem("myRequests")){
        //     this.myRequests = localStorage.getItem("myRequests");
        // }else{

        const user = JSON.parse(localStorage.getItem("currentUser")); 
        this.currentUser = user; 
        console.log(this.currentUser);
        console.log("hi")

        requests
            .myRequests(user.id)
            .then((res) => {
                console.log(res.data);
                this.myRequests = res.data.data;
                localStorage.setItem("myRequests", this.myRequests);
            })
            .catch((err) => {
                console.log(err);
            });
    },
    // }
};
</script>
