<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8 place-items-center bg-white">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-150 w-auto" src="../assets/images/CMSlogo.png" alt="CMS Logo" />
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm" v-show="!passwordReset">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 mb-10">
                Reset Your Password
            </h2>
            <form class="space-y-6" @submit.prevent="resetPassword">
                <!-- Current password -->
                <div>
                   

                    
                        <!-- <input name="currentPassword" type="password" v-model="formValues.currentPassword" required :class="
                            errors.current_password
                                ? ' w-full rounded-md  py-1.5 shadow-sm bg-red-50 border border-red-500 text-red-900 '
                                : ' w-full rounded-md border-0 py-1.5 shadow-sm bg-gray-200'
                        " />
                        <p class="text-red-800 p-1" v-show="errors.current_password" >{{  isError && errors.current_password[0]}}</p> -->
                        <v-text-field
                        
                            label="Current Password"
                            v-model="formValues.currentPassword"
                            :error="currentPasswordError" 
                            :error-messages="currentPasswordErrorMessage"
                            

                        />
                   
                    <!-- New Password -->
                   
                    <v-text-field
                            label="New Password"
                            v-model="formValues.newPassword"
                            :error="errors.password" 
                            :error-messages="errors.password && errors.password[0]"
                             type="password"
                        />

                    <!-- Confirm Password  -->

                    <v-text-field
                            label="Conform Password"
                            v-model="formValues.rePassword"
                            :error="errors.password" 
                            :error-messages="errors.password && errors.password[0]"
                            type="password"
                        />

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mt-10">
                            Reset My Password
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div v-show="passwordReset">


            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 mb-10">
                    Successful Password reset!
                </h2>
                <p class="text-center text-gray-600">
                    You can now use your new password to login to your account
                </p>


            </div>
            <div class="grid min-h-full place-items-center lg:px-8">
                <RouterLink to="/login">

                    <p
                        class="flex w-[200px] justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mt-10">
                        Login
                    </p>
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<script>
import auth from '../api/auth';


export default {
    data() {
        return {
            isError: false,
            formValues: {
                currentPassword: "",
                newPassword: "",
                rePassword: "",
            },
            passwordReset: false,
            errors:[],
            currentPasswordError:false,
            currentPasswordErrorMessage:""
        };
    },
    methods: {
        resetPassword() {

            const data = {
                "current_password": this.formValues.currentPassword,
                "password": this.formValues.newPassword,
                "password_confirmation": this.formValues.rePassword,
                "token":localStorage.getItem("validation_token")
            }

            console.log(data);
            
            auth.setPassword(data)
                .then((response) => {
                    this.passwordReset = true;
                })
                .catch((error) => {

                    console.log(error)
                    if(error.response.data.errors){
                        //  this.currentPasswordError = true 
                        //  this.currentPasswordErrorMessage = error.response.data.message
                        console.log("error hhhh")
                    }
                    this.isError = true;
                    this.errors = error.response.data.errors;
                    console.log(error.response.data.errors);

                })

        }
    }
};
</script>
