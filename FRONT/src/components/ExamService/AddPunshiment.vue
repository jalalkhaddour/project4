<template>
  <div class="backdrop3">
    <div
      class="   text-2xl text-primary   flex   space-y-4   rounded-lg   flex-col p-0  my-40   border-3 border-primary  w-1/3   mx-auto     bg-body "  >
      <div
        class=" h-9 flex items-center relative w-full p-3 pt-2 bg-primary  " >
        <lable class="mx-auto text-2xl text-body"> إضافة عقوبة </lable>
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
            <input  type="checkbox" id="punsh"  dir="auto" v-model="punsh"  name=""  class="rounded-lg  mx-3 my-1 w-48 text-right  px-2"/>
                <label for="punsh"> : استنفاذ</label>
              </div>
             
              <div>
            <input  type="text" id="reason"  dir="auto" v-model="reason"  name=""  class="rounded-lg  mx-3 my-1 w-48 text-right  px-2"/>
                <label for="reason"> : السبب </label>
              </div>
         
                  <div>
                <input  type="text" id="type"  dir="auto" v-model="type"  name=""  class="rounded-lg  mx-3 my-1 w-48 text-right  px-2"/>
                <label for="type"> : النوع</label>
              </div>
               <div>
           
                <input  type="number" id="semnum"  dir="auto" v-model="semnum"  name=""  class="rounded-lg  mx-3 my-1 w-48 text-right  px-2"/>
                <label for="semnum"> :عدد الفصول </label>
              </div>
             
             
                 <div class="text-lg   rounded-lg  mx-28 text-green-800" v-if="msg.length!=''">
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

export default {

  data() {
    return {
     type:'',
     punsh:false,
     semnum:'',
     reason:'',
     msg:''
    };
  },
  methods: {
    handle(d) {
      this.$emit("close",d);
    },async add(){
      try{
             const res = await axios.post('/createPunishment',
             {university_num:this.university_num,specialization:this.spec,seasons_period:this.semnum,type:this.type,reason:this.reason,IsOut:this.punsh}
             ,{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
           
             console.log(res)
             this.msg="تم إتمام العملية"
              }
        catch (e) {
             console.log(e);
           }
           
    }
   
  },computed:{
      ...mapGetters('Student',['university_num','fullname','info']),
      ...mapGetters(["spec"]),

},
 created(){
    
}
};
</script>
    
    <style>
</style>