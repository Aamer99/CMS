<template>
    <SearchBar type="Managers" @open-dialog="showDialog" />
    <v-container>
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
    </v-container>
    <!-- Add New Manager  -->
    <v-dialog v-model="dialog" width="500">
        <v-card style="padding: 5px">
            <v-card-title class="headline">Add New Manager</v-card-title>
            <v-card-text>
                <v-text-field label="Name" v-model="managerName" required />
                <v-text-field label="Email" v-model="managerEmail" required />
                <v-text-field
                    label="Phone Number"
                    v-model="managerPhoneNumber"
                    required
                />
                <v-select
                    v-model="select"
                    :items="departments"
                    label="Department"
                    required
                ></v-select>
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

    <!-- if there no managers -->
    <!-- <main
        class="grid min-h-full place-items-center px-6 py-24 sm:py-32 lg:px-8"
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
    </main> -->
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
            departments: [
                "Department 1",
                "Department 2",
                "Department 3",
                "Department 4",
                "Department 5",
            ],
            select: null,
        };
    },
    methods:{
        showDialog(){
            this.dialog = !this.dialog;
        }
    }
};
</script>
