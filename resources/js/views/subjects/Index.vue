<script>

import axios from 'axios';
import api from '../../api';
import { RouterLink } from 'vue-router';



export default {
    data() {
        return {
            
            visible: null,
            subjects: null
        }
    },

    computed: {
            
    },
    mounted() {
        this.getSubjects()
       
    },
 
    methods: {
        
        getSubjects(){

            api.get('subject')
            .then(res => {
                this.subjects = res.data
            })
        }

    },
    
    

}

</script>
<template>

    <Fluid>
        
        <div  class="card flex flex-col gap-4">
            <div class="font-semibold text-xl">Предметы</div>

            <div v-if="!subjects" class="card flex flex-col gap-4">
                <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>

            </div>
            <div class="grid  " v-if="subjects">
                <DataTable :value="subjects"  >
                    <Column field="#" header="№" style="width:3%" >
                        <template #body="slotProps">
                            {{ slotProps.index + 1 }}
                        </template>
                    </Column>
            
                    <Column field="name" header="Наименование" sortable></Column>
                    <Column field="short_name" header="Краткое наименование" sortable></Column>
                    <Column field="quantity" header="">
                        <template #body="slotProps">
                            

                        </template>
                  
                    </Column>
                </DataTable>
            </div>
          


        </div>
    </Fluid>


</template>

