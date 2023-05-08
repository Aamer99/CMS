<script>

export default{

  data(){
    return{
      phoneNumber:"aaaa",
      formValues:{

        name:'',
        email:'',
        phoneNumber:'',
        gender:"",
        selected:'',
        jobLocation:[]

      }
    }
  },
  methods:{
    submitForm(){


      console.log("form data",this.formValues);
    }
  }
}

</script>

<template>

  <div>
    {{ JSON.stringify(formValues,null,2) }}
  </div>
  <form @submit.prevent="submitForm">
    <div>
      <label for="name">Name</label>
      <input   v-model="formValues.name" type="text" name="name" id="name" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
    </div>

    <div>
      <label for="name">Email</label>
      <input  v-model.lazy="formValues.email" type="email" name="email" id="emil" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
    </div>

    <div>
      <label for="name">Phone Number</label>
      <input  v-model="formValues.phoneNumber" type="text" name="phoneNumber" id="phoneNumber" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
    </div>


    <div>
      <label for="name">Gender</label>
      <div>
        <label>Male</label>
        <input  value="Male" v-model="formValues.gender" type="radio"  name="gender" id="gender"/>
      </div>
      <div>
        <label>Female</label>
        <input  value="Female" v-model="formValues.gender" type="radio" name="gender" id="gender" />
      </div>
      
    </div>
    
    <div>   
      <label for="country">Country</label>
    
    <select v-model="formValues.selected" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
      <option>Saudi Arabia </option>
      <option>Spain</option>
      <option>France</option>
      <option>Germany</option>


    </select>

  </div>

  <div>   
      <label for="country">Job Location</label>
    
    <select multiple v-model="formValues.jobLocation" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
      <option>Saudi Arabia </option>
      <option>Spain</option>
      <option>France</option>
      <option>Germany</option>


    </select>

  </div>
 <div>
  <button type="submit">Submit</button>
 </div>

  </form>

 
</template>
