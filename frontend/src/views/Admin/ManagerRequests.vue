<template>
    <SearchBar type="" />
    <p class="text-4xl text-gray-900 font-extralight m-3">
        {{ currentUserRole == 1 ? "Managers Requests:" : "Employee Requests:" }}
    </p>

    <div class="flex items-center p-2" v-show="currentUserRole == 2">
        <p class="p-2">Department: </p>
        <div
            class="rounded-full focus:outline-none focus:ring-2 focus:bg-indigo-50 focus:ring-indigo-800"
            v-for="(department, index) in employeeRequests"
        >
            <button
                :class="
                    currentDepartment == index
                        ? 'bg-indigo-100 rounded-full text-indigo-700 py-2 px-8'
                        : 'text-gray-600 py-2 px-8'
                "
                @click="onclickDepartment(department.requests, index)"
            >
                <p>{{ department.name }}</p>
            </button>
        </div>
    </div>
    <v-container>
        <v-row align="center">
            <!-- <v-col md="2" sm="12" :key="request.id" style="background-color: black;">

                <RequestCard :request={request} />
            </v-col> -->

            <v-col
                v-for="request in requests"
                :key="request.id"
                cols="12"
                sm="3"
            >
                <!-- <button @click="openDialog = true ">  -->
                <RequestCard
                    :request="request"
                    @open-dialog="handleOpenDialog"
                />
                <!-- <h1>{{ request.request_number }}</h1> -->
                <!-- </button> -->
            </v-col>
        </v-row>
    </v-container>

    <v-dialog v-model="openDialog" width="auto">
        <RequestInfo :request="selectedRequest" type="0"  :currentUserRole="currentUserRole" @open-dialog ="handelCloseDialog"/>
    </v-dialog>

    <main
        class="grid min-h-full place-items-center px-6 py-24 sm:py-32 lg:px-8"
        v-show="requests.length == 0"
    >
        <div class="text-center">
            <img
                src="../../assets/icons/emptyRequests.png"
                class="h-25 w-25 mx-auto"
            />

            <p class="mt-6 text-base leading-7 text-gray-600">
                Sorry, we couldn’t find Requests.
            </p>
        </div>
    </main>
</template>
<script>
import RequestCard from "../../components/RequestCard.vue";
import SearchBar from "../../components/SearchBar.vue";
import RequestInfo from "../../components/RequestInfo.vue";
import store from "../../store";
import requests from "../../api/requests";
export default {
    components: {
        RequestCard,
        SearchBar,
        RequestInfo,
    },
    data() {
        return {
            openDialog: false,
            selectedRequest: [],
            currentUserRole: 0,
            requests: [],
            employeeRequests:[],
            currentDepartment:0
        };
    },
    methods: {
        handleOpenDialog(value) {
            this.openDialog = !this.openDialog;
            this.selectedRequest = value;
            console.log(this.selectedRequest)
        },
        onclickDepartment(departmentUsers,index){
           console.log(departmentUsers,index);
           this.currentDepartment = index;
           this.requests = departmentUsers;
        },
        handelCloseDialog(){
            this.openDialog = false;
        }
    },
    created() {
        const user = JSON.parse(localStorage.getItem("currentUser"));
        this.currentUserRole = user.role;

        if (user.role == 1) {
            requests.getManagerRequests().then((response) => {
                this.requests = response.data.request;
                console.log(response.data.request);
            });
        } else if (user.role == 2) {
            requests.getEmployeeRequests(user.id)
            .then((response) => {
                console.log(response.data.data);
                 this.employeeRequests = response.data.data;
                 this.requests = this.employeeRequests[0].requests
            })
            .catch((error) => {
               console.log(error); 
            })
        }
    },
};
</script>
