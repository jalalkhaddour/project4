<template>
  <div class="backdrop3 "  >
     <div class="text-2xl text-primary flex space-y-4 rounded-lg flex-col my-40 border-3 w-96 bg-body mx-auto  border-primary"    >
       <div class=" h-9 flex items-center relative w-full bg-primary p-3 pt-4 "  >
        <lable class="mx-auto text-2xl text-body">تسجيل سنة</lable>
       <img src="../../../assets/Images/close-box.png" class=" absolute right-3  cursor-pointer" @click="handle(false)" alt="">
       </div>
       
        <!-- {{spec}}{{university_num}} -->
       <div class="justify-center flex mt-6 ">
           <input type="text" dir="auto" disabled=true v-model="year"  id="year" class="rounded-lg w-6/12 h-8 mx-2 text-right px-4" />
           <label class="">: السنة الحالية</label>

        </div>
               <div class="justify-center flex mt-6 ">
  <input type="text" dir="auto" disabled=true v-model="sem" id="sem" class="rounded-lg w-6/12 h-8 mx-2 text-right px-4" />
           <label class="">: الفصل الحالي </label>
</div>
       <div class="justify-center flex mt-8">
          <input type="text" dir="auto" disabled=true v-model="state" id="state"  class="rounded-lg w-6/12 h-8 mx-2 text-right px-4" />
             <label class="ml-7">: الوضع&nbsp;&nbsp;</label>
       </div>
        <div class="justify-center flex mt-6 text-right ">
           <!-- <input type="text" dir="auto"  v-model="newYear" id="newyear" class="rounded-lg w-6/12 h-8 mx-2 text-right px-4" /> -->
             <select   class="  rounded-lg w-6/12 h-8 mx-2 text-center px-4   " v-model="newYear" >
          <option value="first">أولى</option>
          <option value="second">ثانية</option>
          <option value="third">ثالثة</option>
          <option value="forth">رابعة</option>
              </select>
           <label class="ml-1">: السنة الجديدة</label>
       </div>
       <div class="justify-center flex mt-8 text-right" >
           <select   class="  rounded-lg w-6/12 h-8 mx-2 text-center px-4  " v-model="newSem" >
          <option value="first">أول</option>
          <option value="second">ثاني</option>
          <option value="third">ثالث</option>
     
              </select>
             <label class="">:الفصل الجديد&nbsp;&nbsp;</label>
       </div>
         <div class="text-lg   rounded-lg  mx-auto text-red-500" v-if="msg1.length>0">
     {{msg1}}
   </div> 
      <div class="text-lg   rounded-lg  mx-auto text-green-700" v-if="msg.length>0">
     {{msg}}
   </div> 
       <div class="justify-center flex my-6 ">
           <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-1 px-2 hover:bg-hovercolor w-20 h-12" @click="Regist">تسجيل</button>

   </div> 
   </div>
    
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from "axios";

export default {
    props:["spec","university_num","current_Year","current_Semster","CurrResult"],
     data() {
            return {
               year:'',
               state:'',
               sem:'',
               newYear:'',
               newSem:'',
               data:'1' ,
               msg:'',
               msg1:''
            }
        },
        methods:{
            handle(d){
            this.$emit("close",d)
        },
        detYear(){
            if(this.current_Year=="first"){this.year="الأولى"}
        },
        async Regist(){
            console.log(this.university_num)
            console.log(this.spec)
 
      try{
//   console.log(this.university_num)
      const res2 = await axios.post("/registeryear",{ university_num:this.university_num,specialization:this.spec,year:this.newYear,semester:this.newSem})
     console.log(res2)
     
     this.msg1='' 
    this.msg=res2.data.message
    console.log(this.msg)
       }
 catch (e) {
      console.log(e);
      this.msg='' 
       this.msg1=e.response.data.message
    }  


        }
        },computed:{
      ...mapGetters('Student',['university_num','fullname','info']),
   ... mapGetters(["spec"]),

},async mounted(){
                  
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
    switch(res2.data.current_Semster){
        case 'first':this.sem='أول'
        break;
        case 'second':this.sem='ثاني'
        break;
        case 'third':this.sem='ثالث'
        break;
    }

      this.state=res2.data.lastResult
      
      console.log(this.state)
 
       }
 catch (e) {
      console.log(e);
    }  
}
    
    
    
    }
</script>

<style>


</style>