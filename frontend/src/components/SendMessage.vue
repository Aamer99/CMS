<template>
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
                        <p>aamer.es12@gmail.com</p>
                    </v-col>
                </v-row>
                <v-row justify="space-between">
                    <v-col cols="4">
                        <p>To</p>
                    </v-col>
                    <v-col cols="8">
                        <v-select
                            class="md:w-1/2"
                            v-model="selectedUser"
                            chips
                            label="Select User"
                            :items="users"
                            variant="outlined"
                        ></v-select>
                    </v-col>
                </v-row>
                <v-row justify="space-between">
                    <v-col clos="12">
                        <v-textarea
                            clearable
                            label="Type Here..."
                            variant="outlined"
                            v-model="messageContent"
                        ></v-textarea>
                    </v-col>
                </v-row>
                <hr
  class="my-5 h-px border-t-0 bg-transparent bg-gradient-to-r from-transparent via-neutral-500 to-transparent opacity-50 dark:opacity-100" />

                <v-row justify="flex-start">
                    <v-col cols="12">
                        <v-btn
                            variant="text"
                            style="color: red; font-weight: bold"
                            prepend-icon="mdi-delete"
                            @click="selectedUser = null; messageContent = ''"
                        >
                            Remove Message
                        </v-btn>
                   
                        <v-btn prepend-icon="mdi-send" variant="tonal"  style="color: blue;" :disabled="selectedUser == null || messageContent == '' ">
                            Send
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </main>
</template>

<script>
import { ref } from "vue";

export default {
    data() {
        return {
            selected: false,
            users: [
                "foo@test.com",
                "user@test.com",
                "userTwo@test.com",
                "user@test2.com",
            ],
            messageContent: "",
            selectedUser: null,
            items: [
                {
                    id: 1,
                    name: "Foo",
                    image: "https://www.gravatar.com/avatar/b17065ea1655f1e3283aac8d8fc16019?s=48&d=identicon&r=PG",
                },
                {
                    id: 2,
                    name: "Bar",
                    image: "https://www.gravatar.com/avatar/b17065ea1655f1e3283aac8d8fc16019?s=48&d=identicon&r=PG",
                },
                {
                    id: 3,
                    name: "Hoo",
                    image: "https://www.gravatar.com/avatar/b17065ea1655f1e3283aac8d8fc16019?s=48&d=identicon&r=PG",
                },
                {
                    is: 4,
                    name: "Coo",
                    image: "https://www.gravatar.com/avatar/b17065ea1655f1e3283aac8d8fc16019?s=48&d=identicon&r=PG",
                },
            ],
            // selected: {id:2, name: 'Bar', image: 'https://www.gravatar.com/avatar/b17065ea1655f1e3283aac8d8fc16019?s=48&d=identicon&r=PG'},
        };
    },
};
const selected = ref({
    id: 1,
    name: "Foo",
    image: "https://www.gravatar.com/avatar/b17065ea1655f1e3283aac8d8fc16019?s=48&d=identicon&r=PG",
});
</script>
