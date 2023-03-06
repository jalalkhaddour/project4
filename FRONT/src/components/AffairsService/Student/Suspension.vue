<template>
  <div class="backdrop3">
    <div
      class="   text-2xl text-primary   flex   space-y-4   rounded-lg   flex-col p-0  my-24   border-3 border-primary  w-1/3   mx-auto     bg-body "  >
      <div
        class=" h-9 flex items-center relative w-full p-3 pt-2 bg-primary  " >
        <lable class="mx-auto text-2xl text-body"> إيقاف تسجيل</lable>
        <img
          src="../../../assets/Images/close-box.png"
          class="absolute right-3 cursor-pointer"
          @click="handle(false)"
          alt=""
        />
      </div>
      <div> 
          <div class="flex justify-center">
          <div>
            <form>
               <div>
                <input  type="text" id="university_num"  dir="auto" v-model="susp.university_num"  name=""  class="rounded-lg  mx-3 my-2 w-64 text-right p-1 px-2"/>
                <label for="university_num"> :الرقم الجامعي</label>
              </div>
              
              <div>
                 <select   class="  rounded-lg w-7/12 h-9 my-2 mx-2 text-center px-4   "  id="suspension_year" v-model="susp.suspension_year" >
          <option value="first">أولى</option>
          <option value="second">ثانية</option>
          <option value="third">ثالثة</option>
          <option value="fourth">رابعة</option>
              </select>
                
                <label for="suspension_year"> : السنة </label>
              </div>
              <div>
               <select   class="  rounded-lg w-7/12 my-2 h-9 mx-2 text-center px-4   " id="suspension_semester" v-model="susp.suspension_semester" >
             <option value="first">أول</option>
             <option value="second">ثاني</option>
             <option value="third">ثالث</option>
     
              </select>
              
                <label for="suspension_semester"> : الفصل </label>
              </div>
              <div> 
                <input  type="date"  dir="auto" id="reg_receipt_date" v-model="susp.reg_receipt_date" name=""  class="rounded-lg  mx-3 my-2 w-64  text-right p1 px-21"/>
                <label class="text-lg font-semibold" for="reg_receipt_date"> :تاريخ وصل التسجيل </label>
              </div>
              <div>
                <input type="text" id="reg_receipt_num" v-model="susp.reg_receipt_num" dir="auto" name="" class="rounded-lg  mx-3 my-2 w-64 text-right p-1 px-2"/>
                <label for="reg_receipt_num"> :رقمه</label>
              </div>
                 <div class="justify-center flex mt-3">
              <input type="text" dir="auto" v-model="spe" id="specialization" disabled="true" class="rounded-lg w-6/12 h-8 ml-2 text-right px-4"  />
               <label for="specialization" class="mr-16 pl-0   ">:القسم</label></div>
               <div class="text-lg   rounded-lg ml-20  text-red-500" v-if="msg1.length>0">
                {{msg1}}
              </div> 
                 <div class="text-lg   rounded-lg ml-20 text-green-700" v-if="msg.length>0">
                {{msg}}
              </div> 
            </form>
          </div>
          
        </div><div class="mx-auto">
    
          <button class="bg-primary text-body text-xl rounded-lg text-center m-4 py-1 px-2  hover:bg-hovercolor w-28  h-12"  @click="Suspension"> إيقاف </button>
        
        </div>

      </div>
    
    </div>
  </div>
</template>
      
   
    
    <script>
import { mapGetters } from 'vuex'   
import Form from "./Form.vue";
import axios from "axios";

export default {
  // eslint-disable-next-line vue/no-unused-components
  components: { Form },
  data() {
    return {
      susp:{
      suspension_year:'',
      suspension_semester:'',
      reg_receipt_num:'',
      reg_receipt_date:'',
      university_num:'',
      specialization:''},
      msg:'',
      spe:'',
      msg1:''
    };
  },
  methods: {
    handle(d) {
      this.$emit("close", d);
    },async Suspension(){
       try{
      const res = await axios.post("/suspension",
      {
       suspension_year:this.susp.suspension_year,
      suspension_semester:this.susp.suspension_semester,
      reg_receipt_num:this.susp.reg_receipt_num,
      reg_receipt_date:this.susp.reg_receipt_date,  
      university_num:this.susp.university_num,
      specialization:this.susp.specialization,
      },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});
      
      this.msg=res.data.message
      this.msg1='' 
      console.log(res)
    
       }
 catch (e) {
      console.log(e);
      this.msg='' 
       this.msg1=e.response.data.message
    }

   },
  },computed:{
   ...mapGetters('Student',['university_num','fullname']),
      ... mapGetters(["spec"]),

},
 created(){
    
        this.susp.university_num=this.university_num
        this.susp.specialization=this.spec
         switch(this.susp.specialization){
              case 'fr':
                this.spe="فرنسي";
                break;
              case 'en':
                this.spe="إنكليزي";
                break;
            }
    
}
};
</script>
    
    <style>
</style>