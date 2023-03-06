<template lang="">
     <div v-if="editUser">
    <EditUser :userid="userid"  :userin="user" @close="close" Show="true" ></EditUser>
  </div>
  <div v-else>
    <div>
          <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
الموظفون &nbsp;&nbsp;</div>
  </div>
  
   <div class="grid grid-cols-2 pl-10 relative ">
   
  <div class=" col-start-2 col-end-3 gap-4 pt-5   mr-2">
     <input type="text" v-model="search" class=" rounded-lg search mt-4 mr-5 bg-no-repeat p-3 py-5 text-right hover:border hover:border-primary" dir="auto" >
      <label for="name" class="text-2xl text-primary pt-4">: أدخل الاسم</label></div>
       <div class="col-start-1 col-end-2  absolute top-5 left-6">
    <!-- <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-2 px-2 hover:bg-hovercolor" @click="load" >الموظفين</button> -->
</div>
      </div>
  <div class="py-4" > 
     <table class=" text-primary bg-white-100 text-2xl">
           <thead>
         
            <th>تعديل</th>
            <th>الدور</th>
            <th>النسبة</th>
            <th>الاسم</th>
            <th>اسم المستخدم</th>
        
           </thead>

          <tbody v-for="(user,id) in findUser" :key="id">
               <tr >
                  <td > 
                   <button  class="bg-primary text-body text-xl rounded-lg text-center my-1 py-2 px-4 hover:bg-hovercolor"  @click="edit(user)" >
                    تعديل
                  <!--  {{user.id}} -->
                  </button> 
                  </td>
                  <td>{{user.Role}} </td>
                   <td>{{user.lname}}</td> 
                   <td>{{user.fname}}</td>
                   <td>{{user.username}}</td>
                
               </tr>

           </tbody>   
    </table>
    </div>
  </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import EditUser from "../../components/AdministrationService/EditUser.vue";
import axios from "axios";
import { ref } from '@vue/reactivity'
import { inject} from 'vue';

export default {
  setup(){
     
    const cookies=inject('cookies');
     const access_token=cookies.get('access_token');
    const role=ref('')
    return{role,cookies,access_token}
  }
  ,data () {
    return {
      users:[] ,
      userid:0,
      editUser:false,
      user:{},
      search:'',
     
  
     
     
    }
  },
          methods:{
           async  load (){
            try{
             const res = await axios.get('/user',{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
             this.users=res.data.data
            
             console.log(this.users)
              }
        catch (e) {
             console.log(e);
           }
           
    } ,
    back(){
        this.$router.go(-1)
    }  ,
    edit(user){
      this.user=user
      this.userid=user.id
      this.editUser=true
      console.log(this.user)
        
    },close(d){
      this.editUser=d
    }
},async mounted() {
     try{
            const res = await axios.get('/user',{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
             this.users=res.data.data
            
             console.log(this.users)
              }
        catch (e) {
             console.log(e);
           }
    
  },
computed:{
     ...mapGetters('AdUser',['username','password','Authenticated','cookies','Role']),
  findUser(){
    return this.users.filter(us =>{
      return us.fname.match(this.search)
    })
  }
  
},
 components:{EditUser},
 async updated() {
     try{
            const res = await axios.get('/user',{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
             this.users=res.data.data
            
             console.log(this.users)
              }
        catch (e) {
             console.log(e);
           }
    
  },
}
</script>
<style lang="">
    
</style>