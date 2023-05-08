<!-- <script setup>

defineProps({
    userName: {type:string}
})
</script> -->
<script>

import FormComponent from './formComponent.vue';
import formComponent from './formComponent.vue';

//one 

export default{
    // props:["userName","userAge","userEmail","userPhoneNumber"],
    methods: {
        async printUsers() {
            const res = await fetch("https://randomuser.me/api");
            const data = await res.json();
            const user = data.results[0];
            this.name = user.name.first;
            this.email = user.email;
            this.age = user.dob.age;
            this.phoneNumber = user.phone;
            this.imageUrl = user.picture.large;
            this.isHidden = false;
        },
        add(num) {
            this.number = num * 100;
        }
    },
    data() {
        return {
            name: "Omar",
            email: "omar@example.com",
            age: "23",
            phoneNumber: "0549249925",
            imageUrl: null,
            isHidden: true,
            number: 10,
            users: [{ "name": "amer", "age": "20", "email": "amer@example.com", address: [{ "city": "Medinah", "street": "street", "zipCod": 12345 }] }, { "name": "Zyad", "age": "20", "email": "zyad@example.com", "address": [{ "city": "Riyadh", "street": "nnn", "zipCod": 123456 }] }]
        };
    },
    components: { FormComponent }
}


//two 

// defineProps({
//     userName:{type:String},
//     email:{type:String},
//     age:{type:String},
//     phoneNumber:{type:String}
// }),




</script>

<template>


<!-- {{ printUsers() }} -->



       <div class="flex items-center gap-x-6 justify-center" v-if="imageUrl === null">
        <h2>Ther is no image</h2>  
          </div>
   
          <div class="flex items-center gap-x-6 justify-center" v-else>
             
            <img class="h-25 w-25 rounded-full" :src="imageUrl" alt="" v-bind:hidden="isHidden" /> 
          </div>


  <div>
    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
    <input v-bind:value="name" type="text" name="price" id="price" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
  </div>
     

  <div>
    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
      <input  v-bind:value="email" type="text" name="price" id="price" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
  </div>

  <div>
    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Age</label>
      <input  v-bind:value="age" type="text" name="price" id="price" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
  </div>

  <div>
    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Phone Number</label>
      <input  v-bind:value="phoneNumber" type="text" name="price" id="price" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
  </div>
 
  <div v-for="user in users" :key="user.name" >
  <h1 v-if="user.name != 'amer'">{{ user.name }}</h1>
  <h3>{{ user.email }}</h3>
  <h4>{{ user.age }}</h4>
  <div v-for="address in user.address">
  <h5>{{ address.city }}</h5>
  <h5>{{ address.street }}</h5>
  <h6>{{ address.zipCod }}</h6>
  </div>
  
  </div>
  
  
<div class="flex items-center gap-x-6 justify-center" >
  <!-- <button @click="printUsers()" > Click me</button> -->
  <button v-on:click="printUsers(event),add(number,event)">Change user</button>
</div>

<h1> the number is {{ number }}</h1>
<FormComponent/>
</template>


