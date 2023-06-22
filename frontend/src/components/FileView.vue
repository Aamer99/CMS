

<template>
 <v-dialog v-model="this.openFile">
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
                        :src=" this.filePath"
                        v-show=" this.file.file_type == 'application/pdf'"
                    ></iframe>
                    <img
                        class="h-4/5 w-full"
                        :src="this.filePath"
                        v-show="
                            this.file.file_type == 'image/jpeg' ||
                            this.file.file_type == 'image/png'
                        "
                        
                    />
                </v-col>
            </v-row>
        </v-container>
       
    </v-dialog>
</template>

<script>

export default{
 name:"OtpAuth",
props:["openFile","file","filePath"]
}

</script>


