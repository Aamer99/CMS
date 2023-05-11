<template>

<div class="grid grid-flow-col gap-1 h-scree bg-slate-100"> 

    <div class=" bg-gray-50 col-span-1" style="width: 250px;">
    <div style="border-radius: 0px 0px 100px 0px ;" class=" top-0 left-0 h-screen m-0 flex flex-col bg-blue-900 text-white text-center">
        
        <img src="../assets/images/CMSlogoWhite.png" width="250" height="250"/>


        <div class="h-screen" style=" display: flex; justify-content:space-between; flex-direction:column; height: 70%;">

            <div style=" width: 100px; margin: 10px;" >
                <div v-for="menu in menu" style="padding: 30px;">

                    <RouterLink :to="menu.destination">{{ menu.title }}</RouterLink>
                </div>
            </div>

            <div style=" width: 100%;">

                <div class="grid grid-flow-row gap-2">

                    <div>
                        <img class="mx-auto h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />

                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Judith Black</p>
                        <p class="text-gray-600">CEO of Workcation</p>
                    </div>
                </div>
                
            </div>
           
           
    
        </div>
        </div>
        </div>

        <div class=" col-span-12 ">  

            <RouterView/>


</div>  
    </div>
</template>


<script>
import { RouterLink,RouterView } from 'vue-router';
export default{
    props: ['menu']

    }


</script>