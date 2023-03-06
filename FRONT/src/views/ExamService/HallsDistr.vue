<template>
 <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
توزيع القاعات &nbsp;&nbsp;</div>
  </div>
  <div class="justify-between items-center flex">
    <div class="justify-center flex space-x-8 m-2">
          <router-link to="distr">  <button class="bg-primary text-body text-lg rounded-lg text-center   px-5 hover:bg-hovercolor" >فرز</button></router-link>
    <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor" >عرض</button>
    </div>
    <div class="flex items center">
               <div class="flex items-center">
              <select   class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary " >
                <option v-for="cl in classes" :key="cl.class_id" :value="cl.class_id">{{ cl.class_num}}</option>
              </select>
           <label class="text-lg text-primary p-3 m-3">
            : القاعة
            </label>
    </div>
    <div class="flex items-center">
                      <select v-model="code" class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary ">
                        <option v-for="course in cources" :key="course.id" :value="course">{{ course.course_code }}</option>
                      </select>
           <label class="text-lg text-primary p-3 m-3">
            : المقرر
            </label>
    </div>
        <div class="flex items-center">
              <input type="date"   class="  rounded-lg search   bg-no-repeat p-3 m-2    w-32    text-right hover:border hover:border-primary " dir="auto" />
           <label class="text-lg text-primary p-3 m-3">
            : التاريخ
            </label>
    </div>
        <div class="flex items-center">
              <input type="time"   class="  rounded-lg search   bg-no-repeat p-3 m-2    w-32    text-right hover:border hover:border-primary " dir="auto" />
           <label class="text-lg text-primary p-3 m-3">
            : الوقت
            </label>
    </div>
        <div class="flex items-center">
              <select   class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary " >
                  <option value="first">أولى</option>
          <option value="second">ثانية</option>
          <option value="third">ثالثة</option>
          <option value="fourth">رابعة</option>
              </select>
           <label class="text-lg text-primary p-3 m-3">
            : السنة
            </label>
    </div>

    </div>
  </div>
  <div class=" mt-1 ">
    <Halls></Halls>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import Halls from '../../components/ExamService/Halls.vue'
export default {
    components:{Halls},
    data() {
      return {
        classes:[{class_id:0,class_num:'',capacity:0,ready:0,location:''}],
       cources:[],
       code:0,
      }
    }
,     methods:{
    back(){
        this.$router.go(-1)
    }},
    async mounted(){
    try{
             const res = await axios.post('/showAllClasses',{specialization:this.spec},
             {headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
   
             const classes1=res.data.classes
              for(var cl in classes1){
                this.classes[cl]=classes1[cl]
              }
            

             console.log(this.classes)
              }
        catch (e) {
             console.log(e);
           }
           try{
             const res = await axios.post('/showAllCourses',{specialization:this.spec},
             {headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
   
             this.cources=res.data.data
            //  console.log(this.cources)
              }
        catch (e) {
             console.log(e);
           }
   },computed:{
   
   ... mapGetters(["spec"]),

},
}
   
</script>

<style>

</style>