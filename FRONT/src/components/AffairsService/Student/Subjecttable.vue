<template>
<div class="overflow-auto">
      <table>
         
         
 <thead>
     <th class="bg-primary text-white text-lg" style="width:25%"> عدد مرات الرسوب </th>
     <th class="bg-primary text-white text-lg" style="width:25%">الوضع</th>
     <th class="bg-primary text-white text-lg" style="width:25%">النتيجة</th>
     <th class="bg-primary text-white text-lg" style="width:25%">المادة</th>
 </thead>

 <tbody v-for="co in findCourse" :key="co" >
 <tr >
   <td>{{co.NumOfFail}}</td>
   <td>{{co.state}}</td>
   <td>{{co.Mark}}</td>
   <td>{{co.course_name}}</td>
   </tr>
 </tbody>

  </table>
  </div>
</template>

<script>
import axios from "axios";

import { mapGetters } from 'vuex' 
export default{
  props:['sem','allC'],
    data () {
    return {
        course:[{year:'',detal:{first_semster:{},second_semster:{}}}]
      }
    }
    ,
 
    name:'Subjecttable',
    computed:{
   ...mapGetters('Student',['university_num','fullname','info']),
   ... mapGetters(["spec","dept"]),
   findCourse(){
    return this.allC.filter(us =>{
      return us.sem.match(this.sem)
      
    });
  }

}
}
</script>
<style>
table{
    border: 2px solid #363636;
    border-radius: 2px;
    border-collapse: collapse;
    margin:  20px auto;
    width:100%
   

}
th{
    border: 2px solid #000000;
    border-radius: 2px;
    border-collapse: collapse;
    background-color: #626262;
    
}
td{
    color: black;
    background-color: white;
    border: 2px solid black;
    border-radius: 2px;
    text-align: center;
   
}
</style>