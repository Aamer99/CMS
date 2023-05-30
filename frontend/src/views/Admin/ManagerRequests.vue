<template>
    <SearchBar type="" />
    <v-container>
        <v-row align="center">

            <!-- <v-col md="2" sm="12" :key="request.id" style="background-color: black;">

                <RequestCard :request={request} />
            </v-col> -->

            <v-col v-for="request in requests" :key="request.id" cols="12" sm="2">
                <button @click="openDialog = true "> 
                    <RequestCard :request={request} />
                </button>
               
            </v-col>

        </v-row>
    </v-container>

    <v-dialog
      v-model="openDialog"
      width="auto"
    >
    <RequestInfo/>
    </v-dialog>


    <main class="grid min-h-full place-items-center px-6 py-24 sm:py-32 lg:px-8" v-show="requests.length == 0">
        <div class="text-center">
            <img src="../../assets/icons/emptyRequests.png" class="h-25 w-25  mx-auto" />

            <p class="mt-6 text-base leading-7 text-gray-600">Sorry, we couldn’t find Requests.</p>

        </div>
    </main>
</template>
<script>
import RequestCard from '../../components/RequestCard.vue';
import SearchBar from '../../components/SearchBar.vue';
import RequestInfo from '../../components/RequestInfo.vue' 
export default {
    components: {
        RequestCard,
        SearchBar,
        RequestInfo
    }
    , data() {
        return {
            openDialog:false,
            requests: [
            { id: 0, title: "Request Card", description: "Request Card", date: "22 May 2016" },
                { id: 1, title: "Request Information", description: "test", date: "22 May 2017" },
                { id: 2, title: "test", description: "example", date: "22 May 2019" },
                { id: 3, title: "test 2", description: "example", date: "22 May 2019" },
                { id: 4, title: "test 3 ", description: "example", date: "22 May 2019" },
                { id: 5, title: "test 4", description: "example", date: "22 May 2019" },
                { id: 6, title: "test 5", description: "example", date: "22 May 2019" },
                { id: 7, title: "test 6", description: "example", date: "22 May 2019" },
              ]
        }
    }
}

</script>