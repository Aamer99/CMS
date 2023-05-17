

<template>
  <div v-show="authenticated" className = "bg-gray-500 bg-opacity-70 absolute top-0 left-0 right-0 bottom-0 flex justify-center items-center">

<div class="bg-white py-10 sm:py-15 rounded-md">
 <h1>Enter Verification Code</h1>
 <p class="mt-3 text-sm text-gray-500">We have just send a Verification code to {{formValues.email }}.</p>
<div class="mx-auto max-w-2xl px-2 lg:px-2">
<dl class="grid grid-cols-1 gap-x-2 gap-y-2 text-center lg:grid-cols-6">
     <div class="mx-auto flex max-w-xs flex-col gap-x-6" v-for="i in 6">
      
         <input type="text" :maxlength="1" class="block rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset " style="width: 40px; text-align: center;"/>
     </div>
     </dl>
     </div>
     
 </div>
</div>
</template>

<script>

export default{
 name:"OtpAuth",
props:["email","authenticated"]
}

</script>


