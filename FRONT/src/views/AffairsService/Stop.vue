<template>
     <div>
        <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
ترقين قيد &nbsp;&nbsp;</div>
  </div>
  <div class="flex  space-x-3 w-full pl-20 py-9   ">

    <button class="bg-primary text-body text-xl rounded-lg text-center m-2  py-2 px-2 hover:bg-hovercolor" @click="stops" > إنسحاب</button>
  </div>
  <div class="grid text-2xl text-right  text-primary grid-cols-2 my-2 py-20 border-2 border-hovercolor   rounded-lg  pr-5  mx-20">

  <div class="flex flex-col  border-r-2 border-hovercolor  pl-28 ">
     <div class="flex space-x-2 items-center">
   <textarea rows="2" cols="25" id="reason" v-model="stop.reason"  class=" rounded-lg ml-5 m-3 text-right p-1"></textarea>
    <label for="reason"  class="ml-5 text-2xl">:السبب</label></div>
     <div class="flex space-x-2  items-center text-right m-3  ">
    <input type="radio" name="langsec" value="fr" id="fr" v-model="stop.specialization"  class=" ml-36" >
    <label for="fr" class="mx-5">&nbsp;فرنسي&nbsp;</label>
    <input type="radio" name="langsec" value="en" id="en" v-model="stop.specialization"  class="ml-10" >
    <label class="mx-5 " for="en">&nbsp;انكليزي&nbsp;</label>
    <label for="" class="ml-3  pl-3">:الاختصاص&nbsp;&nbsp;</label></div>


  </div>
     <div class="flex flex-col  pl-24 space-x-3">
  <div class="flex space-x-2 items-center ">

    <input type="text" id="university_num"  v-model="stop.university_num" dir="auto" name="university_num"  class=" rounded-lg  m-3 ml-6 mr-2 text-right  p-1 " >
    <label for="university_num" class="ml-1 text-2xl">:الرقم الجامعي</label></div>
         <div class="flex space-x-2 items-center">
    <input type="text" id="stop_year" name="stop_year" v-model="stop.stop_year" class=" rounded-lg  m-3 text-right p-1" >
    <label for="stop_year"  class="ml-5 text-2xl">:السنة</label></div>


   <div class="items-center flex space-x-2">
          <input type="text" dir="auto" id="new_university" v-model="stop.new_university"  class="rounded-lg m-3 p-1 text-right "  />
             <label class="ml-5 text-2xl" for="new_university">: الجامعة الجديدة</label>
       </div>
   </div></div>


<div class="backdrop3 " v-if="msg.length" >
     <div class="text-2xl text-primary flex pb-6 space-y-4 rounded-lg flex-col my-56 border-3 w-96 bg-hovercolor mx-auto  border-primary"    >
       <div class=" h-9 flex items-center relative w-full  p-3 pt-4 "  >

       <img src="../../assets/Images/close-box.png" class=" absolute right-3  cursor-pointer" @click="handle()" alt="">
       </div>

       <div class="text-lg flex justify-center   rounded-lg  mx-auto text-gray-900" v-if="msg.length!=''">
     {{msg}}
   </div>
   </div>

    </div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/olearning/public/api";
export default {
  data() {
    return {
      stop: {
        university_num: "",
        stop_year: "",
        reason: "",
        new_university: "",
        specialization: "",
      },
      msg: "",

    };
  },
  computed: {
    ...mapGetters("Student", ["university_num", "fullname"]),
    ...mapGetters(["spec"]),
  },

  created(){
     this.stop.university_num = this.university_num;
    this.stop.specialization = this.spec;
  },
  methods: {
     back(){
        this.$router.go(-1)
    },
    handle() {
      this.msg=''
    },
    async stops() {
      try {
        const res = await axios.post("/stop", {
          university_num: this.stop.university_num,
          stop_year: this.stop.stop_year,
          reason: this.stop.reason,
          new_university: this.stop.new_university,
          specialization: this.stop.specialization,
        },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});

        console.log(res.data);

      } catch (e) {
        console.log(e);
      }
    },
  },
};
</script>
<style lang="">
</style>