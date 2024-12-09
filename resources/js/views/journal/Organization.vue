<script>
import axios from 'axios';
export default {
    name: "Organization",



    data(){
        return {
            periods: [],
            loads: [],
            selectedGroup: null,
            selectedLoad: null,
            selectedPeriod: null,
        }
    },

    computed: {
        groups(){
            return this.groups = this.$store.getters.groups
        }
    },
    methods: {
        getPeriodTypes(){
            axios.get(`/api/period_types_by_group/${this.selectedGroup.id}`)
                .then(res => {
                    this.periods = res.data.data
                })
        },

        getLoads(){
            this.getPeriodTypes()
            axios.get(`/api/groups/loads/${this.selectedGroup.id}`)
                .then(res => {
                    this.loads = res.data.data

                })
        },
        getLessons(){
            axios.get(`/api/lessons/${this.selectedGroup.id}/${this.selectedLoad.id}/${this.selectedPeriod.id}`)
                .then(res => {
                    console.log(res.data.data)
                })
        }
    },



    mounted() {

        this.$store.dispatch('getGroupsByOrganization');


    }
}
</script>

<template>

    <div  class="card flex flex-col gap-4">
        <div class="font-semibold text-xl">Журнал</div>
        <div class="flex ">
            <Select  v-model="selectedGroup" :options="groups" optionLabel="group_name" placeholder="Выберите класс" class="mr-3 md:w-56"  @change="getLoads()" />
            <Select  v-model="selectedLoad" :options="loads" optionLabel="subject_name" placeholder="Выберите предмет" class="mr-3 md:w-56"  @change="getLoads($event)" />
            <Select  v-model="selectedPeriod" :options="periods" optionLabel="name" placeholder="Выберите период" class="mr-3 md:w-56"  @change="getLoads($event)" />
            <Button @click="getLessons" label="Загрузить" icon="pi pi-arrow-circle-down" severity="secondary" class="mr-2" />
        </div>

    </div>
    <div  class="card flex flex-col gap-4">


    <table>
        <thead>
        <tr>
            <td class="number" rowspan="3">№</td>
            <td class="fio" rowspan="3">Фамилия, Имя</td>
            <td class="month" colspan="8">Январь</td>
            <td class="month" colspan="4">Февраль</td>
            <td class="sball" rowspan="3">Средений балл</td>
            <td class="itog" rowspan="3">1 полугодие</td>
        </tr>
        <tr class="dates" >
            <td class="date">1</td>
            <td class="date">2</td>
            <td class="date">3</td>
            <td class="date">4</td>
            <td class="date" colspan="2">5</td>
            <td class="date">6</td>
            <td class="date">7</td>
            <td class="date">8</td>
            <td class="date">9</td>
            <td class="date">10</td>
            <td class="date">11</td>
        </tr>
        <tr>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
            <td class="type_lessons">О</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="num">1</td>
            <td class="td_fio" >Иванов Иван</td>
            <td class="mark" ><input class="edit_mark" type="text"></td>
            <td class="mark">
                <div class="mark-container">
                    <div class="mark_div mark5 firstMark">5</div>

                    <input class="edit_mark" type="text">

                </div>

            </td>
            <td class="mark">
                <div class="mark-container">
                    <div class="mark_div mark5 firstMark">5</div>
                    <span class="slash">/</span>
                    <div class="mark_div mark4 secondMark">4</div>

                </div>
                <input class="edit_mark" type="text">
            </td>
            <td class="mark">
                <div class="mark-container">
                    <div class="mark_div mark5 firstMark">5</div>



                </div>
                <input class="edit_mark" type="text">

            </td>
            <td class="mark">
                <div class="mark-container">
                    <div class="mark_div mark3 firstMark">3</div>


                </div>
                <input class="edit_mark" type="text">
            </td>
            <td class="mark">
                <div class="mark-container">

                    <input class="edit_mark" type="text">
                </div>

            </td>
            <td class="mark"><input class="edit_mark" type="text"></td>
            <td class="mark"><input class="edit_mark" type="text"></td>
            <td class="mark"><input class="edit_mark" type="text"></td>
            <td class="mark"><input class="edit_mark" type="text"></td>
            <td class="mark"><input class="edit_mark" type="text"></td>
            <td class="mark"><input class="edit_mark" type="text"></td>
            <td class="mark"><input class="edit_mark" type="text"></td>
            <td class="mark"><input class="edit_mark" type="text"></td>
        </tr>
        </tbody>
    </table>
    </div>
