<template>
<div>
  <div class="space-x-9 w-full text-4xl mb-0 font-light  text-white  relative  h-12 bg-primary flex justify-between items-center">
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  cursor-pointer absolute left-2" @click="back" alt="">   
  </div>
  <div class="grid grid-cols-2 pl-10 relative ">
    
  <div class="grid grid-rows-2 col-start-2 col-end-3 gap-4 pt-5">
  
  <div class="row-start-1 flex justify-between items-center gap-5 ">
  <form action="" @submit.prevent="SearchStudent()" class="text-primary flex justify-between font-medium text-2xl space-x-6 absolute right-4">
    <div>
     <button class="bg-primary text-body text-xl rounded-lg text-center m-5 py-1 px-2 hover:bg-hovercolor"  @click="SearchStudent()">بحث</button>
  <input type="text" v-model="id" class=" rounded-lg search  bg-no-repeat p-3 text-right hover:border hover:border-primary" dir="auto" >

  </div>
    <div class="pt-6">
  <label for="id">: أدخل الرقم </label></div>
  </form></div>
  <div class="row-start-2 flex justify-between space-x-1 items-center">
  <input type="text" name="state" id="" class="text-center p-2 w-72 bg-white rounded-lg text-red-700 text-3xl " disabled="true" v-model="status">
 <lable class="text-2xl text-primary flex justify-end px-1">{{name}}</lable>
  <label class="text-2xl text-primary flex justify-end mr-9 px-14 ">: الاسم </label>
  </div>
  </div>
   <div class="col-start-1 col-end-2 grid-cols-2 absolute top-5 left-6">
    <div  class="col-start-1 col-end-2 grid-cols-2" >
     <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-2 px-2 hover:bg-hovercolor" v-if="status=='منقطع'" @click="select('form',true)">إعادة تسجيل</button>
    <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-2 px-4 hover:bg-hovercolor" @click="ShowYear(true)">تسجيل سنة</button>
    <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-2 px-2 hover:bg-hovercolor" @click="Show=true" v-if="section=='form'">تعديل طالب</button>
    <button class="bg-primary text-body lg:text-xl sm:text-sm rounded-lg text-center m-2  py-2 px-2 hover:bg-hovercolor "  v-if=" status!='منقطع'"  @click="stopreg=true">إيقاف تسجيل</button>
    <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-2 px-4 hover:bg-hovercolor" @click="trans()">نقل طالب</button>

    </div>
   
    <div>
  </div>


</div>
  </div>
   
  <div class=" border-2 border-hovercolor  p-5 py-1  m-2   rounded-lg flex flex-col ">
   <div class="bg-primary rounded-lg text-body text-2xl px-9 py-1  text-left m-5 mt-1 flex justify-between items-center">
   <p class="cursor-pointer hover:bg-hovercolor rounded-lg py-1 p-2" @click="select('equsubjects')" :class="{'ho':section== 'equsubjects'}">مواد  متكافئة</p>
<p class="cursor-pointer hover:bg-hovercolor rounded-lg py-1 p-2" @click="suspSelect('interruption')" :class="{'ho':section== 'interruption'}">إيقاف التسجيل</p>
   <p class="cursor-pointer hover:bg-hovercolor rounded-lg py-1 p-2" @click="select('punishment')" :class="{'ho':section== 'punishment'}">عقوبات</p>
  
   <p class="cursor-pointer hover:bg-hovercolor rounded-lg py-1 p-2" @click="select('subject')" :class="{'ho':section== 'subject'}">مواد</p>
   <p class="cursor-pointer hover:bg-hovercolor rounded-lg py-1 p-2" @click="select('form',false)" :class="{'ho':section== 'form'}">معلومات</p>
   </div>
  <div @sr="sr">
  <Form  v-if="section=='form'" :Show="Show" :student1="student1" :year="year"/>
  <Subject v-if="section=='subject'" @sr="sr"/>
 
  <Punishment v-if="section=='punishment'"/>
  <Interruption v-if="section=='interruption'" :suspsen="suspsen" />
  <EquSubjects  v-if="section=='equsubjects'" :sec="spec" :cert="student1.certifeca"/>

  

  </div>
  
  </div>
    <div  v-if="ShYear" >
    <yearRe @close="ShowYear" :university_num="student1.university_num" :spec="student1.specialization"  />
    </div>
    <transport v-if="tran" @close="trans"></transport>
     <SubjectReg v-if="sure" @close="sure=false" :courses="failed"></SubjectReg> 
      <Suspenension v-if="stopreg" @close="stopreg=false"></Suspenension> 
</div>

</template>

<script>
import axios from "axios";

