<template>
    <div class="backdrop2"  >
        <div class="   mx-auto  my-40  grid grid-rows-5  bg-body   w-96  h-80 space-y-6" style="border-radius: 28px; ">
            <div class=" ml-0 w-11/12 text-center h-20 bg-no-repeat   bg-contain bg-left-top im">
                <p class="text-white my-2 text-2xl">تسجيل الدخول</p>
            </div>
            <div class="my-6">
                <form action="" class="space-y-6 text-right pr-9 space-x-3 ">
                    <input type="text" dir="auto" v-model="form.username" id="name" :class="{rr:errors.username}" class="rounded-lg w-6/12 h-8 mx-2 text-right px-4" />
                    <label for="name"  class="text-black text-2xl mx-2">:اسم المستخدم</label>
                    <br>
                  
                     <input type="password" dir="auto" v-model="form.password" id="pass" :class="{rr:errors.password}" class="rounded-lg  h-8  w-6/12 mx-2  text-right px-4 ">
                        <label for="pass" class="text-black text-2xl mx-5 ">:كلمة السر&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                 </form>
                   <div class="text-lg  text-right  text-red-700 mx-auto pr-36 pt-1 ">{{errors.password}}</div>
                   <div class="text-lg  text-right  text-red-700 mx-auto pr-36 pt-1 ">{{errors.username}}</div>
            </div>
            <div class="grid grid-cols-2 row-start-4 row-end-5 justify-between mx-auto space-x-10   mr-20 text-white text-center items-center px-6 pl-20">
                <!-- <button class="bg-primary rounded-lg h-10 w-16"  ><router-link :to="{name:'About'}">إلغاء</router-link></button> -->
                <button class="bg-primary rounded-lg h-10 w-16"  @click="close()" >إلغاء</button>
                <button class="bg-primary rounded-lg h-10 w-16 cursor-pointer " :disabled="!Show"  @click="handle(true)" >دخول</button>
              
            </div>
            <div class="row-start-5 row-end-6 relative  w-auto ">
               <img src="../assets/Images/Vector5.png" class="absolute right-0 bottom-0 h-20" alt="">  
            </div>
       
        </div>
       
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { ref ,reactive} from '@vue/reactivity'
import { inject, watchEffect } from 'vue';
import axios from "axios";

export default {
  data () {
    return {
        errors:{password:'',username:''}
    }
  },
    setup(){
        const role=ref('')
        const cookies=inject('cookies')
        const isAuthenticated=ref(false)
        const form=reactive({
            username:'',
            password:''
        })
     
        const access_token=ref('');
        const Show=ref(false)
        
       watchEffect(()=>{
        console.log(form.username)
       if(form.username=='' || form.password=='' ){  
             Show.value=false}
       else {Show.value=true}})
        
        


      return{form,Show,cookies,access_token,isAuthenticated,role}
    },methods:{
        checkLogin(){
        if(true)
           this.isAuthenticated=true
           this.$store.commit('AdUser/SetAuthenticated',this.isAuthenticated)
       },
      async  handle(d){
            this.$emit("success",d)
            this.$store.commit('AdUser/SetUsername',this.form.username)
            this.$store.commit('AdUser/SetPassword',this.form.password)

               try{
                    const res = await axios.post("/login",{username:this.form.username,password:this.form.password},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
                    if(res.data.access_token){
                        this.access_token=res.data.access_token
                        this.cookies.set('access_token',res.data.access_token)
                        console.log(res)
                        this.$store.commit('AdUser/SetCookies',this.cookies)
                        this.isAuthenticated=true
                        console.log(this.cookies.get('access_token'))
                     this.$store.commit('AdUser/SetAuthenticated',this.isAuthenticated)
                     this.$store.commit('setHomeAnimation',this.isAuthenticated)
                    }
                  
                // this.$emit('successLogin',true)
                   }
               catch (e) {
                    console.log(e);
                    if(e.code=='ERR_NETWORK'){     
                    }else{
                        this.errors={}
                    const error=e.response.data.errors
                    if(error.password !=null)
                    this.errors.password=error.password.toString()
                    if(error.username !=null)
                    this.errors.username=error.username.toString()
                    console.log(this.errors.username)}}   
                   try{
                   this.access_token=this.cookies.get('access_token');
                   console.log(this.access_token);
                   this.cookies.set('access_token',this.access_token)
                     const res1 = await axios.get('/who',{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
                     console.log(res1)
                     this.role=res1.data.RoleName
                      this.$store.commit('AdUser/SetRole',this.role)
                     

                      }
                catch (e) {
                     console.log(e);
                   }        
            
        },close(){
            window.close()
        }
 
    },computed:{
     ...mapGetters('AdUser',['username','password','Authenticated','Cookies','Role']),
  },
       mounted() {
        this.checkLogin
       },computed(){}
  
};
</script>

<style>
.backdrop2 {
    top: 0;
    position: fixed;
    margin: 0;
    background: rgb(0, 0, 0, 0.5);
    height: 100%;
    width: 100%;
}

.im {
    background-image: url("../assets/Images/Group.png");
   
}
button[disabled]{
cursor:not-allowed;
opacity: 0.5;
}

</style>