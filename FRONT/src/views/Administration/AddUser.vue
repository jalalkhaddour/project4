<template >
    <div>
       <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>تسجيل موظف</div>&nbsp;&nbsp;</div>
  </div>
  
  <div class="text-2xl text-right  text-primary relative  my-20 py-12 border-2 border-hovercolor   rounded-lg  pr-5  mx-72">
     <div class="flex flex-col  pl-52">
     <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.username}}</div>
  <div class="flex space-x-2 items-center">
  <input type="text" id="name1" dir="auto" class=" rounded-lg mt-1 m-3 text-right  p-1 "  :class="{rr:errors.username}" name="username" v-model="user.username"  >
    <label for="name1" class="text-2xl" >:اسم المستخدم</label>
     </div>
      <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.password}}</div>  
    <div class="flex space-x-2 items-center">
    <input type="text" id="password"  dir="auto"  class=" rounded-lg mt-1  m-3 text-right p-1 " :class="{rr:errors.password}" name="password" v-model="user.password" >
    <label for="password">:كلمة السر</label></div>
     <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.fname}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text" id="fname" dir="auto" name="fname"  v-model="user.fname" :class="{rr:errors.fname}" class=" mt-1 rounded-lg  m-3 text-right p-1" >
    <label for="fname">:الاسم الأول</label></div>
     <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.lname}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text" id="lname"  dir="auto" name="lname"  v-model="user.lname" :class="{rr:errors.lname}" class=" rounded-lg  mt-1 m-3 text-right p-1" >
    <label for="lname">:الكنية</label></div>
     <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.Role}}</div>
     <div class="flex space-x-2 items-center ml-28">
    <select name="role" id="role" v-model="user.Role"  :class="{rr:errors.Role}"  class="h-10 mt-1 cursor-pointer rounded-lg  m-3 " >
        <option value="Admin">رئيس دائرة</option>
        <option value="AfAdmin">رئيس قسم الشؤون</option>
        <option value="ExAdmin">رئيس قسم الإمتحانات</option>
        <option value="Af">موظف شؤون</option>
        <option value="Ex">موظف إمتحانات</option>
        </select>
       
    <label for="role">:الدور</label></div>
   <div class="text-2xl text-right  text-green-800 mx-auto pr-48" v-if="success"> تم التسجيل بنجاح</div>
   <br>
        <button class="bg-primary text-body text-xl rounded-lg text-center absolute left-4 bottom-3 m-2 m py-2 px-2 hover:bg-hovercolor"  @click="register">تسجيل</button>

   </div>

  


    </div>

</template>
<script>
import { mapGetters } from 'vuex'
import { ref } from "@vue/reactivity";
import axios from "axios";

//axios.defaults.withCredentials=true;
export default {
    setup() {
   
    const user=ref({username: '',password:'',fname:'',lname:'',Role:''})
     const success=ref('')
    const errors=ref({username: '',password:'',fname:'',lname:'',Role:''})
    return { user,errors,success};
  },
  methods: {
    back(){
         this.$router.go(-1)
    },
     async  register (){
   try{
      const res = await axios.post('/addus',{username:this.user.username,password:this.user.password,lname:this.user.lname,fname:this.user.fname,Role:this.user.Role,IsActive:1},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
      console.log(res.data)
      this.errors={}
      this.success=true
       }
 catch (e) {
      console.log(e);
      const error=e.response.data.errors
      if(error.username!=null)
      this.errors.username=error.username.toString()
      if(error.password!=null)
      this.errors.password=error.password.toString()
      if(error.fname!=null)
      this.errors.fname=error.fname.toString()
      if(error.lname!=null)
      this.errors.lname=error.lname.toString()
      if(error.Role!=null)
      this.errors.Role=error.Role.toString()
    }
    },    
        
    
  },computed:{
     ...mapGetters('AdUser',['username','password']),
 
  }
}
</script>
<style >
   .rr{
    border: 1px solid red;
   } 
   
</style>