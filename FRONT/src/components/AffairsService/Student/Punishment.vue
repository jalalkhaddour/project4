<template>
<div class="pl-0">

 <button class="bg-primary text-body text-xl rounded-lg text-center  py-1 px-2  hover:bg-hovercolor w-28 mx-16 h-10" v-if="dept=='exam'" @click="handle(true)" > إضافة </button>
  <div class="mx-12">
      <table>
    <thead>
    
      <td class="bg-primary text-white text-lg" style="width:25%"> عدد الفصول</td>
      <td class="bg-primary text-white text-lg" style="width:25%"> النوع</td>
       <td class="bg-primary text-white text-lg" style="width:25%">السبب </td>
     <td class="bg-primary text-white text-lg" style="width:25%">استنفاذ </td>
     
    </thead>
 <tbody v-for="p in pun" :key="p">
 <tr>
   <td>{{p.seasons_period}}</td>
   <td>{{p.type}}</td>
   <td>{{p.reason}}</td>
   <td>{{p.IsOut}}</td>
   </tr>
 </tbody>
  </table>

  </div>

  </div>
 
      

</template>

<script>
import axios from "axios";

import { mapGetters } from 'vuex'

export default {
  methods: {
    handle(d){
      this.$emit('open',d)
    }
  },
  data () {
    return {
      addp:false,
      pun:[{}]
    }
  },

  name:'Punishment'
  ,computed:{
   ...mapGetters('Student',['university_num','fullname','info']),
   ... mapGetters(["spec","dept"]),

},async mounted(){
    
    try{
             const res = await axios.post('/getStudentPunishments',{ university_num:this.university_num, specialization:this.spec},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
            console.log(res)
            this.pun=res.data
              }
        catch (e) {
             console.log(e);
           }
},components:{}
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
thead{
    border: 2px solid #363636;
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