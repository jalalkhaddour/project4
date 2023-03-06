<template >
    <div>
       <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back(false)" alt="">
    </div>
    <div>
صلاحيات الموظف &nbsp;&nbsp;</div>
  </div>
  <div class="flex  space-x-3 mx-auto py-5 px-5 ">
 <button class="bg-primary text-body text-xl rounded-lg text-center m-2 ml-56 py-2 px-2 hover:bg-hovercolor"   @click="save">حفظ التعديلات</button>
  </div>
     <!-- {{perms}} -->
   <div class="text-primary py-5 rounded-lg text-2xl  mx-16 border-2 border-hovercolor grid grid-cols-3 ">
    <div class="flex flex-col  pr-8 text-right space-y-1 border-r-2 border-hovercolor  ">
     <div class="space-x-3 ">
     <input type="checkbox" id="updatePunishmet" value="updatePunishmet" v-model="perms">
     <label for="updatePunishmet">تعديل عقوبة</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="deletePunishment" value="deletePunishment" v-model="perms">
     <label for="deletePunishment">حذف  عقوبة</label></div>

    <div class="space-x-3 ">
     <input type="checkbox" id="createPunishment" value="createPunishment" v-model="perms">
     <label for="createPunishment">  إضافة  عقوبة</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="deleteCourse" value="deleteCourse" v-model="perms">
     <label for="deleteCourse"> حذف مقرر</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="updateCourse" value="updateCourse" v-model="perms">
     <label for="updateCourse">تعديل  مقرر</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="add_course" value="add_course" v-model="perms">
     <label for="add_course">إضافة مقرر</label></div>
    </div>
   <div class="flex flex-col  pr-8 text-right space-y-1 border-r-2 border-hovercolor  ">
       <div class="space-x-3 ">
     <input type="checkbox" id="transferStudent" value="transferStudent" v-model="perms">
     <label for="transferStudent">نقل طالب</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="stopStudent" value="stopStudent" v-model="perms">
     <label for="stopStudent">ترقين قيد طالب</label></div>

    <div class="space-x-3 ">
     <input type="checkbox" id="createStudent" value="createStudent" v-model="perms">
     <label for="createStudent">تسجيل طالب جديد</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="updateStudent" value="updateStudent" v-model="perms">
     <label for="updateStudent">تعديل بيانات طالب</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="graduationStudent" value="graduationStudent" v-model="perms">
     <label for="graduationStudent">إضافة طالب خريج</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="registerStudent" value="registerStudent" v-model="perms">
     <label for="registerStudent">تسجيل طالب بالسنة</label></div>
   </div>
   <div class="flex flex-col space-y-1 pr-8 text-right" >

      <div class="space-x-3 ">
     <input  type="checkbox" id="create_user" value="create_user" v-model="perms">
     <label for="create_user" >تسجيل موظف </label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="update_user" value="update_user" v-model="perms">
     <label for="update_user">تعديل موظف</label></div>

    <div class="space-x-3 ">
     <input type="checkbox" id="delete_user" value="delete_user" v-model="perms">
     <label for="delete_user">حذف موظف</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="get_user" value="get_user" v-model="perms">
     <label for="get_user">عرض موظف</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="get_users" value="get_users" v-model="perms">
     <label for="get_users">عرض الموظفين</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="get_log_users" value="get_log_users" v-model="perms">
     <label for="get_log_users">عرض سجل الحركة</label></div>

     <div class="space-x-3 ">
     <input type="checkbox" id="give_Permission_user" value="give_Permission_user" v-model="perms">
     <label for="give_Permission_user">إعطاء صلاحيات لموظف</label></div>
   
      <div class="space-x-3 ">
     <input type="checkbox" id="UserPer" value="UserPer" v-model="perms">
     <label for="UserPer">عرض الصلاحيات لموظف</label></div>
   </div>
   </div>



       <div class="text-2xl  pl-14 text-green-800 mx-auto text-left" v-if="success"> تم التعديل بنجاح</div>
     
   </div>
    
  



        

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
    
    return { users,user,cookies,access_token,success};
  },props:['userid','userin','perms'],
  methods: {
    async  save (){
          
            try{
             const res = await axios.post('/giveper',{
              id:this.userid,
              permissions:this.perms
             },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  

             console.log(res.data)
              this.success=true
              }
        catch (e) {
             console.log(e);
           }
         
           
    }
     ,back(d){
        this.$emit("close",d)
    },    
     
   
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