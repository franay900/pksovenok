<script>

import axios from 'axios';
import api from '../../api';
import { RouterLink } from 'vue-router';
import { useToast } from 'primevue/usetoast';



export default {
    data() {
        return {
          
           
        }
    },

    computed: {
            
    },
    mounted() {

    },
 
    methods: {

        
    },
    
    
    

}

</script>
<template>

    <div class="card flex flex-col gap-4">
        <div class="font-semibold text-xl">Ученики</div>

        <div v-if="!periods" class="card flex flex-col gap-4">
            <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

        </div>
        <div v-if="periods">
            <div class="grid">
                
            </div>
        </div>


        <div class="grid grid-cols-10 ">
            <Button label="Добавить" icon="pi pi-plus"  />
        </div>
    </div>



</template>

