<template>
    <v-card width="250" style="padding: 10px" id="zoom">
        <template v-slot:title>
            <p class="text-h5 text--primary">{{ requestInfo.title }}</p>
        </template>

        <template v-slot:subtitle>
            <v-row no-gutters align="center" justify="center">
                <v-col cols="2">
                    <img src="../assets/icons/calendar.png" class="h-8 w-8" />
                </v-col>
                <v-col cols="10">
                    <p>{{ requestInfo.date }}</p>
                </v-col>
            </v-row>
        </template>

        <template v-slot:text>
            <p style="margin: 5px; padding: 5px">{{ requestInfo.description }}</p>
            <v-divider
                :thickness="1"
                class="border-opacity-75"
                color="primary"
            />

            <v-row
                no-gutters
                align="center"
                justify="center"
                style="padding: 5px"
            >
                <v-col cols="3">
                    <v-avatar size="36px">
                        <img
                            src="https://politics.princeton.edu/sites/default/files/styles/square/public/images/p-5.jpeg?h=87dbaab7&itok=ub6jAL5Q"
                           
                        />
                    </v-avatar>
                </v-col>
                <v-col cols="9">
                    <p>Manager Manager</p>
                </v-col>
            </v-row>
        </template>
    </v-card>
</template>

<script>
export default {

    name: "RequestCard",
    props:["request"],

    data(){
        return{
            requestInfo: this.request.request
        }
        
    },
  
    
};
</script>
