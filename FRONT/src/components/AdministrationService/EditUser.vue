<template >
    <div>
       <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back(false)" alt="">
    </div>
    <div>
الموظفون &nbsp;&nbsp;</div>
  </div>
  <div class="flex  space-x-3 mx-auto py-5 px-5 ">
    <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-2 px-2 hover:bg-hovercolor" @click="deleteUser" >حذف موظف</button>
    <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-2 px-4 hover:bg-hovercolor" v-if="Role=='Admin' &&  Show==false" @click="changePassword" >تغيير كلمة السر</button>
    <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-2 px-2 hover:bg-hovercolor" @click="Show=false" >تعديل  موظف</button>

  </div>
  <div class="text-2xl text-right  text-primary  my-2 py-12 border-2 border-hovercolor   rounded-lg  pr-5  mx-72">
     <div class="flex flex-col  pl-52">
     <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.username}}</div>
  <div class="flex space-x-2 items-center">
  <input type="text" id="name1" dir="auto" class=" rounded-lg mt-1 m-3 text-right  p-1 " :disabled="Show" :class="{rr:errors.username}" name="username" v-model="user.username"  >
    <label for="name1" class="text-2xl" >:اسم المستخدم</label>
     </div>
        <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.password}}</div>  
    <div class="flex space-x-2 items-center" v-if="Role=='Admin' &&  Show==false">
    <input type="text" id="password"  dir="auto" :disabled="Show"  class=" rounded-lg mt-1  m-3 text-right p-1 " :class="{rr:errors.password}" name="password" v-model="user.password" >
    <label for="password">:كلمة السر</label></div>
     <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.fname}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text" id="fname" dir="auto" name="fname" :disabled="Show" v-model="user.fname" :class="{rr:errors.fname}" class=" mt-1 rounded-lg  m-3 text-right p-1" >
    <label for="fname">:الاسم الأول</label></div>
     <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.lname}}</div>
    <div class="flex space-x-2 items-center">
    <input type="text" id="lname"  dir="auto" name="lname" :disabled="Show" v-model="user.lname" :class="{rr:errors.lname}" class=" rounded-lg  mt-1 m-3 text-right p-1" >
    <label for="lname">:الكنية</label></div>
     <div class="text-sm text-right  text-red-700 mx-auto pr-48 ">{{errors.Role}}</div>
     <div class="flex space-x-2 items-center ml-28">
    <select name="role" id="role" v-model="user.RoleName" :disabled="Show" :class="{rr:errors.RoleName}"  class="h-10 mt-1 cursor-pointer rounded-lg  m-3 " >
        <option value="Admin">رئيس دائرة</option>
        <option value="AfAdmin">رئيس قسم الشؤون</option>
        <option value="ExAdmin">رئيس قسم الإمتحانات</option>
        <option value="Af">موظف شؤون</option>
        <option value="Ex">موظف إمتحانات</option>
        </select>
       
    <label for="role">:الدور</label></div>
       <div class="text-2xl text-right  text-green-800 mx-auto pr-48" v-if="success"> تم التعديل بنجاح</div>
       <div class="text-2xl text-right  text-green-800 mx-auto pr-48" v-if="success2"> تم تغيير كلمة السر بنجاح</div>
       <div class="text-2xl text-right  text-green-800 mx-auto pr-48" v-if="success3"> تم الحذف بنجاح</div>

   </div>
    
  


    </div></div>
        <button class="bg-primary text-body text-xl rounded-lg text-center m-2 ml-72 py-2 px-2 hover:bg-hovercolor" v-if="Show==false"  @click="save">حفظ التعديلات</button>

</template>
<script>
import { mapGetters } from 'vuex'
import { ref } from "@vue/reactivity";
import axios from "axios";
import { inject} from 'vue';

//axios.defaults.withCredentials=true;
export default {
    setup() {
     
    const cookies=inject('cookies');
    const access_token=cookies.get('access_token');
    const users = ref([]);
    const user=ref({username: '',password:'',fname:'',lname:'',RoleName:''})
    const success=ref('')
    const success2=ref('')
    const success3=ref('')
  const errors=ref({username: '',password:'',fname:'',lname:'',RoleName:''})
    return { users,user,cookies,access_token,errors,success,success2,success3};
  },props:['userid','userin','Show'],
  methods: {
    async  save (){
          
            try{
             const res = await axios.post('/upuser',{
              id:this.userid,
              username:this.user.username,
              fname:this.user.fname,
              lname:this.user.lname,
              Role:this.user.RoleName
             },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  

             console.log(res.data)
              this.success=true
              }
        catch (e) {
             console.log(e);
           }
         
           
    },async changePassword(){
        try{
             const res2 = await axios.post('/changePass',{id:this.userid,newPass:this.user.password},
             {headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
          
             console.log(res2)
             this.success2=true
              }
        catch (e) {
             console.log(e);
           }
    }
     ,back(d){
        this.$emit("close",d)
    },    
     
    async deleteUser(){
        try{
             const res = await axios.post('/deleteU',{id:this.userid },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
             this.success3=true
             console.log(res)
              }
        catch (e) {
             console.log(e);
           }


    }
  },computed:{
  
       ...mapGetters('AdUser',['username','password','Authenticated','cookies','Role']),
 
  },created(){
    console.log(this.userid)
  },mounted(){
    this.user=this.userin
  }
    
}
</script>
<style >
   .rr{
    border: 1px solid red;
   } 
   
</style>