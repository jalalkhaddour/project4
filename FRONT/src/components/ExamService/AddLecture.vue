<template>
  <div class="backdrop3">
    <div
      class="   text-2xl text-primary   flex   space-y-4   rounded-lg   flex-col p-0  my-24   border-3 border-primary  w-1/3   mx-auto     bg-body "  >
      <div
        class=" h-9 flex items-center relative w-full p-3 pt-2 bg-primary  " >
        <lable class="mx-auto text-2xl text-body" v-if="proc=='add'"> إضافة مقرر </lable>
        <lable class="mx-auto text-2xl text-body" v-if="proc=='edit'"> تعديل مقرر </lable>
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
                <input  type="text" id="name"  dir="auto" v-model="name"  name=""  class="rounded-lg  mx-3 my-1 w-48 text-right  px-2"/>
                <label for="name"> :اسم المقرر</label>
              </div>
              <div>
                <input  type="text"  dir="auto" id="course_code" v-model="course_code" name=""  class="rounded-lg  mx-3 my-1 w-48  text-right  "/>
                <label for="course_code"> : كود المقرر</label>
              </div>
              <div>
           <select   class="  rounded-lg w-48 h-8 mx-3 text-center px-4  my-1 " v-model="year_of_course" >
          <option value="first">أولى</option>
          <option value="second">ثانية</option>
          <option value="third">ثالثة</option>
          <option value="forth">رابعة</option>
              </select>
                <label for="year_of_course"> : السنة </label>
              </div>
              <div>
           <select   class="  rounded-lg h-8 mx-3 text-center px-4 w-48 my-1 " v-model="semester" >
          <option value="first">أول</option>
          <option value="second">ثاني</option>
         
     
              </select> 
                <label for="semestereter"> : الفصل </label>
              </div>
              
             
                 <div class="text-lg   rounded-lg  mx-28 text-green-800" v-if="msg.length!=''">
                  {{msg}}
                </div>  
                <div class="text-lg   rounded-lg  mx-28 text-red-500" v-if="msg1.length!=''">
                  {{msg1}}
                </div> 
            </form>
          </div>
          
        </div><div class="mx-auto">
            <button class="bg-primary text-body text-xl rounded-lg text-center m-4 py-1 px-2  hover:bg-hovercolor w-28  h-12" @click="add" v-if="proc=='add'"> إضافة </button>
            <button class="bg-primary text-body text-xl rounded-lg text-center m-4 py-1 px-2  hover:bg-hovercolor w-28  h-12" @click="edit" v-if="proc=='edit'"> تعديل </button>
</div>
      </div>
    </div>
  </div>
</template>
      
   
    
    <script>
import { mapGetters } from 'vuex'   

import axios from "axios";

export default {

  data() {
    return {
     name:'',
     course_code:'',
     year_of_course:'',
     semester:'',
     msg:'',
     msg1:''
    };
  },props:['data','proc'],
  methods: {
    handle(d) {
      this.$emit("close", d);
    },async add(){
      try{
             const res = await axios.post('/add_course',
             {course_code:this.course_code,name:this.name,semester:this.semester,year_of_course:this.year_of_course,specialization:this.spec}
             ,{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});
             this.msg=res.data.message
             console.log(res)
             this.msg1=''
              }
        catch (e) {
             console.log(e);
             this.msg1=e.response.data.message
             this.msg=''
           }
           
    },async edit(){
      try{
             const res = await axios.post('/updateCourse',
             {course_code:this.course_code,name:this.name,semester:this.semester,year_of_course:this.year_of_course,specialization:this.spec}
             ,{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});
             this.msg=res.data.message
             console.log(res)
             this.msg1=''
              }
        catch (e) {
             console.log(e);
             this.msg1=e.response.data.message
             this.msg=''
           }
           
    }
   
  },computed:{
   
      ...mapGetters(["spec"]),

},
 mounted(){
    console.log(this.data)
    if(this.proc=='edit'){
    this.name=this.data.name
     this.course_code=this.data.course_code
     this.year_of_course=this.data.year_of_course
     this.semester=this.data.semester}
    console.log(this.proc)
}
};
</script>
    
    <style>
</style>