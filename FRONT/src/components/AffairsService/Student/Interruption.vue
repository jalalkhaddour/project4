<template>
  <div class="mx-12 text-xl font-medium">
      <table>
          <thead>   
              <th class="text-lg">عدد الإيقافات</th>
               <th class="text-lg">رقمه</th>
               <th class="text-lg">تاريخ وصل التسجيل</th>
               <th  class="text-lg">فصل الإيقاف</th>
                <th class="text-lg">سنة الإيقاف</th>
             
          </thead>
           <tbody v-for="susp in susps" :key="susp">
          
              <tr>
          <td>{{susp.counter}} </td>
          <td>{{susp.university_num}} </td>
          <td>{{susp.reg_receipt_date}} </td>
          <td>{{susp.suspension_semester}} </td>
          <td> {{susp.suspension_year}}</td>
          
              </tr>
          </tbody>
      </table>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: ['suspsen'],
  data () {
    return {
        susps:[],
    }
  },created(){
  // this.susps=this.suspsen
  },async mounted(){
     try{
      const res = await axios.post("/getsuspension"+{ university_num:this.university_num,
      specialization:this.spec},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}})
       console.log(res.data)
       this.susps=res.data
       }
 catch (e) {
      console.log(e);
    }  
  }

}
</script>

<style>

</style>