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
   <div style="width:100%;display: flex;flex-direction: row;align-items: center;justify-content: center ">
       <button class="bg-primary text-body text-xl rounded-lg text-center m-5 py-1 px-2  h-10 hover:bg-hovercolor"
   @click="pageIncrease()">التالي
       </button>
       <button class="bg-primary text-body text-xl rounded-lg text-center m-5 py-1 px-2  h-10 hover:bg-hovercolor"
   @click="pageDecrease()">السابق
       </button>
       </div>
</template>
<script>


import axios from "axios";
import { mapGetters } from "vuex";

var page = 1;
export default {
  data() {
    return {
      results: [],
      data: {},
    }
  },
  methods: {
      pageIncrease() {
          page = page + 1
          console.log(page)
          this.refresh()

      },
      pageDecrease() {
          if(page!=1){
          page = page - 1
          this.refresh()}
      },
  async refresh(){
    try {
      const res = await axios.post('/ExamByCourse', {
        code: this.c_code,
        specialization: this.spec,
        study_year: '2013/2012',
        Examsemster: this.semster,
          page: page
      }, { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

      console.log(res)
      this.data = res.data
      this.results = this.data.results
      console.log(this.data)
    }
    catch (e) {
      console.log(e);
    }
  }

  }, async mounted() {
    this.refresh()
  }, computed: {
    ...mapGetters(["spec"]),
    ...mapGetters('Exam', ['c_code', 'study_year', 'semster', 'selYear']),
  }
 
  ,watch:{
    selYear(){
      this.refresh()
    },
    c_code(){
      this.refresh()
    },
    semster(){
      this.refresh()
    }
  }
}
</script>
<style lang="">
    
</style>