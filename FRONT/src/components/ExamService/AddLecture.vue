<template>
  <div class="backdrop3">
    <div
      class="   text-2xl text-primary   flex   space-y-4   rounded-lg   flex-col p-0  my-24   border-3 border-primary  w-1/3   mx-auto     bg-body "  >
      <div
        class=" h-9 flex items-center relative w-full p-3 pt-2 bg-primary  " >
        <lable class="mx-auto text-2xl text-body"> إضافة مقرر </lable>
        <img
          src="../../assets/Images/close-box.png"
          class="absolute right-3 cursor-pointer"
          @click="handle(false)"
          alt=""
        />
      </div>
      <div> 
          <div class="flex justify-center space-y-2">
          <div>
            <form class="space-y-2">
               <div>
                <input  type="text" id="lecname"  dir="auto" v-model="lecname"  name=""  class="rounded-lg  mx-3 my-1 w-48 text-right  px-2"/>
                <label for="lecname"> :اسم المقرر</label>
              </div>
              <div>
                <input  type="text"  dir="auto" id="lecnum" v-model="lecnum" name=""  class="rounded-lg  mx-3 my-1 w-48  text-right  "/>
                <label for="lecnum"> : كود المقرر</label>
              </div>
              <div>
           <select   class="  rounded-lg w-48 h-8 mx-3 text-center px-4  my-1 " v-model="year" >
          <option value="first">أولى</option>
          <option value="second">ثانية</option>
          <option value="third">ثالثة</option>
          <option value="forth">رابعة</option>
              </select>
                <label for="year"> : السنة </label>
              </div>
              <div>
           <select   class="  rounded-lg h-8 mx-3 text-center px-4 w-48 my-1 " v-model="sem" >
          <option value="first">أول</option>
          <option value="second">ثاني</option>
         
     
              </select> 
                <label for="semeter"> : الفصل </label>
              </div>
              
             
                 <div class="text-lg   rounded-lg  mx-28 text-red-500" v-if="msg.length!=''">
                  {{msg}}
                </div>  
            </form>
          </div>
          
        </div><div class="mx-auto">
            <button class="bg-primary text-body text-xl rounded-lg text-center m-4 py-1 px-2  hover:bg-hovercolor w-28  h-12" @click="add" > إضافة </button>
</div>
      </div>
    </div>
  </div>
</template>
      
   
    
    <script>
import { mapGetters } from 'vuex'   

import axios from "axios";
axios.defaults.baseURL="http://localhost/olearning/public/api";
export default {

  data() {
    return {
     lecname:'',
     lecnum:'',
     year:'',
     sem:'',
     msg:''
    };
  },
  methods: {
    handle(d) {
      this.$emit("close", d);
    },async add(){
      try{
        console.log({'lecnum':this.lecnum,'sem':this.sem,'year':this.year,'spec':this.spec,'lecname':this.lecname})
             const res = await axios.post('/add_course',
             {course_code:this.lecnum,name:this.lecname,semester:this.sem,year_of_course:this.year,specialization:this.spec}
             ,{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});
             this.msg=res.data.message
             console.log(res)
              }
        catch (e) {
             console.log(e);
           }
           
    }
   
  },computed:{
   
      ...mapGetters(["spec"]),

},
 created(){
    
}
};
</script>
    
    <style>
</style>