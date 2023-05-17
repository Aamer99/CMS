<script>
import dashboardCard from '../../components/DashboardCard.vue';

export default{
    components:{
        dashboardCard
    }
}

</script>
<template>
    <div class="grid grid-flow-row gap-2 h-screen" style="padding: 10px">
        <div>
            <dashboardCard cardTitle="New Employee"/>
        </div>

        <div>
            <dashboardCard cardTitle="New Requests"/>
        </div>
    </div>
</template>
