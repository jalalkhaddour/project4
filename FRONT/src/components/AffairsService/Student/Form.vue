<template>

<div class="grid text-2xl text-right  text-primary grid-cols-2 my-2  pr-9  mx-2 ">
   <div class="flex flex-col  border-r-2 border-hovercolor  pl-28">
  
  <div class="flex space-x-2 items-center">

    <input type="text" dir="auto" :disabled="!Show" class=" rounded-lg  m-3 text-right  p-1 " name="homephone" v-model="student.homephone" >
    <label for="" class="text-xl" >:الهاتف الأرضي</label></div>
 
    <!-- <div class="flex space-x-2 items-center">
    <input type="text" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:تاريخ التسجيل</label></div> -->
    
    <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto" name="nationality" v-model="student.nationality" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:الجنسية</label></div>
    <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto" name="recruitment_division" v-model="student.recruitment_division" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:شعبة التجنيد</label></div>
    <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto" name="phone" v-model="student.phone" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:رقم الجوال</label></div>
    <!-- <div class="flex space-x-2 items-center">
    <input type="text" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:وضع الطالب</label></div> -->
     <div class="flex space-x-2 items-center" v-if="Show==false">
      <!-- <input type="text" :disabled="!Show" v-model="student.created_at" class=" rounded-lg  m-3 text-right p-0" > -->
      <input type="text" :disabled="!Show" v-model="year" class=" rounded-lg  m-3 text-right p-0" >
    <label for="">:السنة الدراسية</label></div>
     <div class="flex space-x-2 items-center text-right m-3  " v-if="Show">
    <input type="radio" name="gender" value="male" id="male" v-model="student.gender" class=" ml-40" >
    <label for="male" class="mx-5">&nbsp;ذكر&nbsp;</label> 
    <input type="radio" name="gender" value="female" id="female" v-model="student.gender" class="ml-10" >
    <label class="mx-5 " for="female">&nbsp;أنثى&nbsp;</label>
    <label for="" class="ml-3 pl-3">:الجنس</label></div>
   <div class="flex space-x-2 items-center text-right m-1  " v-else>
   <input type="text" :disabled="!Show" class=" rounded-lg  m-3 text-right p-0" v-model="gen">
   <label for="" class="ml-3 pl-3">:الجنس</label>
   </div>
   <div class="flex space-x-2 items-center text-right m-3 " v-if="Show">
    <input type="radio" name="specialization" value="fr" id="fr" v-model="student.specialization" class=" ml-28" :disabled="!Show" >
    <label for="fr" class="mx-5">&nbsp;فرنسي&nbsp;</label> 
    <input type="radio" name="specialization" value="en" id="en" v-model="student.specialization" class="ml-10" :disabled="!Show" >
    <label for="en" class="mx-5 ">&nbsp;إنكليزي&nbsp;</label>
    <label for="" class="ml-3 pl-3">:القسم</label></div> 
    <div class="flex space-x-2 items-center text-right m-1 " v-else>
    <input type="text" :disabled="!Show" class=" rounded-lg  m-3 text-right p-0" v-model="spe" >
    <label for="" class="ml-3 pl-3">:القسم</label>
    </div>
   
 <div class="flex-col space-x-2 items-center text-right my-1 border border-hovercolor rounded-lg  space-y-2  mr-20 " v-if="Show">
    <div class="mr-12" >
     <label for="" class="ml-5 pl-9 ">:الشهادة</label></div>
       
    <div class="flex space-x-2 items-center mr-8">
      <input type="radio" name="certifeca" value="out_col" id="out_col" v-model="student.certifeca" class=" ml-10 " :disabled="!Show" >
    <label for="out_col" class="mx-2">&nbsp;مستنفذ و منقول&nbsp;</label>
    <input type="radio" name="certifeca" value=" col" id=" col" v-model="student.certifeca" class=" ml-10" :disabled="!Show" >
    <label for="col" class="mx-5 ">&nbsp;شهادة جامعية&nbsp;</label> 
    </div><div  class="flex space-x-3 items-center">
    <input type="radio" name="certifeca" value="inst_en" id="inst_en" v-model="student.certifeca" class="ml-10" :disabled="!Show" >
    <label class="mx-4 " for="inst_en">&nbsp; معهد إنكليزي&nbsp;</label>
    <input type="radio" name="certifeca" value="bac" id="bac" v-model="student.certifeca" class="ml-10" :disabled="!Show" >
    <label for="bac" class="mx-8 ">&nbsp;بكلوريا&nbsp;&nbsp;</label>
    </div>
