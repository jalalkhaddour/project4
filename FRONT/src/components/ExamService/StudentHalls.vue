<template>

  <div class="  rounded-md border-primary border-2 py-2 px-2  ml-4 mr-4 text-lg">
  <div class="flex text-primary  text-xl  justify-between space-x-10 ">


<div class="space-x-2">
    <label>
        
    </label>
    <label>
: السنة
    </label>
</div>
<div class="space-x-2">
    <lable>
      {{student.mothername}}
    </lable>
    <label>
 : اسم الأم    </label>
</div>

    <div class="space-x-2">
    <lable>
       {{student.fathername}}
    </lable>
    <label>
: اسم الأب    </label>
</div>

<div class="space-x-2">
    <lable>
        {{student.fullname}}
    </lable>
    <label>
    : الاسم والنسبة
    </label>
</div>
</div>
</div>
  <div>
    <table class=" text-primary bg-white-100 text-lg rounded-md border-primary border-2">
           <thead>
           
            <th>الوقت</th>
            <th>التاريخ</th>
            <th> المكان</th>
            <th>رقم القاعة </th>
            <th>اسم المقرر </th>
           <th> رقم المقرر </th>
        
           </thead>

           <tbody>
               <tr >
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>  
                   <td></td>
    
               </tr>

           </tbody>   
    </table>
  </div>


  
</template>

<script>
import { ref } from '@vue/reactivity'
import axios from "axios";

import { mapGetters } from 'vuex'
export default {
 setup(){
  
    const student=ref({
        fullname:'',
        fathername:'',
        mothername:'',
        birthplace:'',
        birthdate:'',
        gender:'',
        place_num_registration:'',
        nationality:'',
        address:'',
        phone:'',
        recruitment_division:'',
        national_num:'',
        homephone:'',
        university_num:'',
        certifeca:'',
        specialization:'',
        created_at:''
    }) 
    return{student}
    },
methods:{
    
    back(){
        this.$router.go(-1)
    
},computed:{
   ...mapGetters('Student',['university_num','fullname','info']),
   ... mapGetters(["spec"]),

}
},updated(){
   this.student=this.student1
},created(){
  this.student=this.student1
  console.log(this.student)
  },props:['student1'],

}
</script>

<style>

</style>