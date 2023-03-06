<template lang="">
      <div class=" space-x-2 space-y-3 pt-2 text-white  bg-primary text-xl" >
         <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
          <p @click="logout" style="text-align: center">تسجيل خروج</p>
           <hr class="bg-body" />
          </div> <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
          <p style="text-align: center" @click="Sh(true)">تغيير كلمة السر</p>
          </div></div>
      
</template>
<script>
import ChangePass from './AdministrationService/ChangePass.vue'

import { mapGetters } from 'vuex'
import axios from "axios";

export default {
  data () {
    return {
      sho:false,
      close:false
    }
  },
methods:{
         async  logout (){
         
       try{
        console.log(this.$cookies.get('access_token'))
      const res2=await axios.get("/logout",{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
      console.log(res2)
      if(this.$cookies.get('access_token')){
        this.$cookies.set('access_token','')
       this.$store.commit('AdUser/SetCookies',this.$cookies) 
       this.$store.commit('AdUser/SetAuthenticated',false)
    
       
      }

       this.close=false
  
      this.$router.beforeEach((to, from, next) => {
    if (this.Authenticated == false)
        return '/'
})
       this.$emit('cl',this.close)
   
        
       }
 catch (e) {
      console.log(e);
    }
    },Sh(d){
      this.$emit('sh',d)
    }
},computed:{
         ...mapGetters('AdUser',['username','password','Authenticated','cookies']),

  },components:{ChangePass}
}
</script>
<style lang="">
    
</style>