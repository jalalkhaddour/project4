<template>
       <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
 وثائق  &nbsp;&nbsp;</div>
  </div>
    <div class="flex justify-between items-center mt-4 mx-6 ">
                <div class="flerx justify-center items-center space-x-4 text-primary text-lg">
              <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor"  >طباعة</button>

    </div>
            <div class="flerx justify-center items-center space-x-4 text-primary text-lg">
              <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor" @click="SearchStudent" >عرض</button>

    </div>
    <div class="flerx justify-center items-center space-x-4 text-primary text-lg">
<select class="rounded-lg text-primary text-lg h-8 " v-model="docType">
<!--    <option value="1"> 
        حياة جامعية 
    </option>-->
    <option value="2">
        مصدقة تأجيل 
    </option>
</select>
<label>
    : الوثيقة 
</label>
    </div>
    
        <div class="flerx justify-center items-center space-x-4 text-primary text-lg">
<input type="text" class="search rounded-lg w-34" v-model="id">
<label>
    : الرقم الجامعي
</label>
    </div>
  </div>
  <div class=" border-primary border-2 mx-4 mt-6 mb-6" >
    <div class="flex justify-between m-12">
          <div class="w-32 h-36 border-2 border-primary m-6 text-primary text-lg">
    
    <label class="flex justify-center">الصورة </label>
    <label class="flex justify-center">الشخصية</label>
  </div>
   <div class="mx-4 my-6 text-primary text-lg space-y-1" >
    <div class="flex justify-end"> الجمهورية العربية السورية</div>
<div class="flex justify-end">جامعة البعث</div>
<div class="flex justify-end">كلية الآداب والعلوم الإنسانية </div>
<div class="flex justify-end"><input type="text" class="rounded-lg text-primary text-lg p-1 w-24 mx-2 "/>

: الرقم  
    </div>
<div class="flex justify-end"> <input type="text" class="rounded-lg text-primary text-lg w-24 p-1 mx-2"/>
: التاريخ
</div>

  </div>

    </div>
               <div class="flex justify-center text-primary text-6xl mb-24">
         مصدقة 
    </div>
    <div class="text-primary text-4xl m-24 space-y-4">
        
 <label class="flex justify-end"> سجل الطالب {{student1.fullname}} ابن {{student1.fathername}} </label>
  <label class="flex justify-end">   المولود في {{student1.birthplace}}</label>
   <label class="flex justify-end">بتاريخ  {{student1.birthdate}}  والمتمتع بالجنسية {{student1.nationality}} </label>
   <label class="flex justify-end">
   في السنة الأولى  قسم الترجمة – الإنكليزية  – تعليم مفتوح  من كلية الآداب 
   </label>
<label class="flex justify-end">
   في العام الدراسي  2022   بتاريخ   2022/8/17
</label>
<label class="flex justify-end">
وبرقم جامعي {{student1.university_num}}
</label>
    </div>
    <div class="flex justify-between text-primary text-2xl mt-8 mb-24 mx-12">
              
                                      
                  <label style="text-decoration:underline">   تنظيم </label>
                  <label style="text-decoration:underline">    تدقيق</label>
                  <label style="text-decoration:underline">   عميد الكلية</label>

    </div>
    <div class="flex justify-end text-primary text-2xl m-6">
        _______________________________________________________
    </div>
    <div class="flex justify-end text-primary text-lg m-6">
        تنبيه: لا يعطى الطالب سوى وثيقة واحدة خلال العام الدراسي
    </div>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.baseURL="http://localhost:8080/olearning/public/api";
import { mapGetters } from 'vuex'
import { ref } from '@vue/reactivity'
export default {
  setup(){
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
    
    return{failed,select,section,Show,id,name,status,search,ShYear,allcourses,ShowYear,sr,sure,stopreg,tran,trans,student1,suspsen}},


methods:{
    back(){
        this.$router.go(-1)
    },
   async SearchStudent(){
    this.show=true
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

      const res7 = await axios.post('/getMarksByYearStudent',{ university_num:this.university_num, specialization:this.spec,year:a},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
              console.log(res);
              this.allC=[];
            const new55=res.data.cours;
             var u=0;
             for(var v of new55){
             this.allC[u]=v;
             u+=1;
            }
     
  
       }
 catch (e) {
      console.log(e);
    }  
     
      try{
     
     const res2 = await axios.post("/getStudentSituation",{ university_num:this.university_num,
    specialization:this.spec},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}})
       console.log(res2)
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
        var failed=[];
        var v=0;
       for(var ye of allth){
         for(var sub of ye){
           this.failed[v]=sub
           v+=1}
            console.log(this.failed)} 
         } catch (e) {
      console.log(e);
    } 
       

      
    },async getby(a){
      this.year=a
    
    try{
             const res = await axios.post('/getMarksByYearStudent',{ university_num:this.university_num, specialization:this.spec,year:a},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
              console.log(res);
              this.allC=[];
            const new55=res.data.cours;
             var u=0;
             for(var v of new55){
             this.allC[u]=v;
             u+=1;
            }
              console.log(this.allC);
              }
        catch (e) {
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

}
}
</script>

<style>

</style>