<template>
 <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
توزيع القاعات &nbsp;&nbsp;</div>
  </div>
  <div class="justify-between items-center flex">
    <div class="justify-center flex space-x-8 m-2">
          <router-link to="distr">  <button class="bg-primary text-body text-lg rounded-lg text-center   px-5 hover:bg-hovercolor" >فرز</button></router-link>
    <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor" >عرض</button>
    </div>
    <div class="flex items center">
               <div class="flex items-center">
              <select   class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary " >
                  <option value="1">أولى</option>
          <option value="2">ثانية</option>
          <option value="3">ثالثة</option>
          <option value="4">رابعة</option>
              </select>
           <label class="text-lg text-primary p-3 m-3">
            : القاعة
            </label>
    </div>
    <div class="flex items-center">
                      <select  class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary ">
                        <option>1111</option>
                      </select>
           <label class="text-lg text-primary p-3 m-3">
            : المقرر
            </label>
    </div>
        <div class="flex items-center">
              <input type="date"   class="  rounded-lg search   bg-no-repeat p-3 m-2    w-32    text-right hover:border hover:border-primary " dir="auto" />
           <label class="text-lg text-primary p-3 m-3">
            : التاريخ
            </label>
    </div>
        <div class="flex items-center">
              <input type="time"   class="  rounded-lg search   bg-no-repeat p-3 m-2    w-32    text-right hover:border hover:border-primary " dir="auto" />
           <label class="text-lg text-primary p-3 m-3">
            : الوقت
            </label>
    </div>
        <div class="flex items-center">
              <select   class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary " >
                  <option value="first">أولى</option>
          <option value="second">ثانية</option>
          <option value="third">ثالثة</option>
          <option value="fourth">رابعة</option>
              </select>
           <label class="text-lg text-primary p-3 m-3">
            : السنة
            </label>
    </div>

    </div>
  </div>
  <div class=" mt-1 ">
    <Halls></Halls>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.baseURL="http://localhost/olearning/public/api";
import Halls from '../../components/ExamService/Halls.vue'
export default {
    components:{Halls}
,     methods:{
    back(){
        this.$router.go(-1)
    }}
}
   
</script>

<style>

</style>