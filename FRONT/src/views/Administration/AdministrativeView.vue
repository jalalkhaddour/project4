<template>
  <div class="bg-body w-full h-full">
     
    <div class=" w-full  text-white  h-12 cursor-pointer bg-primary flex  justify-between items-center">
            <div>welcome {{username}}</div>      
        <div  class="space-x-9 mr-5 flex justify-between text-xl font-medium">
    
          <router-link to="/about">&nbsp;حول &nbsp;</router-link>
         <router-link to="/administrtive" > &nbsp;إداري &nbsp;</router-link>
          <router-link to="/"  > &nbsp; الرئيسية&nbsp; </router-link>
       </div>
    </div>
      <div style="text-align:center" class="text-5xl p-6 text-primary">الخدمات الإدارية</div>
    <div class="my-1 space-y-8 bg-body text-white text-2xl " >
   
        <div class=" flex justify-center space-x-24 py-4">
        
         <router-link :to="{name:'log'}"> <button class=" card h-40 rounded-full w-40 bg-primary">سجل النشاط</button></router-link>
         <router-link :to="{name:'userperm'}"> <button class="   card h-40 rounded-full w-40 bg-primary"> الصلاحيات</button></router-link>
        </div>
        <div class=" flex justify-center space-x-24">
        
         <router-link :to="{name:'Users'}" > <button class="  card h-40 rounded-full w-40 bg-primary" >المستخدمون</button></router-link>
         <router-link :to="{name:'addUser'}"> <button class=" card h-40 rounded-full w-40 bg-primary">إضافة موظف</button></router-link>
         <!-- <router-link to=""> <button class=" ring-4 hover:bg-hovercolor h-40 rounded-full w-40 bg-primary">إزالة مستخدم</button></router-link> -->
         </div>
    </div>
    <br><br><br>
  </div>
</template>

<script> 
import { mapGetters } from 'vuex'
import axios from "axios";
import { inject, onMounted } from 'vue';



export default{
  created () {
  },
 
  data () {
    return {
   
      users:[]
    }
  },

  methods:{
   
       
  },computed:{
         ...mapGetters('AdUser',['username','password','Authenticated','cookies']),

  }
}
</script>

<style>
.backdrop{
    top:0px;
    position: fixed;
    background-color: rgb(0, 0, 0,0.4);
    width: 100%;
    height: 100%;}
    .more{
    top:50px;
   
    }
    .ba{
    top:0px;
    position: fixed;
    background-color:rgb(192, 192, 192);
    width: 100%;
    height: 100%;
}
</style>