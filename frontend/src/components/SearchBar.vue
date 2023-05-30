<template>
    <div class="SearchBarContainer">
        <div class="SearchBar">
            <input type="text" placeholder="Search..." />
            <a href="#"
                ><img class="h-5 w-5" src="../assets/icons/search.png"
            /></a>
        </div>
    
        <div class="SearchBtn" v-show="this.type == 'Department' || this.type == 'Managers'">
            <v-btn
                class="text-none text-subtitle-1"
                color="#5865f2"
                size="small"
                variant="flat"
                @click="$emit('openDialog')"
                
               
            >
                +Create
            </v-btn>
        </div>
    </div>
</template>

<script>
export default{
    props:["type"]
}
</script>