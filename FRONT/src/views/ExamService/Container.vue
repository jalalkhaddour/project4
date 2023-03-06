<template lang="">
    <div>
       <div class="space-x-9 w-full text-4xl mb-0 font-light  text-white  relative  h-12 bg-primary flex justify-between items-center">
 <router-link to='/Examination/exam'> <img src="../../assets/Images/arrow-left-circle.png" class="mt-0 h-12  cursor-pointer absolute left-2 top-0"  alt="">  </router-link> 
  </div>
  <ExamForm :sec="section" @show="show"></ExamForm>
   <div class=" border-2 border-hovercolor  p-5 py-1  m-2   rounded-lg flex flex-col ">
   <div class="bg-primary rounded-lg text-body text-2xl px-9 py-1  text-left m-5 mt-1 flex justify-between items-center">
   <p class="cursor-pointer hover:bg-hovercolor rounded-lg py-1 p-2" @click="select('results')" :class="{'ho':section== 'results'}">النتائج الإجمالية</p>
   <p class="cursor-pointer hover:bg-hovercolor rounded-l py-1g p-2" @click="select('halls')" :class="{'ho':section== 'halls'}">القاعات</p>
   <p class="cursor-pointer hover:bg-hovercolor rounded-lg py-1 p-2" @click="select('session')" :class="{'ho':section== 'session'}">جلسات الرصد</p>
  </div>
   
   </div>
  <Halls v-if="section=='halls'" ></Halls>
  <Results v-if="section =='results'"></Results>
  <Session v-if="section =='session'" :showS="showS"></Session>
  
  

  
  
  
    </div>
</template>
<script>

import ExamForm from '../../components/ExamService/ExamForm.vue';
import Halls from '../../components/ExamService/Halls.vue'
import Results from '../../components/ExamService/Results.vue';
import Session from '../../components/ExamService/Session.vue';
import axios from "axios";

import { mapGetters } from 'vuex'
export default {
  methods: {
     select(d){
        this.section=d
    },
    show(d){
      this.showS=d
    }
  },
  data () {
    return {
       section:'',
       showS:false
    }
   
    },
  
   props:['sec'] ,
   mounted(){
    
    this.section=this.sec
   },computed:{
   ... mapGetters(["spec"]),
  } ,components:{Halls,Results,Session,ExamForm}
}
</script>
<style lang="">
    
</style>