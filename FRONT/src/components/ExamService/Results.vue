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
              <th class="text-lg">النسبة</th>
              <th class="text-lg">الاسم</th>
              <th class="text-lg">الرقم الجامعي</th>
             
          </thead>
           <tbody >
          
              <tr>
          <td> </td>
          <td> </td>
          <td> </td>
          <td></td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
          
              </tr>
          </tbody>
      </table>
  </div>
</template>
<script>


import axios from "axios";


export default {
  data () {
    return {
          results:{}
    }
  },
  methods: {
   
  },async mounted() {
     try{
             const res = await axios.get('/user',{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
             
            
             console.log(res.data.data)
              }
        catch (e) {
             console.log(e);
           }
    
  },
  
}
</script>
<style lang="">
    
</style>