</template>

<style scoped >




table {
    border-collapse: collapse;

    border-spacing: 1em 2px;
}


.mark:hover {
    background-color:  rgb(189, 213, 236);
}
thead  {

    background: rgba(45, 126, 198, 0.94);

}


thead > tr > td {
    color: rgba(255, 255, 255, 0.82);

    font-size: 14px;
    font-weight: 700;
    line-height: 19px;
    letter-spacing: 0;
    text-align: left;
    width: 40px;
    height: 35px;
}

.number {
    width: 50px;

    border-radius: 20px 0 0 0;
    color: rgba(255, 255, 255, 0.82);
    font-family: 'Cera Round Pro DEMO', sans-serif;
    font-size: 16px;
    font-weight: 700;
    line-height: 19px;
    letter-spacing: 0px;
    text-align: center;
}

.itog {
    border-radius: 0 20px 0 0 ;
    text-align: center;
}

.date {
    text-align: center;
    color: rgba(255, 255, 255, 0.82);
    font-family: 'Cera Round Pro DEMO', sans-serif;

    font-size:16px;
    font-weight: 700;
    line-height: 1px;
    letter-spacing: 0;
    border-right: 1px solid rgb(202, 200, 200);
    border-bottom: 1px solid rgb(202, 200, 200);
    border-top: 1px solid rgb(202, 200, 200);

}


.fio {
    width: 150px;
    text-align: center;
    color: rgba(255, 255, 255, 0.82);
    font-family: 'Cera Round Pro DEMO', sans-serif;
    font-size: 16px;
    font-weight: 600;
    line-height: 18px;
    letter-spacing: 0px;
    border-right: 1px solid rgb(202, 200, 200);
    border-left: 1px solid rgb(202, 200, 200);



}



.sball {
    width: 69px;
    text-align: center;
    border-right: 1px solid rgb(202, 200, 200);

}

.type_lessons{
    text-align: center;
    border-right: 1px solid rgb(202, 200, 200);
}
.month {
    text-align: center;
    border-right: 1px solid rgb(202, 200, 200);
}


tbody >tr >td {
    border: 1px solid rgb(202, 200, 200);
    height: 34px;
}

.num{
    text-align: center;
}


.num, .td_fio {
    color: rgba(0, 0, 0, 0.8);
    font-family: 'Cera Round Pro DEMO', sans-serif;
    font-size: 16px;
    font-weight: 500;
    line-height: 18px;
    letter-spacing: 0px;

}

.mark {
    text-align: center;

}

.marks {
    display: flex;
}

.mark_div {

    width: 18px;
    height: 23px;
    color:#fff;

    margin-top: 4px;

    font-size: 18px;
    font-family: 'Cera Round Pro DEMO', sans-serif;

}

.mark5{
    background: rgba(31, 153, 28, 0.75);
}
.mark4{
    background: rgba(45, 158, 135, 0.75);
}
.mark3{
    background: rgb(216, 167, 59);
}
.mark2{
    background: rgba(190, 55, 55, 0.79);
}

.edit_mark {
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    background: transparent;
    outline:none;
    border: 0px;
    display: none;

}


.edit_mark:focus{

    outline:none;
    background-color:  rgb(189, 213, 236);
    border: 1px solid rgb(202, 200, 200);
}
input[type="text"]{text-align: center;}


.switch {
    position: relative;
    display: inline-block;
    top: 50%;
    left:50%;
    transform: translate(-50%,-50%);
}

input[type="checkbox"]{
    position: relative;
    width: 80px;
    height: 40px;
    -webkit-appearance: none;
    outline: none;
    background: #c6c6c6;
    border-radius: 20px;
    box-shadow: inset 0 0 5px rgba(0,0,0,.2);

}


.mark-container {
    display: flex;
    justify-content: center;
}

.secondMark {
    margin-left: 2px; /* Добавляем отступ слева */
}




.mark_container .firstMark:only-child {
    /* Стиль для firstMark, если она единственный ребенок */
    justify-content: center;
    margin: 0 auto;
}

.mark_container .firstMark:not(:only-child) {
    /* Стиль для firstMark, если она не единственный ребенок */
    justify-content: flex-start;
    margin-right: 5px;
}


.slash {
    font-size: 20px;
    font-weight: 500;
    color: #b3a6a6
}


</style>
