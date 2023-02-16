<template>
 
<div class="grid grid-cols-3">
<div class="flex flex-col items-center text-right text-primary space-y-4 text-xl mt-8 ">
<div class="items-center justify-center space-x-8">

         <label class="pl-2">1000</label>
        <label> : رقم المقرر </label>
</div>
<div class="items-center justify-center space-x-6">
          <label class="pl-12">1000</label>
        <label> : رقم جلسة الرصد </label>
        </div>
</div>
<div class="flex flex-col items-center text-right text-primary space-y-4 text-xl mt-5 " >
    <div class=" space-x-2">
              <select
          name="semester"
          class="h-10 cursor-pointer rounded-lg"
        >
          <option value="1">الأول</option>
          <option value="2">الثاني</option>
          <option value="3">تكميلي</option>
          <option value="4">كامل</option>
        </select>
        <label> : الفصل&nbsp; </label>
    </div>
        <div class=" space-x-2">
      <select name="cyear" class="h-10 cursor-pointer rounded-lg">
          <option value="1">أولى</option>
          <option value="2">ثانية</option>
          <option value="3">ثالثة</option>
          <option value="4">رابعة</option>
        </select>
        <label> : السنة </label>
    </div>
    
</div>
   <div class="flex flex-col items-center text-right text-primary space-y-2 text-xl mt-5">
    
    <form
      action=""
      @submit.prevent="SearchCourse()"
      class="text-primary flex justify-between font-medium text-2xl space-x-6"
    >
    <div class="flex items-center justify-center">
      <div class="flex justify-center items-center">
        <button      class="   bg-primary text-body text-xl rounded-lg  text-center  m-2  py-1  px-2   hover:bg-hovercolor   " >بحث </button>
        <input type="text" v-model="searchs"  class="  rounded-lg   search bg-no-repeat p-3    w-32    text-right hover:border hover:border-primary " dir="auto" />
      </div>
      <div class="mt-0 mx-2">
        <label for="id" class="pr-10">: الرقم</label>
      </div>
    </div>
    </form>
         <div class=" space-x-2">   
      <select class="h-10 cursor-pointer rounded-lg ml-14">
          <option>1555646</option>
        </select>
        <label class="">: المقرر </label>
        </div>
  </div>


</div>
<div class="flex space-x-12 pl-16 text-primary text-xl pt-9 ">
        <button class="bg-primary text-body text-xl rounded-lg text-center  py-1 px-5 hover:bg-hovercolor" v-if="sec=='session'" @click="show(true)" >فتح  جلسة رصد</button>
    <button class="bg-primary text-body text-xl rounded-lg text-center  py-1 px-2 hover:bg-hovercolor" v-if="sec=='halls'" ><router-link :to="{name:'hallsdistr'}">توزيع</router-link></button>
        <button class="bg-primary text-body text-xl rounded-lg text-center  py-1 px-5 hover:bg-hovercolor" >تعديل</button>
     <button class="bg-primary text-body text-xl rounded-lg text-center  py-1 px-5 hover:bg-hovercolor" >حفظ</button>


  


          <div
        class="
          space-x-4 text-primary flex justify-center items-center border-primary  ">
        <input type="number" id="year" placeholder="YYYY" min="1970" max="2100" v-model="year" class ="h-10 text-center cursor-pointer rounded-lg"/>
        <label class=" text-primary "> :العام الدراسي &nbsp; </label>
        
      </div>
 <div class="items-center justify-center py-2 space-x-8" v-if="sec=='halls'">

         <input type="date">
        <label> : تاريخ الامتحان  </label>
</div>
<div class="items-center justify-center py-2 space-x-8" v-if="sec=='halls'">
          <input type="time">
        <label> : وقت الامتحان </label></div>
</div>

  

 
</template>

<script>
import axios from "axios";
axios.defaults.baseURL="http://localhost/olearning/public/api";
export default {
  methods: {
    show(d){
     this.$emit('show',d)
    }
  },
props:['sec']
,mounted() {
     const y=   new Date().getFullYear();
     this.year=y
     document.getElementById("year").max=y
    }

};
</script>

<style>
</style>