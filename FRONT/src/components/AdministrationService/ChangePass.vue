<template>
   <div class="backdrop "  >
     <div class="text-2xl text-primary flex space-y-2 rounded-lg flex-col my-56 border-3 w-96 bg-body mx-auto  border-primary"    >
       <div class=" h-9 flex items-center relative w-full bg-primary p-3 pt-4 "  >
       <img src="../../assets/Images/close-box.png" class=" absolute right-3  cursor-pointer" @click="handle(false)" alt="">
       </div>
       <div class="text-lg text-right  text-red-700 mx-auto pr-48 ">{{error.oldpass}}</div>
       <div class="justify-center flex my-6 ">
        <input type="password" dir="auto" v-model="opass" id="opass" class="rounded-lg  h-8  w-6/12 mx-2  text-right px-4 ">
       <label for="opass" class=" text-xl mx-5 text-primary ">:  كلمة السر القديمة&nbsp;&nbsp;</label>
       
       </div>
       <div class="text-lg text-right  text-red-700 mx-auto pr-4 ">{{error.newpass}}</div>

        <div class="justify-center flex my-6 ">
        <input type="password" dir="auto" v-model="npass" id="npass" class="rounded-lg  h-8  w-6/12 mx-2  text-right px-4 ">
       <label for="npass" class=" text-xl mx-5 text-primary">:كلمة السر الجديدة&nbsp;&nbsp;</label>
       
       </div>
       <div class="text-2xl text-right mx-auto text-green-800 " v-if="success"> تم تغيير كلمة السر بنجاح</div>
       
       <div class="justify-center flex my-6 ">
           <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-1 px-2 hover:bg-hovercolor w-20 h-12" @click="change" >تغيير</button>


</div>
   </div>
    
    </div></template>
      
   
    
    <script>
    // import { mapGetters } from 'vuex'
    import axios from "axios";
    
    export default {
        
        data() {
            return {
            opass:'',
            npass:'',
            id7:'',
            success:'',
            error:{oldpass:'',newpass:''}
        }
        },
        methods:{

            handle(d){
            this.$emit("close",d)
        },
        async change(){
          this.error={}
            try{
            const res1 = await axios.get('/who',{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
                this.id7=res1.data.id
                console.log(this.id7)
             const res = await axios.post('/changePass',{
              id:this.id7,
              oldPass:this.opass,
              newPass:this.npass,
              from:'personal'
             },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  

             console.log(res.data)
             this.success=true
              }
        catch (e) {
             console.log(e);
             const error=e.response.data.errors
             this.error.oldpass=error.oldpass
             this.error.newpass=error.newpass
             
           }
        },
    },computed:{
   
      

}
    
    }
    </script>
    
    <style>
    .backdrop {
    top: 0;
    position: fixed;
    margin: 0;
    background: rgba(177, 171, 171, 0.2);
    height: 100%;
    width: 100%;
}
    </style>