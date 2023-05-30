<template>
    <div v-show="!showEdit">
        <div class="bg-white rounded-lg shadow-xl pb-8">
            <!-- profile background -->
            <div class="w-full h-[250px]">
                <img src="https://vojislavd.com/ta-template-demo/assets/img/profile-background.jpg"
                    class="w-full h-full rounded-tl-lg rounded-tr-lg" />
            </div>

            <div class="flex-1 flex flex-col items-end justify-end px-8 mt-2" v-show="type == 0">
                <div class="flex items-center space-x-4 mt-2">
                    <button @click="showEdit = true"
                        class="flex items-center bg-blue-600 hover:bg-blue-700 text-gray-100 px-4 py-2 rounded text-sm space-x-2 transition duration-100">
                        <span>Edit Profile</span>
                    </button>
                    <button
                        class="flex items-center bg-red-600 hover:bg-red-700 text-gray-100 px-4 py-2 rounded text-sm space-x-2 transition duration-100">
                        <span>Logout</span>
                    </button>
                </div>
            </div>

            <div class="flex flex-col items-start pl-3 -mt-20 w-1/2">
                <img src="https://vojislavd.com/ta-template-demo/assets/img/profile.jpg"
                    class="w-40 border-4 border-white rounded-full" />
                <div class="flex items-center space-x-2 mt-2">
                    <p class="text-2xl">Jane Smith</p>
                </div>
            </div>
        </div>

        <!-- <div class="my-4 flex flex-col 2xl:flex-row space-y-4 2xl:space-y-0 2xl:space-x-4 bg-gray-900"> -->
        <div class="m-4 mr-4 w-[95%]">
            <div class="flex-1 bg-white rounded-lg shadow-xl p-8">
                <h4 class="text-xl text-gray-900 font-bold"> the type is  </h4>
                <ul class="mt-2 text-gray-700">
                    <li class="flex border-y py-2">
                        <span class="font-bold w-24">Full name:</span>
                        <span class="text-gray-700">Amanda S. Ross</span>
                    </li>

                    <li class="flex border-b py-2">
                        <span class="font-bold w-24">Email:</span>
                        <span class="text-gray-700">amandaross@example.com</span>
                    </li>

                    <li class="flex border-b py-2">
                        <span class="font-bold w-24">Mobile:</span>
                        <span class="text-gray-700">(123) 123-1234</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
   <!-- edit Profile -->
    <div class="flex justify-center text-start p-5" v-show="showEdit">
        <v-card class="md:w-7/5 lg:w-1/2 bg-transparent flex items-center justify-center place-items-center">
            <form>
                <div class="p-5">
                    <div class="border-b border-gray-900/10 pb-12">
                        <v-btn variant="text" icon="mdi-close" @click="showEdit = false" />

                        <h2 class="text-base font-semibold leading-7 text-gray-900">
                            Profile
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">
                            This information will be displayed publicly so be
                            careful what you share.
                        </p>

                        <!-- User name  -->

                        <!-- Profile Photo  -->
                        <div class="col-span-full mt-5">
                            <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Photo</label>
                            <div class="mt-2 flex items-center gap-x-3">
                                <input type="file" id="uploadProfileImage" hidden />

                                <img src="https://tecdn.b-cdn.net/img/new/avatars/2.webp" class="w-24 rounded-full"
                                    alt="Avatar" />
                                <label type="button" for="uploadProfileImage"
                                    class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    Change
                                </label>
                            </div>
                        </div>

                        <!-- Profile Cover  -->

                        <div class="col-span-full">
                            <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900 mt-5">Cover
                                photo</label>
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                        <label for="file-upload"
                                            class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only" />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs leading-5 text-gray-600">
                                        PNG, JPG, GIF up to 10MB
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full mt-5">
                            <button
                                class="flex items-center bg-blue-600 hover:bg-blue-700 text-gray-100 px-4 py-2 rounded text-sm space-x-2 transition duration-100">
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Personal Information  -->

                <div class="p-5">
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">
                            Personal Information
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">
                            This information will be displayed publicly so be
                            careful what you share.
                        </p>
                        <!-- Full name  -->
                        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="fullName" class="block text-sm font-medium leading-6 text-gray-900">Full
                                    Name</label>
                                <div class="mt-2">
                                    <div
                                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                        <input type="text" name="fullName"
                                            class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                            placeholder="Full Name" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email  -->
                        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="username"
                                    class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                <div class="mt-2">
                                    <div
                                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                        <input type="email" name="email"
                                            class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                            placeholder="Email" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- phone Number  -->
                        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="phoneNumber" class="block text-sm font-medium leading-6 text-gray-900">Phone
                                    Number</label>
                                <div class="mt-2">
                                    <div
                                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                        <input type="text" name="phoneNumber"
                                            class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                            placeholder="Phone Number" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full mt-5">
                            <button
                                class="flex items-center bg-blue-600 hover:bg-blue-700 text-gray-100 px-4 py-2 rounded text-sm space-x-2 transition duration-100">
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">
                            Password
                        </h2>

                        <!-- Current Password  -->
                        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="currentPassword"
                                    class="block text-sm font-medium leading-6 text-gray-900">Current Password</label>
                                <div class="mt-2">
                                    <div
                                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                        <input type="password" name="currentPassword"
                                            class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                            placeholder="Current Password" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- New Password  -->
                        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="newPassword" class="block text-sm font-medium leading-6 text-gray-900">New
                                    Password</label>
                                <div class="mt-2">
                                    <div
                                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                        <input type="password" name="newPassword"
                                            class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                            placeholder="New Password" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password  -->
                        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="confirmPassword"
                                    class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                                <div class="mt-2">
                                    <div
                                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                        <input type="password" name="confirmPassword"
                                            class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                            placeholder="Confirm Password" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full mt-5">
                            <button
                                class="flex items-center bg-blue-600 hover:bg-blue-700 text-gray-100 px-4 py-2 rounded text-sm space-x-2 transition duration-100">
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </v-card>
    </div>
</template>

<script>

export default {
    // props : {type:Number},
//     props:['type'],
//  mounted(){
//     this.currentType =this.type
//    alert(this.type);
//  },
    data() {
        return {
            showEdit: false,
            // currentType:this.$route.params.type,

        };
    },
};
</script> 
