<template>
    <v-card>
        <v-layout>
            <!-- the Side Bar  -->
            <v-navigation-drawer
                style="background-color: #dbdfea"
                v-model="drawer"
                :rail="rail"
                :permanent="!showNavbar"
                @click="
                    rail = false;
                    checkWidth();
                "
            >
                <!-- The Logo -->
                <v-list>
                    <v-list-item>
                        <v-container>
                            <v-row
                                no-gutters
                                class="justify-center align-center"
                            >
                                <v-col>
                                    <img
                                        class="mx-auto h-150 w-auto"
                                        src="../assets/images/CMSlogo.png"
                                        alt="Your Company"
                                    />
                                </v-col>
                                <v-col cols="3" v-show="!rail">
                                    <v-btn
                                        variant="text"
                                        icon="mdi-chevron-left"
                                        @click.stop="rail = !rail"
                                    ></v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-list-item>
                </v-list>

                <v-divider></v-divider>
                <!-- The Nav List   -->

                <v-list density="compact" nav v-for="(item, i) in items" >
                    <RouterLink :to="item.destination">
                        <v-list-item
                            :key="i"
                            :value="item"
                            :active="item.value == currentItem"
                            v-show="item.role == currentUserRole"
                            @click="
                                () => {
                                    currentItem = item.value;
                                }
                            "
                            rounded="xl"
                        >
                            <template v-slot:prepend>
                                <img
                                    class="h-6 w-6 p-1"
                                    :src="item.src"
                                    :alt="item.alt"
                                />
                            </template>
                            <v-list-item-title
                                v-text="item.title"
                            ></v-list-item-title>
                        </v-list-item>
                    </RouterLink>
                </v-list>

                <!-- The Account  -->
                <template v-slot:append>
                    <RouterLink to="/admin/profile">
                        <v-list-item
                            nav
                            lines="two"
                            prepend-avatar="https://randomuser.me/api/portraits/women/81.jpg"
                            title="Jane Smith"
                            subtitle="Logged in"
                        ></v-list-item>
                    </RouterLink>
                </template>
            </v-navigation-drawer>

            <!-- the Nav Bar  -->

            <v-app-bar
                color="primary"
                :prominent="showNavbar"
                v-show="showNavbar"
                v-if="showNavbar"
            >
                <v-app-bar-nav-icon
                    variant="text"
                    @click.stop="
                        drawerNavbar = !drawerNavbar;
                        checkWidth();
                    "
                />

                <v-toolbar-title>CMS</v-toolbar-title>

                <v-spacer />

                <!-- The Avatar  -->
                <template v-slot:append>
                    <RouterLink :to="{ name: 'Profile', params: { type: 0 } }">
                        <v-list-item
                            nav
                            lines="two"
                            prepend-avatar="https://randomuser.me/api/portraits/women/81.jpg"
                            title="Jane Smith"
                            subtitle="admin@admin"
                        ></v-list-item>
                    </RouterLink>
                </template>
            </v-app-bar>
            <!-- the Nav List  for the Nav bar  -->

            <v-navigation-drawer
                v-model="drawerNavbar"
                location="top"
                v-if="showNavbar"
            >
                <v-list v-for="(item, i) in items">
                    <RouterLink :to="item.destination">
                        <v-list-item
                            :key="i"
                            :value="item"
                            :onclick="
                                (e) => {
                                    currentItem = item.value;
                                    checkWidth();
                                }
                            "
                        >
                            <v-list-item-title
                                v-text="item.title"
                            ></v-list-item-title>
                        </v-list-item>
                    </RouterLink>
                </v-list>
            </v-navigation-drawer>

            <v-main>
                <RouterView />
            </v-main>
        </v-layout>
    </v-card>
</template>
<script>
import { RouterLink, RouterView, useRoute } from "vue-router";
import HomeView from "../views/HomeView.vue";
import Departments from "../views/Admin/Departments.vue";
import { getTransitionRawChildren, handleError, watch } from "vue";
import departmentIcon from "../assets/icons/departments.png";
import homeIcon from "../assets/icons/home.png";
import requestColor from "../assets/icons/requests.png";
import managersIcon from "../assets/icons/managers.png";
import sendMessageIcon from "../assets/icons/message.png";
import store from "../store";

const route = useRoute();

console.log(screen.width < 800);
console.log(window.innerWidth);

export default {
    props: ["menu"],
    components: {
        Departments,
    },

    data: () => ({
        type: 0,
        currentItem: 0,
        currentWidth: window.innerWidth,
        drawerNavbar: false,
        showNavbar: window.innerWidth < 800,
        rail: window.innerWidth > 800,
        drawer: window.innerWidth > 800,
        currentUserRole: 0,
        items: [
            {
                id: 0,
                role: 1,
                title: "Home",
                value: 0,
                src: homeIcon,
                alt: "Home Icon",
                destination: "/admin",
            },
            {
                id: 1,
                role: 1,
                title: "Department",
                value: 1,
                src: departmentIcon,
                alt: "department icon",
                destination: "/admin/department",
            },
            {
                id: 2,
                role: 1,
                title: "Request",
                value: 2,
                src: requestColor,
                alt: "requests icon",
                destination: "/admin/requests",
            },
            {
                id: 3,
                role: 1,
                title: "Manager",
                value: 3,
                src: managersIcon,
                alt: "people icon",
                destination: "/admin/managers",
            },
            {
                id: 4,
                role: 1,
                title: "Send Message",
                value: 4,
                src: sendMessageIcon,
                alt: "send message icon",
                destination: "/admin/send-message",
            },
            {
                id: 5,
                role: 2,
                title: "Home",
                value: 0,
                src: homeIcon,
                alt: "Home Icon",
                destination: "/manager",
            },
            {
                id: 6,
                role: 2,
                title: "Employee",
                value: 1,
                src: departmentIcon,
                alt: "department icon",
                destination: "/manager/employee",
            },
            {
                id: 7,
                role: 2,
                title: "Employee Request",
                value: 2,
                src: requestColor,
                alt: "requests icon",
                destination: "/manager/employee/requests",
            },
            {
                id: 8,
                role: 2,
                title: "My Requests",
                value: 3,
                src: managersIcon,
                alt: "people icon",
                destination: "/manager/my-request",
            },
            {
                id: 9,
                role: 2,
                title: "Send Message",
                value: 4,
                src: sendMessageIcon,
                alt: "send message icon",
                destination: "/manager/send-message",
            },
            {
                id:10,
                role: 3,
                title: "Home",
                value: 0,
                src: homeIcon,
                alt: "Home Icon",
                destination: "/employee",
            },
            {
                id: 11,
                role: 3,
                title: "My Requests",
                value: 1,
                src: managersIcon,
                alt: "people icon",
                destination: "/employee/my-request",
            },
        ],
    }),
    methods: {
        checkWidth() {
            this.currentWidth = window.innerWidth;
        },
    },

    watch: {
        currentWidth() {
            if (this.currentWidth < 800) {
                this.showNavbar = true;
            } else {
                this.showNavbar = false;
                this.drawerNavbar = false;
            }
        },
    },
    mounted() {
        console.log(localStorage.getItem("currentUser"));
        const user = JSON.parse(localStorage.getItem("currentUser"));
        this.currentUserRole = user.role;
    },
};
</script>
