<template>
    <div
        class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img
                class="mx-auto h-150 w-auto"
                src="../assets/images/CMSlogo.png"
                alt="CMS Logo"
            />
            <h2
                class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
            >
                Sign in to your account
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="login">
                <v-text-field
                    label="Email"
                    v-model="formValues.email"
                    :error="this.isError"
                    type="email"
                    required
                />

                <v-text-field
                    label="Password"
                    v-model="formValues.password"
                    :error="this.isError"
                    :error-messages="this.errorMessages"
                    type="password"
                    required
                />

                <div>
                    <div class="flex items-center justify-end">
                        <div class="text-sm">
                            <a
                                href="#"
                                class="font-semibold text-indigo-600 hover:text-indigo-500"
                                >Forgot password?</a
                            >
                        </div>
                    </div>
                </div>

               

                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Verify OTP  -->
    <OtpView :email="formValues.email" :openOtp="openOtp" @open-dialog="handelOpenOtp" :otpExpiredDate="otp_expired_date"/>

</template>
<script>
import { RouterLink, useLink } from "vue-router";
import { ref } from "vue";
import auth from "../api/auth";
import store from "../store";
import OtpView from "./OtpView.vue";
import { adminList, employeeList, managerList } from "../assets/usersLists";
export default {
    components:{ OtpView},

    data() {
        return {
            openOtp: false,
            otp: [],
            formValues: {
                email: "",
                password: "",
            },
            token: "",
            otp_expired_date: "",
            isError: false,
            isOtpWrong: false,
            errorMessages: "",
            minutes: 4,
            seconds: 60,
        };
    },
    methods: {

        login() {

            const loginData = {
                email: this.formValues.email,
                password: this.formValues.password,
            };
            auth.login(loginData)
                .then((res) => {
                    
                    if (res.status == 201) {
                        localStorage.setItem("validation_token", res.data.data);

                        this.$router.push({ name: "ResetPassword" });
                    } else {
                        // auth.login(loginData)

                        localStorage.setItem("otpToken", res.data.data.token);
                        console.log(localStorage.getItem("otpToken"));
                        this.token = res.data.data.token;
                        this.otp_expired_date = res.data.data.otp_expired_date;
                        console.log(this.otp_expired_date);
                        this.openOtp = true;
                    }
                })
                .catch((err) => {
                    console.log(err.response.data.message);
                    this.isError = true;
                    this.errorMessages = err.response.data.message;
                });
        },

        handelOpenOtp(){
            this.openOtp = false;
        },

        handelEnter(event, i) {
            const matches = event.key.match(/^[0-9]$/);

            if (matches) {
                switch (i) {
                    case 1:
                        this.$refs.input2[0].focus();
                        break;
                    case 2:
                        this.$refs.input3[0].focus();
                        break;
                    case 3:
                        this.$refs.input4[0].focus();
                        break;
                    case 4:
                        this.$refs.input5[0].focus();
                        break;
                    case 5:
                        this.$refs.input6[0].focus();
                        break;
                    case 6:
                        if (this.otp.length == 7) {
                            this.$refs.verifyBtn.focus();
                        }
                        break;
                }
            }
        },

        async verifyOTP() {
            var otp = "";
            this.otp.map((item) => {
                otp += item.toString();
            });

            //  const data = {"otp": otp,"token":this.token};

            const data = {
                otp: otp,
                token: localStorage.getItem("otpToken"),
            };
            await auth
                .verifyOTP(data)
                .then((res) => {
                    store.commit("setToken", res.data.data.token);

                    store.commit("setUser", res.data.data.user);
                    localStorage.setItem("token", store.state.token);

                    if (res.data.data.user.role == 1) {
                        alert("User");
                        store.commit("setMenu", adminList);
                        localStorage.setItem("menu", adminList);
                        this.$router.push({ name: "AdminHome" });
                    } else if (res.data.data.user.role == 2) {
                        //localStorage.setItem("menu",managerList);

                        this.$router.push({ name: "Manager" });
                    } else if (res.data.data.user.role == 3) {
                        //localStorage.setItem("menu",employeeList);
                        this.$router.push({ name: "EmployeeHome" });
                    }

                    // window.location = "/admin";
                })
                .catch((err) => {
                    console.log(err);
                    this.isOtpWrong = true;
                });
        },
    },
    mounted() {

    //     if(this.openOtp == true){
            
    //     let seconds = this.seconds;
    //     let minutes = this.minutes;
    //     let interval = setInterval(() => {
    //         if (minutes === 0 && seconds === 0) {
    //             clearInterval(interval);
    //         } else {
    //             if (seconds == 0) {
    //                 seconds--;
    //                 minutes--;
    //                 seconds = 60;
    //             } else {
    //                 seconds--;
    //                 console.log(minutes, ":", seconds);
    //             }
    //         }
    //     }, 1000);
    // }
    },
};
</script>
