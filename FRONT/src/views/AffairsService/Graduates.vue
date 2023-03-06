<template>
<div>
  <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
الخريجون &nbsp;&nbsp;</div>
  </div>
<div class="flex-cols flex m-6">

    <div class="row-start-1 flex justify-between items-center  ml-24   ">

  <form action="" @submit.prevent="SearchStudent()" class="text-primary flex justify-between font-medium text-2xl space-x-6 absolute right-4">
   
    <div> 
  
     <button class="bg-primary text-body text-xl rounded-lg text-center m-5 py-1 px-2 hover:bg-hovercolor" >بحث</button>
  <input type="text" v-model="searchs"  class=" rounded-lg search  bg-no-repeat p-3 text-right hover:border hover:border-primary" dir="auto" >

  </div>
  
    <div class="pt-6">

  <label for="id">: الرقم</label>
  
  </div>
  </form></div>

      <div class="filter flex  space-x-6 text-xl  text-primary justify-center items-center mr-24">

        <div class="space-x-2">
    <input type="number" id="year" placeholder="YYYY" min="1970"  max="2100"  v-model="year" class="h-10 p-2 cursor-pointer rounded-lg">
    <label>
            :السنة &nbsp;
    </label>
    </div>

    <div class="space-x-2">
  
      <select name="semester"   class="h-10 cursor-pointer rounded-lg" v-model="sem">
        <option value="1">الأول</option>
        <option value="2">الثاني</option>
        <option value="3">تكميلي</option>
        <option value="4">كامل</option>
    </select>
      <label> 
       :الفصل&nbsp;
        </label>
    </div>
    <div>
    <button class="bg-primary text-body text-xl rounded-lg text-center m-5 py-1 px-2  h-10 hover:bg-hovercolor" @click="show()">عرض</button>
    </div>
    </div>
          <div class="border-r-2 border-hovercolor">
       
      </div>
    </div>
    <table class=" text-primary bg-white-100 text-lg">
           <thead>
             <th>إصدار وثيقة</th>
            <th>الفصل</th>
            <th>المعدل</th>
            <th>الرقم الجامعي</th>
            <th>المواليد </th>
            <th>اسم الأب</th>
           <th>الاسم و الكنية</th>
        
           </thead>

           <tbody>
               <tr v-for="g in grad" :key="g.uid">
                   <td><button class="bg-primary text-white text-xl rounded-lg text-center w-16 p-1 hover:bg-hovercolor ">إصدار</button></td>
                   <td>{{g.sem}}</td>
                   <td>{{g.av}}</td>
                   <td>{{g.uid}}</td>
                   <td>{{g.age}}</td>  
                   <td>{{g.father}}</td>
                   <td>{{g.name}} {{g.ken}}</td>
               </tr>

           </tbody>   
    </table>
     <!-- <div class="text-xl text-right  text-red-700 mx-auto pr-48 ">{{msg}}</div>  -->
    <div class="flex justify-center">
    <button class="bg-primary text-white text-xl rounded-lg text-center w-20 p-2 hover:bg-hovercolor "> إصدارالكل</button></div>
</div>
</template>
<script>
import axios from "axios";

import { mapGetters } from 'vuex'
export default{
    // eslint-disable-next-line vue/multi-word-component-names
    name:'Graduates',
    data(){
        return{
            grad:{},
            searchs:'',
            year:2000,
            sem:1,
            msg:'',
            gradS:{}
        }
    },
    components:{
        
    },
    
        methods:{
    back(){
        this.$router.go(-1)
    },   async show(){
    
       try{
      console.log(this.spec)
      const res = await axios.post("/getGraduateStudents",{ graduation_year:this.year,
      specialization:this.spec,graduation_semester:this.sem},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}})
     console.log(res)
     this.grad=res.data.data
     
       }
 catch (e) {
      console.log(e);
    }  
     
    },async SearchStudent(){
         try{
      console.log(this.spec)
      const res = await axios.post("/graduation",{university_num:this.searchs, graduation_year:this.year,
      specialization:this.spec,graduation_semester:this.sem},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}})
     console.log(res)
     this.gradS=res.data.data

    
       }
 catch (e) {
      console.log(e.response.data.message);
      this.msg=e.response.data.message
      this.searchs=e.response.data.message
          
    }  
    }
    
},mounted() {
     const y=   new Date().getFullYear();
     this.year=y
     document.getElementById("year").max=y
    },computed:{
   ... mapGetters(["spec"]),

}
    
}
</script>
<style>
table{
    border: 2px solid #626262;
    border-radius: 2px;
    margin:  20px auto;
    width:98%
   

}
th{
    border: 2px solid #626262;
    border-radius: 2px;
    border-collapse: collapse;
    color: white;
    border: 2px solid #000000;
    
}
td{
    color: black;
    background-color: white;
    border: 2px solid #000000;
    border-radius: 2px;
    text-align: center;
}

</style>
