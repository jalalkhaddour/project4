<template>
  <div class="backdrop3">
           <div  class="   text-2xl text-primary   flex   space-y-4   rounded-lg   flex-col p-0  my-24   border-3 border-primary  w-1/3   mx-auto my-50     bg-body "  >
      <div class=" h-9 flex items-center relative w-full p-3 pt-2 bg-primary  " >
        <lable class="mx-auto text-2xl text-body"> فرز</lable>
        <img
          src='../../assets//Images/close-box.png'  class="absolute right-3 cursor-pointer"   @click="ha()"
        />
      </div>
<div class="flex justify-center m-2 space-x-8">

            <div class="flex justify-center space-x-2">
            <label>11111</label>
<label>
    : السعة
</label>
          
           </div>
                      <div class="flex justify-center space-x-2">
            <label>11111</label>
<label>
 : القاعة

</label>
          
           </div>
</div>
<div >
  <div>
  <div class="flex justify-end m-2 space-x-4">
    <input type="radio" name="d"/>
    <label> 
      فرز يدوي
    </label>
  </div>
  <div class="flex justify-end mr-24">
    <div>
    <div>
    <input type="text" class="search m-2 rounded-lg w-32">
    <label>
      :من الطالب 
    </label>
  </div>
      <div>
    <input type="text" class="search m-2 rounded-lg w-32">
    <label>
      :إلى الطالب 
    </label>
  </div>
    </div>
  </div>

  </div>
  <div class="flex justify-end m-2 space-x-4">
    <input type="radio"  name="d"/>
    <label>
       فرز  آلي
    </label>
  
  </div>

</div>
           <div class="flex justify-center m-2" >
            <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor m-6" >تعبئة</button>
           </div>
      </div>
    </div>
</template>

<script>
import axios from "axios";
axios.defaults.baseURL="http://localhost/olearning/public/api";
export default {
  methods: {
    ha() {
      this.$emit("close");
    }
}}
</script>

<style>

</style>