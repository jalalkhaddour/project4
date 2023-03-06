<template>
<div>
  <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
طالب جديد &nbsp;&nbsp;</div>
  </div>
<div class="grid text-2xl text-right  text-primary grid-cols-2 my-2  pr-20  mx-2">
   <div class="flex flex-col  border-r-2 border-hovercolor  pl-28">
       <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.homephone}}</div>
  <div class="flex space-x-2 items-center">
    <input type="text" dir="auto" class=" rounded-lg  m-3 text-right  p-1 " name="homephone" v-model="student.homephone" >
    <label for="" class="text-xl" >:الهاتف الأرضي</label></div>
   
    <!-- <div class="flex space-x-2 items-center">
    <input type="text" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:تاريخ التسجيل</label></div> -->
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.nationality}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text"  dir="auto" name="nationality" v-model="student.nationality" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:الجنسية</label></div>
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.recruitment_division}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text"  dir="auto" name="recruitment_division" v-model="student.recruitment_division" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:شعبة التجنيد</label></div>
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.phone}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text"  dir="auto" name="phone" v-model="student.phone" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:رقم الجوال</label></div>

        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.gender}}</div>
     <div class="flex space-x-2 items-center text-right m-3  ">
    <input type="radio" name="gender" value="male" id="male" v-model="student.gender" class=" ml-40" >
    <label for="male" class="mx-5">&nbsp;ذكر&nbsp;</label> 
    <input type="radio" name="gender" value="female" id="female" v-model="student.gender" class="ml-10" >
    <label class="mx-5 " for="female">&nbsp;أنثى&nbsp;</label>
    <label for="" class="ml-3 pl-3">:الجنس</label></div>
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.specialization}}</div>
  
   <div class="flex space-x-2 items-center text-right m-1 ">
    <input type="text" :disabled="!Show" class=" rounded-lg  m-3 text-right p-0" v-model="student.specialization" >
    <label for="" class="ml-3 pl-3">:القسم</label>
    </div> 
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.certifeca}}</div>
    <div class="flex-col space-x-2 items-center text-right my-1 border border-hovercolor rounded-lg  space-y-2  mr-20 ">
    <div class="mr-12">
     <label for="" class="ml-5 pl-9 ">:الشهادة</label></div>
       
    <div class="flex space-x-2 items-center mr-8">
      <input type="radio" name="certifeca" value="out_col" id="out_col" v-model="student.certifeca" class=" ml-10 " >
    <label for="out_col" class="mx-2">&nbsp;مستنفذ و منقول&nbsp;</label>
    <input type="radio" name="certifeca" value=" col" id=" col" v-model="student.certifeca" class=" ml-10" >
    <label for="col" class="mx-5 ">&nbsp;شهادة جامعية&nbsp;</label> 
    </div><div  class="flex space-x-3 items-center">
    <input type="radio" name="certifeca" value="inst" id="inst_en" v-model="student.certifeca" class="ml-10" >
    <label class="mx-4 " for="inst">&nbsp; معهد إنكليزي&nbsp;</label>
    <input type="radio" name="certifeca" value="bac" id="bac" v-model="student.certifeca" class="ml-10" >
    <label for="bac" class="mx-8 ">&nbsp;بكلوريا&nbsp;&nbsp;</label>
    </div>
</div>
 <div class="text-2xl text-right pt-8 text-green-800 mx-auto pr-48" v-if="success"> {{msg}}</div>

   <!-- <div class="text-2xl border border-primary mr-20 rounded-lg p-3 text-red-500" v-if="msg.length!=''">
     {{msg}}
   </div> -->
  </div>
<div class="flex flex-col  pl-24">
    <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.university_num}}</div>
  <div class="flex space-x-2 items-center">
    <input type="text" disabled="true"  dir="auto" name="university_num" v-model="student.university_num" class=" rounded-lg  m-3 text-right  p-1 " >
    <label for="">:الرقم الجامعي</label></div>
   <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.fullname}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text"  dir="auto" name="fullname" v-model="student.fullname" class=" rounded-lg  m-3 text-right p-1 " >
    <label for="">:الاسم و النسبة</label></div>
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.fathername}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text"  dir="auto" name="fathername" v-model="student.fathername"  class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:اسم الأب </label></div>
      <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.mothername}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text"  dir="auto"  name="mothername" v-model="student.mothername" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:اسم الأم</label></div>
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.birthplace}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text"  dir="auto" name="birthplace" v-model="student.birthplace"  class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:مكان الولادة </label></div>
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.birthdate}}</div>
    <div class="flex space-x-2 items-center">
    <input type="date" dir="auto" name="birthdate" v-model="student.birthdate" class=" rounded-lg  m-3 text-right py-1 px-14" >
    <label for="">:تاريخ الولادة </label></div>
   

        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.place_num_registration}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text"  dir="auto" name="place_num_registration" v-model="student.place_num_registration" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:محل ورقم القيد </label></div> 
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.national_num}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text"  dir="auto" name="national_num" v-model="student.national_num" class=" rounded-lg  m-3 text-right  p-1 " >
    <label for="">:الرقم الوطني</label></div>
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.address}}</div>
     <div class="flex space-x-2 items-center">
    <input type="text"  dir="auto"  class=" rounded-lg  m-3 text-right p-1 " name="address" v-model="student.address" >
    <label for="">:العنوان</label></div>
  </div>
  
     <button class="bg-primary text-body lg:text-xl sm:text-sm rounded-lg text-center m-2  py-2 px-2 hover:bg-hovercolor w-36 " @click="addStudent"  >حفظ </button>

