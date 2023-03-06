<template>
<div>
  <div class="space-x-9 w-full text-4xl mb-0 font-light  text-white  relative  h-12 bg-primary flex justify-between items-center">
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  cursor-pointer absolute left-2" @click="back" alt="">   
  </div>
  <div class="grid grid-cols-2 pl-10 mt-10 mb-5 relative ">
    
  <div class="grid  col-start-2 col-end-3 gap-4 pt-5">
  
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

  </div>
  </div>
   <div class="col-start-1 col-end-2 grid-cols-2 absolute top-1 left-20">

    <div  class="col-start-1 col-end-2 grid-cols-2" >

  <div class="row-start-2 flex justify-between space-x-1 items-center">
 <lable class="text-2xl text-primary flex justify-end px-1">{{name}}</lable>
  <label class="text-2xl text-primary flex justify-end mr-9 px-14 ">: الاسم </label>
  </div>

    </div>
   
    <div>
  </div>


</div>
  </div>
   
  <div class=" border-2 border-hovercolor  p-5 py-1  m-2   rounded-lg flex flex-col ">
   <div class="bg-primary rounded-lg text-body text-2xl px-64  py-1  text-left m-5 mt-1 flex justify-between items-center">

  <p class="cursor-pointer hover:bg-hovercolor rounded-lg  py-1 p-2" @click="select('punshiment')" :class="{'ho':section== 'punshiment'}">عقوبات</p>
   <p class="cursor-pointer hover:bg-hovercolor rounded-lg  py-1 p-2" @click="select('subject')" :class="{'ho':section== 'subject'}">مواد</p>
     <p class="cursor-pointer hover:bg-hovercolor rounded-lg  py-1 p-2" @click="select('halls')" :class="{'ho':section== 'halls'}">قاعات</p>
     
   </div>
<div class="">
  <Subject v-if="section=='subject'" @sr="sr" :failed="allcourses"/>
   <StudentHalls v-if="section=='halls'" :student1="student1"></StudentHalls>
 <Punishment v-if="section=='punshiment'" @open="open" ></Punishment>
</div>

  

  </div>
  
  </div>
   
     
      <div  v-if="addp" >
     <AddPunshiment @close="addp=false"></AddPunshiment></div>



</template>

<script>
import axios from "axios";

import { mapGetters } from 'vuex'
import { ref } from '@vue/reactivity'

import Subject from '../../components/AffairsService/Student/Subject.vue'
import StudentHalls from "../../components/ExamService/StudentHalls.vue";
import Punishment from "../../components/AffairsService/Student/Punishment.vue";
import AddPunshiment from '../../components/ExamService/AddPunshiment.vue'


export default {
  data () {
    return {
      addp:false,
      
    }
  },

  name:'StudentVue',

  components:{Subject,StudentHalls,Punishment,AddPunshiment},
  setup(){
     const section=ref('') 
     const select=(s,d)=>{section.value=s;}
     const name =ref('')
     const id=ref('')
     const search=ref('')
     const sure=ref(false)
     const sr=()=>{sure.value=true}
     const failed=ref([{}])
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

     
   const allcourses=ref([{course_code : '',id: '',name: "",semester: "",specialization: "",year_of_course: ""}]);
    const status =ref({})
    return{select,section,id,name,search,sr,sure,student1,StudentHalls,allcourses,status,failed}},


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
    //  this.status=res2.data
     // console.log(this.status)

    



       }
 catch (e) {
      console.log(e);
    }  
    
           
 
    },open(d){
      this.addp=d
    }
    

},computed:{
   ...mapGetters('Student',['university_num','fullname','info']),
   ... mapGetters(["spec"]),

},
async mounted(){
    try{
             const res = await axios.post('/showAllCourses',{specialization:this.spec},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
            const cours=res.data.data
            console.log(res.data.data)
            const p=[];
            for (var i in cours)
              {
              p[i]=cours[i]}
                this.allcourses=p 

             console.log(this.allcourses)
             
              }
        catch (e) {
             console.log(e);
           }
}
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