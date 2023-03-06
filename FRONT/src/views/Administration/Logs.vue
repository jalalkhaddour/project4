<template >
    <div>
       <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>سجل النشاط</div>&nbsp;&nbsp;</div>
    <div class="grid grid-cols-2 pl-10 relative ">
   
  <!-- <div class=" col-start-2 col-end-3 gap-4 pt-5   mr-2">
     <input type="text" v-model="search" class=" rounded-lg search mt-4 mr-5 bg-no-repeat p-3 py-5 text-right hover:border hover:border-primary" dir="auto" >
      <label for="name" class="text-2xl text-primary pt-4">: أدخل الاسم</label></div>
       <div class="col-start-1 col-end-2  absolute top-5 left-6"> -->
    <!-- <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-2 px-2 hover:bg-hovercolor" @click="load" >سجل الحركة</button> -->
</div>
      </div>
       <div class="py-4" > 
     <table class=" text-primary bg-white-100 text-2xl">
           <thead>
             <th> التعديل</th>
            <th>تاريخ التعديل</th>
            <th>نوع التعديل</th>
            <th>اسم الجدول</th>
            <th>اسم المستخدم</th>
        
           </thead>

          <tbody v-for="(log,id) in logs" :key="id">
               <tr >
                 <td>{{log.data}}</td>
                  <td>{{log.updated_at}} </td>
                  <td>{{log.logType}} </td>
                   <td>{{log.TableName}}</td> 
                   <td>{{log.username}}</td>
                
               </tr>

           </tbody>   
    </table>
    </div>
  
  </template>
  <script>
  import { mapGetters } from 'vuex'
import { ref } from "@vue/reactivity";
import axios from "axios";
import { inject} from 'vue';

  export default{
  methods: {
    back(){
        this.$router.go(-1)
    }  ,async  load (){
            try{
             const res = await axios.get('/getLogs',{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
              console.log(res)

            this.logs=res.data
            console.log(this.logs)
           
              }
        catch (e) {
             console.log(e);
           }
           
    }
  },
  data () {
    return {
        search:'',
        logs:[{}]
     
    }
  },computed:{
     ...mapGetters('AdUser',['username','password','Authenticated','cookies','Role']),
  findUser(){
    return this.logs.filter(us =>{
      return us.username.match(this.search)
    })
  }
  
},async mounted(){
  try{
             const res = await axios.get('/getLogs',{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
              console.log(res)

            this.logs=res.data
            console.log(this.logs)
           
              }
        catch (e) {
             console.log(e);
           }

}
  
  }
  </script>
  <style></style>