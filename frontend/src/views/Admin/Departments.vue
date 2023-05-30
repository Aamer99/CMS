<template>
    <!-- <v-app-bar app color="white" elevate-on-scroll style="padding: 10px">
        <v-container>
            <v-row no-gutters>
                <v-col md="4" sm="6">
                    <v-text-field
                        clearable
                        label="Search"
                        variant="underlined"
                    ></v-text-field>
                </v-col>
                <v-col cols="1">
                    <v-btn
                        icon
                        color="success"
                        class="mt-4"
                        block
                        @click="validate"
                    >
                        <v-icodialogn> mdi-magnify </v-icodialogn>
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
        <v-spacer></v-spacer>
        <v-btn :onclick="() => (dialog = true)"> New Department</v-btn>
    </v-app-bar> -->
    <SearchBar type="Department" @open-dialog="showDialog"/>
    <v-container>
        <v-row>
            <!-- <v-col md="auto" sm="12">
                <Card  type="Departments"/>
            </v-col>

            <v-col md="auto" sm="12">
               <Card  type="Departments"/>
            </v-col>
            <v-col md="auto" sm="12">
                 <Card  type="Departments"/>
            </v-col>
            <v-col md="auto" sm="12">
                <Card  type="Departments"/>
            </v-col>
            <v-col md="auto" sm="12">
                 <Card  type="Departments"/>
            </v-col>
            <v-col md="auto" sm="12">
                <Card  type="Departments"/>
            </v-col>
            <v-col md="auto" sm="12">
                 <Card  type="Departments"/>
            </v-col>
            <v-col md="auto" sm="12">
                 <Card  type="Departments"/>
            </v-col>
            <v-col md="auto" sm="12">
               <Card  type="Departments"/>
            </v-col>  -->

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

export default {
    components: {
        Card,
        SearchBar,
    },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        showDialog() {
            this.dialog = !this.dialog;
        },
    },
};
</script>