import { mapGetters } from 'vuex'
import { ref } from '@vue/reactivity'
import Form from '../../components/AffairsService/Student/Form.vue'
import Subject from '../../components/AffairsService/Student/Subject.vue'
import SubjectReg from "../../components/AffairsService/Student/SubjectReg.vue";
import Punishment from '../../components/AffairsService/Student/Punishment.vue'
import Interruption from '../../components/AffairsService/Student/Interruption.vue'
import yearRe from '../../components/AffairsService/Student/yearRe.vue'
import Suspenension from '../../components/AffairsService/Student/Suspension.vue'
import transport from '../../components/AffairsService/Student/transport.vue'
import EquSubjects from '../../components/AffairsService/Student/EquSubjects.vue'


export default {

  name:'StudentVue',

  components:{Form,Subject,Punishment,Interruption,yearRe,Suspenension,transport,EquSubjects,SubjectReg},
  setup(){
    const year=ref('')
    const section=ref('') 
    const select=(s,d)=>{section.value=s;Show.value=d}
    const allcourses=ref([{}]);
     const name =ref('')
     const id=ref('')
     const Show=ref(false)
     const stopreg=ref(false)
     const search=ref('')
     const status=ref('')
     const failed=ref([])
     const ShYear=ref(false)
     const ShowYear=(s)=>{ShYear.value =s}
     const sure=ref(false)
     const sr=()=>{sure.value=true}
     const tran=ref(false)
     const trans=()=>{tran.value=!tran.value}
       const student1=ref({
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
    const suspsen=ref([])
    
    return{failed,select,section,Show,id,name,year,status,search,ShYear,allcourses,ShowYear,sr,sure,stopreg,tran,trans,student1,suspsen}},


methods:{
    back(){
        this.$router.go(-1)
    },
   async SearchStudent(){
    
       try{
       this.$store.commit('Student/SetID',this.id)
     console.log(this.university_num)
    const res = await axios.post("/searchForStudent",{ university_num:this.university_num,
    specialization:this.spec},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}})
     console.log(res)
     this.student1=res.data.data
     this.$store.commit('Student/SetInfo',this.student1)
     console.log(this.info)
     this.name=this.student1.fullname
     this.$store.commit('Student/SetName',this.name)

     
     
  
       }
 catch (e) {
      console.log(e);
    }  
     
      try{
     
     const res2 = await axios.post("/getStudentSituation",{ university_num:this.university_num,
    specialization:this.spec},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}})
       console.log(res2)
       switch(res2.data.current_Year){
        case 'first': this.year='أولى'
        break;
        case 'second':this.year='ثانية' 
        break;
        case 'third':this.year='ثالثة'
        break;
        case 'forth':this.year='رابعة'
        break;
     }
      this.status=res2.data.lastResult
      console.log(this.status)
    
       }
 catch (e) {
      console.log(e);
    } 
    try{   const res2 = await axios.post("/getAvailableStudCourses",{ university_num:this.university_num,
    specialization:this.spec},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}})
       const allth =res2.data;
        console.log(allth)
        this.failed=[];
        var v=0;
       for(var ye of allth){
         for(var sub of ye){
           this.failed[v]=sub
           v+=1}
            console.log({cler:this.failed})} 
         } catch (e) {
      console.log(e);
    } 
       

      
    },suspSelect(s){
      this.select(s)
      this.loadsusp()
    },
    async loadsusp(){
     try{
      const res = await axios.post("/getsuspension"+{ university_num:this.university_num,
      specialization:this.spec})
       console.log(res.data)
       this.suspsen=res.data
       }
 catch (e) {
      console.log(e);
    }  
     
    }
    

},computed:{
   ...mapGetters('Student',['university_num','fullname','info']),
   ... mapGetters(["spec"]),

},async updated() {
   
  try{
     
     const res2 = await axios.post("/getStudentSituation",{ university_num:this.university_num,
    specialization:this.spec},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}})
       console.log(res2)
       switch(res2.data.current_Year){
        case 'first': this.year='أولى'
        break;
        case 'second':this.year='ثانية' 
        break;
        case 'third':this.year='ثالثة'
        break;
        case 'forth':this.year='رابعة'
        break;
     }
      this.status=res2.data.lastResult
      console.log(this.status)
    
       }
 catch (e) {
      console.log(e);
    } 
},
}
</script>

<style>
.search{
  
    height: 35px;
    

 
}
.ho{
  background-color:#A9A4A4 ;
  border: #A9A4A4 solid;
  border-radius:8px ;
  color:#626262;
  padding: 3px;
  margin: 0px;
  border:3px;
}
</style>