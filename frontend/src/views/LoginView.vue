<script>
import { RouterLink, useLink } from 'vue-router';
import {ref} from "vue"

const container = ref();
export default{
   
    data(){
        return{
        authenticated: false,
        otp:[],
        formValues:{
            email:"",
            password:""
        }
    }
    },
    methods:{
        login(){

            this.authenticated = true;
            
            // this.$router.push('/home');
        },
        handelEnter(event,i){

            const matches = event.key.match(/^[0-9]$/);
            // const children = container.value.children;
            if(matches){
            console.log(matches);
            console.log(this.otp);

            } else{

                this.otp=[];
            }
        }
    }
}
</script>
<template>
    <!--
      This example requires updating your template:
  
      ```
      <html class="h-full bg-white">
      <body class="h-full">
      ```
    -->
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-150 w-auto" src="../assets/images/CMSlogo.png" alt="Your Company" />
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
      </div>
  
      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" @submit.prevent="login">

          <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
            <div class="mt-2">
              <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
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
              <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
  
          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
          </div>
        </form>
      </div>
    </div>
 
    <div v-show="authenticated" className = "bg-gray-500 bg-opacity-70 absolute top-0 left-0 right-0 bottom-0 flex justify-center items-center">

    <div class="bg-white py-10 sm:py-15 rounded-md" style="padding: 5px;">
        <h1 style="padding: 5px;">Enter Verification Code</h1>
        <p class="mt-3 text-sm text-gray-500" style="padding: 10px;">We have just send a Verification code to {{formValues.email }}.</p>
    <div class="mx-auto max-w-2xl px-2 lg:px-2">
      <dl class="grid grid-cols-1 gap-x-2 gap-y-2 text-center lg:grid-cols-6">
            <div class="mx-auto flex max-w-xs flex-col gap-x-6" v-for="i in 6" style="margin: 5px;" ref="container">
             
                <input type="text" :maxlength="1" @keyup="handelEnter" v-model="otp[i]" :key="i" class="block rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset " style="width: 40px; text-align: center;"/>
            </div>
            </dl>
            </div>
            <div class="justify-center items-center" style="padding: 5px;">
                <button class="bg-gray-500 py-2 sm:px-10  rounded-lg">Verify</button>
            </div>
            
            
        </div>
    </div>
  </template>
  