<template lang="">
    
  <div >
    <div>
          <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
المنسحبون &nbsp;&nbsp;</div>
  </div>
  
   <div class="grid grid-cols-2 pl-10 relative ">
   
  <!-- <div class=" col-start-2 col-end-3 gap-4 pt-5   mr-2"> -->
     <!-- <input type="text" v-model="search" class=" rounded-lg search mt-4 mr-5 bg-no-repeat p-3 py-5 text-right hover:border hover:border-primary" dir="auto" > -->
      <!-- <label for="name" class="text-2xl text-primary pt-4">: أدخل الاسم</label></div> -->
       <!-- <div class="col-start-1 col-end-2  absolute top-5 left-6"> -->
    <!-- <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-2 px-2 hover:bg-hovercolor" @click="load" >الموظفين</button> -->
<!-- </div> -->
      </div>
  <div class="py-4" > 
     <table class=" text-primary bg-white-100 text-2xl">
           <thead>
         
            <th>السبب</th>
            <th>الاختصاص</th>
            <th>الجامعة الجديدة</th>
            <th>السنة</th>
            <th>الرقم الجامعي </th>
        
           </thead>

          <tbody v-for="s in students" :key="s">
               <tr >
                  <td >{{s.reason}}</td>
                  <td>{{spec}}</td>
                   <td>{{s.new_university}}</td> 
                   <td>{{s.stop_year}}</td>
                   <td>{{s.student_id}}</td>
                
               </tr>

           </tbody>   
    </table>
    </div>
  </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import axios from "axios";

export default {

  data () {
    return {
      students:[{}] ,
      search:'',
     
  
     
     
    }
  },
          methods:{
         
    back(){
        this.$router.go(-1)
    } 
},async mounted() {
     try{
            const res = await axios.post('/getstop',{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
           
            this.students=res.data.data
             console.log(res)
              }
        catch (e) {
             console.log(e);
           }
    
  },
computed:{
     ...mapGetters('Student',['university_num','fullname']),
      ... mapGetters(["spec"]),

  findUser(){
    return this.users.filter(us =>{
      return us.fname.match(this.search)
    })
  }
  
},

}
</script>
<style lang="">
    
</style>