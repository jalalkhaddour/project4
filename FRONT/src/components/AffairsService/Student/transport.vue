<template>
   <div class="backdrop3 "  >
     <div class="text-2xl text-primary flex space-y-4 rounded-lg flex-col my-56 border-3 w-96 bg-body mx-auto  border-primary"    >
       <div class=" h-9 flex items-center relative w-full bg-primary p-3 pt-4 "  >
        <lable class="mx-auto text-2xl text-body">نقل طالب</lable>
       <img src="../../../assets/Images/close-box.png" class=" absolute right-3  cursor-pointer" @click="handle(false)" alt="">
       </div>
        <div class="justify-center flex mt-6 ">
           <input type="text" dir="auto" v-model="trans.university_num" id="university_num" class="rounded-lg w-6/12 h-8 mx-2 text-right px-4" />
           <label class="ml-5" for="university_num">: الرقم الجامعي</label>
       </div>
       <div class="justify-center flex mt-8">
          <input type="text" dir="auto" v-model="trans.new_university" id="new_university"  class="rounded-lg w-6/12 h-8 ml-2 text-right px-4"  />
             <label class="ml-2" for="new_university">&nbsp;&nbsp;: الجامعة الجديدة</label>
       </div>
       
        <div class="justify-center flex mt-8">
     <input type="text" dir="auto" v-model="spe" id="specialization" disabled="true" class="rounded-lg w-6/12 h-8 ml-2 text-right px-4"  />
    <label for="specialization" class="mr-16 pl-3   ">:القسم</label></div>
    <div class="text-lg   rounded-lg  mx-auto text-red-500" v-if="msg1.length>0">
     {{msg1}}
   </div> 
      <div class="text-lg   rounded-lg  mx-auto text-green-700" v-if="msg.length>0">
     {{msg}}
   </div> 
       <div class="justify-center flex my-6 ">
           <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-1 px-2 hover:bg-hovercolor w-20 h-12" @click="transfer">نقل</button>

   </div> 
   </div>
    
    </div></template>
      
   
    
    <script>
    import { mapGetters } from 'vuex'
    import axios from "axios";
    
    export default {
        
        data() {
            return {
                trans:{
                    university_num:'',
                    new_university:'',
                    specialization:''
                },
                msg:'',
                msg1:'',
                spe:''
        }
        },
        methods:{

            handle(d){
            this.$emit("close",d)
        },async transfer(){
       try{
      const res = await axios.post("/transfer",
      {
      university_num:this.trans.university_num,
      new_university:this.trans.new_university,
      specialization:this.trans.specialization,
      },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});

      console.log(res.data.message)
      this.msg1=''
      this.msg=res.data.message
       }
 catch (e) {
      console.log(e.response.data.message);
      this.msg=''
      this.msg1=e.response.data.message
    }

   },
        },computed:{
   ...mapGetters('Student',['university_num','fullname']),
      ... mapGetters(["spec"]),

},created(){
    
        this.trans.university_num=this.university_num
        this.trans.specialization=this.spec
         switch(this.trans.specialization){
              case 'fr':
                this.spe="فرنسي";
                break;
              case 'en':
                this.spe="إنكليزي";
                break;
            }
    
}
    
    }
    </script>
    
    <style>
    .backdrop {
    top: 0;
    position: fixed;
    margin: 0;
    background: rgba(161, 152, 152, 0.9);
    height: 100%;
    width: 100%;
}
    </style>