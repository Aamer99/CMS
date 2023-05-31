
<template>
    <!--
      This example requires updating your template:
  
      ```
      <html class="h-full bg-white">
      <body class="h-full">
      ```
    -->
    <div
        class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img
                class="mx-auto h-150 w-auto"
                src="../assets/images/CMSlogo.png"
                alt="Your Company"
            />
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Sign in to your account
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="login">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>

                    <div class="mt-2">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            v-model="formValues.email"
                            required
                            
                         :class=" isError ? ' w-full rounded-md  py-1.5 shadow-sm bg-red-50 border border-red-500 text-red-900 ' : ' w-full rounded-md border-0 py-1.5 shadow-sm bg-gray-100'"
                        />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            v-model="formValues.password"
                            required
                            :class=" isError ? ' w-full rounded-md  py-1.5 shadow-sm bg-red-50 border border-red-500 text-red-900 ' : ' w-full rounded-md border-0 py-1.5 shadow-sm bg-gray-100'"
/>

<p class="mt-2 text-sm text-red-600 dark:text-red-500" v-show="isError"> Invalided Email or Password, Place try again</p>
                 </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Verify OTP  -->

    <v-dialog
      v-model="openOtp"
      persistent
      width="auto"
    >
<!-- 
    <div
        v-show="authenticated"
        className="bg-gray-500 bg-opacity-70 absolute top-0 left-0 right-0 bottom-0 flex justify-center items-center"> -->
        <div class="bg-white py-10 sm:py-15 rounded-md" style="padding: 5px">
            <div class="grid grid-flow-col gap-2">
                <div class="col-span-6">
                    <h1 style="padding: 5px" class="font-mono">Verification Code</h1>
                </div>
                <div class="col-span-0.4">
                    <button type="button" style="float: right;padding: 3px;" :onClick="()=>{this.openOtp = false}">X</button>
                </div>
            </div>
            <p class="mt-3 text-sm text-gray-500" style="padding: 10px">
                We have just send a Verification code to {{ formValues.email }}.
            </p>

            <dl class="grid grid-flow-col gap-2">
                <div
                    class="grid grid-flow-col gap-2"
                    v-for="i in 6"
                    style="margin: 5px"
                    ref="container">
                  
                    <input
                        type="text"
                        :ref="'input' + i"
                        :maxlength="1"
                        @keyup="(e) => handelEnter(e, i)"
                        v-model="otp[i]"
                        :key="i"
                        :class="isOtpWrong ?  'block rounded-md py-1.5 shadow-sm ring-1 ring-inset bg-red-50 border border-red-500 text-red-900 ':'block rounded-md py-1.5 shadow-sm ring-1 ring-inset'"
                        style="width: 40px; text-align: center"
                    />
                </div>
            </dl>

            <div class="grid grid-flow-row gap-2">
            <div style="margin: 1px;">
                <a  class="text-blue-900"  href="" style="float: left; margin: 5px">Send the code Again</a>
            </div>

            <div class="flex flex-col items-center justify-center" style="margin: 5px">
                <button
                    ref="verifyBtn"
                    @click="verifyOTP"
                    @focus="verifyOTP"
                    class="bg-blue-900 text-white hover:bg-blue-400 font-bold py-2 px-4 mt-3 rounded items-center">
                    Verify
                </button>
            </div>
            </div>
        </div>
    </v-dialog>
</template>
<script>
import { RouterLink, useLink } from "vue-router";
import { ref } from "vue";
import auth from "../api/auth";

export default {
    data() {
        return {
            openOtp: false,
            otp: [],
            formValues: {
                email: "",
                password: "",    
            },
            token:"",
            otp_expired_date:"",
            isError: false,
            isOtpWrong: false,
        };
    },
    methods: {
       async login() {
            
        const loginData = {"email":this.formValues.email, "password":this.formValues.password}
        await auth.login(loginData)
            // auth.login(loginData)
             .then((res)=>{
                console.log(res.data);
                this.openOtp = true;
                this.token = res.data.token;
                this.otp_expired_date = res.data.otp_expired_date;
             })
             .catch((err)=>{
                console.log(err.response.data.message);
                this.isError = true
             });
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
        this.otp.map((item)=>{
            otp += item.toString();
        })
    

         const data = {"otp": otp,"token":this.token};

            await auth.verifyOTP(data)
            .then((res)=>{
               console.log(res);
               window.location = "/admin";
            })
            .catch((err)=>{
                console.log(err);
                this.isOtpWrong = true
            })
        },
    },
};
</script>