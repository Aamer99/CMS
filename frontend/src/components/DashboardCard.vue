
    <template>
  <div
           class="p-6 bg-white h-full border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
           <div class="grid grid-flow-col w-full">
               <div class="col-span-11">
                   <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"> {{ cardTitle }}</h5>
               </div>
               <div class="col-span-1">
                   <div class="grid grid-flow-col text-center">
                       <div>
                           <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pending</h5>
                           <h1>20</h1>
                       </div>
                       <div>
                           <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Done</h5>
                           <h1>20</h1>
                       </div>
                   </div>
               </div>
           </div>
           <div style="padding: 10px">
               <div class="relative overflow-x-auto">
                   <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                       <thead  class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                           <tr>
                               <th scope="col" class="px-6 py-3 rounded-l-lg" >
                                   Product name
                               </th>
                               <th scope="col" class="px-6 py-3">Qty</th>
                               <th
                                   scope="col"
                                   class="px-6 py-3 rounded-r-lg"
                               >
                                   Price
                               </th>
                           </tr>
                       </thead>
                       <tbody>
                           <tr class="bg-white dark:bg-gray-800">
                               <th
                                   scope="row"
                                   class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                               >
                                   Apple MacBook Pro 17"
                               </th>
                               <td class="px-6 py-4">1</td>
                               <td class="px-6 py-4">$2999</td>
                           </tr>
                           <tr class="bg-white dark:bg-gray-800">
                               <th
                                   scope="row"
                                   class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                               >
                                   Microsoft Surface Pro
                               </th>
                               <td class="px-6 py-4">1</td>
                               <td class="px-6 py-4">$1999</td>
                           </tr>
                           <tr class="bg-white dark:bg-gray-800">
                               <th
                                   scope="row"
                                   class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                               >
                                   Magic Mouse 2
                               </th>
                               <td class="px-6 py-4">1</td>
                               <td class="px-6 py-4">$99</td>
                           </tr>
                       </tbody>
                       <tfoot>
                           <tr
                               class="font-semibold text-gray-900 dark:text-white"
                           >
                               <th scope="row" class="px-6 py-3 text-base">
                                   Total
                               </th>
                               <td class="px-6 py-3">3</td>
                               <td class="px-6 py-3">21,000</td>
                           </tr>
                       </tfoot>
                   </table>
               </div>
           </div>
       </div>
</template>
<script>

export default{
 name:"DashboardCard",
props:["cardTitle","dataArray"]
}

</script>