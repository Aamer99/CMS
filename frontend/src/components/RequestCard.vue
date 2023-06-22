<template>
    <v-card
        width="250"
        style="padding: 15px; text-align: start"
        @mouseover="showAction = true"
        @mouseleave="showAction = false"
        id="zoom"
    >
        <h5 class="mb-2 text-xl font-medium leading-tight text-neutral-800">
            {{ requestInfo.request_number }}
        </h5>

        <v-row no-gutters align="center" justify="center">
            <v-col cols="2">
                <img src="../assets/icons/calendar.png" class="h-6 w-6" />
            </v-col>
            <v-col cols="10">
                <p>{{ formateDate(requestInfo.created_at) }}</p>
            </v-col>
        </v-row>

        <p style="margin: 5px; padding: 5px">{{ requestInfo.description }}</p>
        <v-divider :thickness="1" class="border-opacity-75" color="primary" />

        <v-row no-gutters align="start" justify="start" style="padding: 5px">
            <v-col cols="3" v-if="!showAction">
                <v-avatar size="36px">
                    <img
                        src="https://politics.princeton.edu/sites/default/files/styles/square/public/images/p-5.jpeg?h=87dbaab7&itok=ub6jAL5Q"
                    />
                </v-avatar>
            </v-col>
            <v-col cols="9" v-if="!showAction">
                <p>{{ requestInfo.owner.name }}</p>
            </v-col>

            <!-- <v-col cols="3" v-if="showAction">
                <v-btn size="x-small" color="indigo" icon="mdi-cloud-upload"   @click="downloadFile"/>
            </v-col> -->

            <v-col cols="3" v-if="showAction">
                <v-btn
                    size="x-small"
                    color="indigo"
                    icon="mdi-paperclip"
                    @click="handelOpenFile"
                />
            </v-col>

            <v-col cols="3" v-if="showAction">
                <v-btn
                    color="indigo"
                    size="x-small"
                    icon="mdi-eye"
                    @click="$emit('openDialog', requestInfo)"
                />
            </v-col>
        </v-row>
        <FileView :openFile="openFile" :file="requestInfo.file" :filePath="filePath" />
    </v-card>

  

    <!-- <v-dialog v-model="openFile">
        <v-container>
            <v-row no-gutters>
                <v-col cols="12">
                    <v-btn
                        class="ma-2"
                        icon="mdi-close"
                        @click="openFile = false"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <iframe
                        id="if1"
                        width="95%"
                        height="900"
                        style="visibility: visible"
                        :src="filePath"
                        v-show="requestInfo.file.file_type == 'application/pdf'"
                    ></iframe>
                    <img
                        class="h-4/5 w-full"
                        :src="filePath"
                        v-show="
                            requestInfo.file.file_type == 'image/jpeg' ||
                            requestInfo.file.file_type == 'image/png'
                        "
                        
                    />
                </v-col>
            </v-row>
        </v-container>
       
    </v-dialog> -->
    
</template>

<script>
import store from "../store";
import user from "../api/user";
import FileView from "./FileView.vue";

export default {
    name: "RequestCard",
    props: ["request"],
    components:{
FileView
    },

    data() {
        return {
            requestInfo: this.request,
            showAction: false,
            openFile: false,
            currentUser: store.state.user,
            filePath: "",
        };
    },
    methods: {
        downloadFile(event) {
            console.log(event);
        },
        handelOpenFile() {
            const fileData = {
                file_path: this.requestInfo.file.file_path,
            };

            user.getFile(fileData).then((response) => {
                this.filePath = response.data.message;
            });
            this.openFile = true;
        },
        formateDate(date) {
            console.log(date);
            var d = new Date(date),
                month = "" + (d.getMonth() + 1),
                day = "" + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = "0" + month;
            if (day.length < 2) day = "0" + day;

            return [year, month, day].join("-");
        },
    },
};
</script>
