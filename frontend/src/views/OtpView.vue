<template>
    <v-dialog persistent v-model="this.openOtp" width="auto">
        <!-- <v-card> 
             <div class="flex items-center justify-between p-2">
                <h1 class="font-mono">Verification Code</h1>
                <v-btn class="ma-2" icon="mdi-close" @click="$emit('openDialog')" />
            </div>
           
            <p class="mt-3 text-sm text-gray-500" style="padding: 10px">
                We have just send a Verification code to {{ this.email }}.
            </p> 

            <p class="text-center justify-center p-2"> {{ minutes }} Minutes : {{seconds}} Seconds</p>

            <dl class="grid grid-flow-col gap-2">
                <div
                    class="grid grid-flow-col gap-2"
                    v-for="i in 6"
                    style="margin: 5px"
                    ref="container"
                >
                    <input
                        type="text"
                        :ref="'input' + i"
                        :maxlength="1"
                        @keyup="(e) => handelEnter(e, i)"
                        v-model="otp[i]"
                        :key="i"
                        :class="
                            isOtpWrong
                                ? 'block rounded-md py-1.5 shadow-sm ring-1 ring-inset bg-red-50 border border-red-500 text-red-900 '
                                : 'block rounded-md py-1.5 shadow-sm ring-1 ring-inset'
                        "
                        style="width: 40px; text-align: center"
                    />
                </div>
            </dl> 

             <div class="grid grid-flow-row gap-2">
                <div style="margin: 1px">
                    <a
                        class="text-blue-900"
                        href=""
                        style="float: left; margin: 5px"
                        >Send the code Again</a
                    >
                </div>

                <div
                    class="flex flex-col items-center justify-center"
                    style="margin: 5px"
                >
                    <button
                        ref="verifyBtn"
                        @click="verifyOTP"
                        @focus="verifyOTP"
                        class="bg-blue-900 text-white hover:bg-blue-400 font-bold py-2 px-4 mt-3 rounded items-center"
                    >
                        Verify
                    </button>
                </div>
            </div> 
          
         </v-card> -->

        <!-- <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-12"> -->
        <div
            class="relative bg-white px-6 pt-10 pb-9 shadow-xl mx-auto w-full max-w-xl rounded-2xl"
        >
            <div class="mx-auto flex w-full max-w-md flex-col space-y-12">
                <div
                    class="flex flex-col items-center justify-center text-center space-y-2"
                >
                    <div class="font-semibold text-3xl">
                        <p>OTP Verification</p>
                    </div>
                    <div
                        class="flex flex-row text-sm font-medium text-gray-400"
                    >
                        <p>
                            We have sent a code to your email {{ this.email }}
                        </p>
                    </div>
                </div>

                <div
                    class="flex flex-row text-sm font-medium text-gray-700 m-t-5 text-center justify-center"
                >
                    <p>{{ minutes }} Minutes : {{ seconds }} Seconds</p>
                </div>

                <div>
                    <div class="flex flex-col space-y-16">
                        <dl
                            class="flex flex-row items-center justify-between mx-auto w-full max-w-md"
                        >
                            <div v-for="i in 5">
                                <div class="w-16 h-16">
                                    <input
                                        class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700"
                                        type="text"
                                        :ref="'input' + i"
                                        :maxlength="1"
                                        @keyup="(e) => handelEnter(e, i)"
                                        v-model="otp[i]"
                                        :key="i"
                                        :class="
                                            isOtpWrong
                                                ? 'block  bg-red-50 border border-red-500 text-red-900 '
                                                : 'block '
                                        "
                                    />
                                </div>
                            </div>

                            <!-- <div class="w-16 h-16">
                <input class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700" type="text" name="" id="">
              </div> -->

                            <!-- <div class="w-16 h-16 ">
                <input class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700" type="text" name="" id="">
              </div>
              <div class="w-16 h-16 ">
                <input class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700" type="text" name="" id="">
              </div>
              <div class="w-16 h-16 ">
                <input class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700" type="text" name="" id="">
              </div> -->
                        </dl>

                        <div
                            class="flex flex-row text-sm font-medium text-gray-700 m-t-5 text-center justify-center"
                        >
                            <p>{{ errorMessage }}</p>
                        </div>

                        <div class="flex flex-col space-y-5">
                            <div>
                                <button
                                    class="flex flex-row items-center justify-center text-center w-full border rounded-xl outline-none py-5 bg-blue-700 border-none text-white text-sm shadow-sm"
                                    ref="verifyBtn"
                                    @click="verifyOTP"
                                    @focus="verifyOTP"
                                >
                                    Verify
                                </button>
                            </div>

                            <div
                                class="flex flex-row items-center justify-center text-center text-sm font-medium space-x-1 text-gray-500"
                            >
                                <p>Didn't recieve code?</p>
                                <a
                                    class="flex flex-row items-center text-blue-600"
                                    href="http://"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    >Resend</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </v-dialog>
</template>

<script>
import auth from "../api/auth.js";
import store from "../store.js";
export default {
    props: ["openOtp", "email", "otpExpiredDate"],
    data() {
        return {
            minutes: 4,
            seconds: 60,
            otp: [],
            isOtpWrong: false,
            errorMessage: "",
            otp_expired_date: "",
            openDialog: this.openOtp,
        };
    },
    methods: {
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
                        if (this.otp.length == 6) {
                            this.$refs.verifyBtn.focus();
                        }
                        break;
                }
            }
        },

        verifyOTP() {
            var otp = "";
            this.otp.map((item) => {
                otp += item.toString();
            });

            const data = {
                otp: otp,
                token: localStorage.getItem("otpToken"),
            };

            auth.verifyOTP(data)
                .then((response) => {
                    if (response.status == 200) {
                        store.commit("setToken", response.data.data.token);

                        store.commit("setUser", response.data.data.user);
                        localStorage.setItem("token", store.state.token);
                        let user = response.data.data.user;

                        if (user.role == 1) {
                            this.$router.push("/admin");
                        } else if (user.role == 2) {
                            this.$router.push("/manager");
                        } else if (user.role == 3) {
                            this.$router.push("/employee");
                        }
                    }

                    
                })
                .catch((err) => {
                    console.log(err.response);
                    this.errorMessage = err.response.data.message;
                    this.isOtpWrong = true;
                });
        },
        diff_minutes(date2, date1) {
            var diff = (date2.getTime() - date1.getTime()) / 1000;
            diff /= 60;
            return Math.abs(Math.round(diff));
        },
    },
    updated() {
        let seconds = this.seconds;
        let minutes = this.diff_minutes(new Date(this.otpExpiredDate),new Date());
       
    
        let interval = setInterval(() => {
            if (this.openOtp) {
                if (minutes === 0 && seconds === 0) {
                    clearInterval(interval);
                } else {
                    if (seconds == 0) {
                        seconds--;
                        minutes--;
                        seconds = 60;
                    } else {
                        seconds--;
                        this.seconds = seconds;
                        this.minutes = minutes;
                    }
                }
            } else {
                clearInterval(interval);
            }
        }, 1000);
    },
};
</script>
