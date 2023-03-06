<template lang="">
     <div class="mx-12 text-xl font-medium">
      <table>
          <thead> 
          <th v-if="showS"></th>
           <th class="text-lg">التفقد</th>  
           <th class="text-lg">وضع الطالب</th>
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
          
              <tr v-if="showS">
          <td> <button  class="bg-primary text-body text-xl rounded-lg text-center my-1 py-2 px-4 hover:bg-hovercolor"  @click="edit(user)" >
                  إدخال
                  </button> </td>
          <td><input type="text"  class="w-16 border-2 border-primary rounded-lg  text-center " v-model="check"> </td>
          <td> </td>
          <td> </td>
          <td><input type="text"  class="w-32 border-2 border-primary rounded-lg  text-center " v-model="Wresult"></td>
          <td> <input type="text"  class="w-16 border-2 border-primary rounded-lg  text-center " v-model="result"></td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td></td>
          <td> </td>
          
              </tr>      
              <tr v-else>
          <td> </td>
          <td> </td>
          <td> </td>
          <td></td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td></td>
          <td> </td>
          
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
        result:0,
        wresult:'',
        check:'',
        data:[{}]

    }
  },
    props:['showS'],
    async mounted() {
        try{
             const res = await axios.post('/getCheckSess',{code:this.c_code,specialization:this.spec,studyYear:this.study_year,studysemster:this.semster},
             {headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
   
             console.log(res)
             this.data=res.data
              }
        catch (e) {
             console.log(e);
           }
    },
    updated(){
        console.log(this.showS)
    }, computed: {
    ...mapGetters(["spec"]),
    ...mapGetters('Exam',['c_code','study_year','semster']),

  },
}
</script>
<style lang="">
    
</style>