</div>
</div>


  
</template>

<script>
import { mapGetters } from 'vuex'
import { ref } from '@vue/reactivity'
import axios from "axios";

export default {
props:['Show'],
setup(){
    
    const student=ref({
        fullname:'',
        fathername:'',
        mothername:'',
        birthplace:'',
        birthdate:'',
        gender:'',
        place_num_registration:'',
        nationality:'',
        address:'',
        phone:'',
        recruitment_division:'',
        national_num:'',
        homephone:'',
        university_num:'',
        certifeca:'',
        specialization:'',
    })
    const success=ref('')
    const msg=ref('')
    const birthda=ref('')
    const errors=ref({
        fullname:'',
        fathername:'',
        mothername:'',
        birthplace:'',
        birthdate:'',
        gender:'',
        place_num_registration:'',
        nationality:'',
        address:'',
        phone:'',
        recruitment_division:'',
        national_num:'',
        homephone:'',
        university_num:'',
        certifeca:'',
        specialization:'',
    })
   return{student,msg,close,birthda,errors,success}
}
,        methods:{
    back(){
        this.$router.go(-1)
    },
   async addStudent(){

    
    console.log(this.student.university_num)
    //  this.format
       try{
      const res = await axios.post("/createStudent",
      {fullname:this.student.fullname,
      fathername:this.student.fathername,
      mothername:this.student.mothername,
      birthplace:this.student.birthplace,
      birthdate:this.student.birthdate,
      gender:this.student.gender,
      place_num_registration:this.student.place_num_registration,
      nationality:this.student.nationality,
      address:this.student.address,
      phone:this.student.phone,
      recruitment_division:this.student.recruitment_division,
      national_num:this.student.national_num,
      homephone:this.student.homephone,
      university_num:this.student.university_num,
      certifeca:this.student.certifeca,
      specialization:this.spec,
      },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});

      console.log(res)
   this.success=true
   this.msg=res.data.message
   this.student={}
     try{
      const res = await axios.post("/GetLastUnvBySpec",{specialization:this.spec},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});
       this.student.university_num=res.data.lastNum
       console.log(res)
    }
 catch (e) {
      console.log(e);}
     
       }
 catch (e) {
      console.log(e);
      const error=e.response.data.errors
      // console.log(error)
      if(error.university_num!=null)
      this.errors.university_num=error.university_num.toString()
      if(error.fullname!=null)
      this.errors.fullname=error.fullname.toString()
      if(error.fathername!=null)
      this.errors.fathername=error.fathername.toString()
      if(error.mothername!=null)
      this.errors.mothername=error.mothername.toString()
      if(error.birthplace!=null)
      this.errors.birthplace=error.birthplace.toString()
      if(error.birthdate!=null)
      this.errors.birthdate=error.birthdate.toString()
      if(error.national_num!=null)
      this.errors.national_num=error.national_num.toString()
      if(error.gender!=null)
      this.errors.gender=error.gender.toString()
      if(error.certifeca!=null)
      this.errors.certifeca=error.certifeca.toString()
      if(error.specialization!=null)
      this.errors.specialization=error.specialization.toString()
    }

   },format(){
   const date=new Date(this.student.birthdate)
    // const day=date.getDate();
    // const month=date.getMonth()+1;
    // const year=date.getFullYear();
    // this.birthda=day+"-"+month+"-"+year
    // console.log(day+" "+month+" "+year) 
    console.log(date) 
}
    
},computed:{
 
   ... mapGetters(["spec"]),
   

},async mounted(){
         try{
      const res = await axios.post("/GetLastUnvBySpec",{specialization:this.spec},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});
       this.student.university_num=res.data.lastNum
       console.log(res)
    }
 catch (e) {
      console.log(e);}
},created(){
    switch(this.spec){
    case 'fr':
      this.student.specialization="فرنسي";
      break;
    case 'en':
      this.student.specialization="إنكليزي";
      break;}
  }
}


</script>

<style>

</style>