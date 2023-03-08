<template lang="">

   <div class="mx-12 text-xl font-medium">
       
      <table>
          <thead>   
              <th class="text-lg">ملاحظات</th>
              <th class="text-lg">النتيجة</th>
              <th class="text-lg">كتابة</th>
              <th class="text-lg">العلامة</th>
              <th  class="text-lg">السنة</th>
              <th class="text-lg">اسم الأب</th> 
              <th class="text-lg">الاسم والنسبة</th>
              <th class="text-lg">الرقم الجامعي</th>
             
          </thead>
           <tbody  v-for="item in results" :key="item.id">
          
              <tr>
              
          <td> </td>
          <td> {{item.state}}</td>
          <td> </td>
          <td>{{item.Mark}}</td>
          <td> </td>
          <td> </td>
          <td> {{item.student_name}}</td>
          <td>{{item.university_num}} </td>
          
              </tr>
          </tbody>
      </table>
  </div>
</template>
<script>


import axios from "axios";
import { mapGetters } from "vuex";

export default {
  data () {
    return {
          results:[],
          data:{}
  }},
  methods: {
    
   
  },async mounted() {
    try{
             const res = await axios.post('/ExamByCourse',{
              code:111,
              specialization:'fr',
              study_year:'2013/2012',
              Examsemster:2
             },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  

             console.log(res)
             this.data=res.data
             this.results=this.data.results
             console.log(this.data)
              }
        catch (e) {
             console.log(e);
           }
    
  },computed: {
    ...mapGetters(["spec"]),
    ...mapGetters('Exam',['c_code','study_year','semster']),
  },
  
}
</script>
<style lang="">
    
</style>