</div>
<div class="flex space-x-2 items-center text-right m-1 " v-else>
    <input type="text" :disabled="!Show" class=" rounded-lg  m-3 text-right p-0" v-model="cer" >
    <label for="" class="ml-3 pl-3">:الشهادة</label>
    </div>
    <div class="text-2xl text-right pt-8 text-green-800 mx-auto pr-48" v-if="success"> {{msg}}</div>
  </div>
<div class="flex flex-col  pl-24">
  <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto" name="university_num" v-model="student.university_num" class=" rounded-lg  m-3 text-right  p-1 " >
    <label for="">:الرقم الجامعي</label></div>
    <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto" name="fullname" v-model="student.fullname" class=" rounded-lg  m-3 text-right p-1 " >
    <label for="">:الاسم و النسبة</label></div>
    <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto" name="fathername" v-model="student.fathername"  class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:اسم الأب </label></div>
    <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto"  name="mothername" v-model="student.mothername" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:اسم الأم</label></div>
    <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto" name="birthlplace" v-model="student.birthlplace"  class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:مكان الولادة </label></div>
    <div class="flex space-x-2 items-center">
    <input type="date" :disabled="!Show" dir="auto" name="birthdate" v-model="student.birthdate" class=" rounded-lg  m-3 text-right py-1 px-14" >
    <label for="">:تاريخ الولادة </label></div>
   
   
    <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto" name="place_num_registration" v-model="student.place_num_registration" class=" rounded-lg  m-3 text-right p-1" >
    <label for="">:محل ورقم القيد </label></div> 
    <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto" name="national_num" v-model="student.national_num" class=" rounded-lg  m-3 text-right  p-1 " >
    <label for="">:الرقم الوطني</label></div>
       <div class="flex space-x-2 items-center">
    <input type="text" :disabled="!Show" dir="auto"  class=" rounded-lg  m-3 text-right p-1 " name="address" v-model="student.address" >
    <label for="">:العنوان</label></div>
  </div>
     <button class="bg-primary text-body lg:text-xl sm:text-sm rounded-lg text-center m-2  py-2 px-2 hover:bg-hovercolor w-36 " @click="editStudent"  v-if="Show">حفظ </button>

</div>


 
</template>

<script>
import { mapGetters } from 'vuex'
import { ref } from '@vue/reactivity'
import axios from "axios";


export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name:'Form',
props:['Show','student1','year'],
setup(){
   const close=ref('false')
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
        created_at:''
    }) 
    const cer=ref('')
    const gen=ref('')
    const spe=ref('')
     const success=ref('')
    const msg=ref('')
  
   

   return{student,msg,close,cer,gen,spe,success}
}
,methods:{
 async editStudent(){
       try{
      const res = await axios.post("/updateStudent",
      {
       fullname:this.student.fullname,
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
      specialization:this.student.specialization,
      },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});

      console.log(res.data)
     this.success=true
   this.msg=res.data.message
       }
 catch (e) {
      console.log(e);
    }

   },handle(){
     this.close=!this.close
    }
},

  computed:{
   ...mapGetters('Student',['university_num','fullname','info']),

},created(){
  this.student=this.info
  switch(this.student.certifeca){
    case 'bac':
      this.cer="بكلوريا";
      break;
    case 'out_col':
       this.cer="مستنفذ ومنقول";
      break;
    case 'col':
       this.cer="شهادة جامعية";
      break;
    case 'inst_en':
       this.cer="معهد إنكليزي";
      break;   
  }
  switch(this.student.specialization){
    case 'fr':
      this.spe="فرنسي";
      break;
    case 'en':
      this.spe="إنكليزي";
      break;
  }
  switch(this.student.gender){
    case 'male':
      this.gen="ذكر";
      break;
     case 'female':
      this.gen="أنثى";
      break; 
  }
},updated(){
   this.student=this.info
}

}
</script>

<style>

</style>