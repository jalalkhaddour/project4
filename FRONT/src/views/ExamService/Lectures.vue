<template lang="">
    <div>
       <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div> المقررات</div>&nbsp;&nbsp;</div>
  </div>
        <div class="mt-2  pt-3 border-2 border-hovercolor mx-3 rounded-xl ">
  <div class="bg-primary  rounded-lg text-body text-2xl px-9 py-1  text-center mx-12 mb-2 flex justify-between items-center ">
<button class="bg-primary hover:bg-hovercolor rounded-lg p-1" @click="year='forth'" :class="{ho:year=='fourh'}">السنة الرابعة</button> 
 <button class="bg-primary hover:bg-hovercolor rounded-lg p-1" @click="year='third'" :class="{ho:year=='third'}">السنة الثالثة</button> 
  <button class="bg-primary hover:bg-hovercolor rounded-lg p-1" @click="year='second'" :class="{ho:year=='second'}">السنة الثانية</button>
  <button class="bg-primary hover:bg-hovercolor rounded-lg p-1" @click="year='first'" :class="{ho:year=='first'}">السنة الأولى</button>
  </div>
      <div class="mx-12">
 <div class="flex justify-center space-x-24 text-white text-lg bg-primary  items-center rounded-lg" >
                   <button style="width:50%"  @click="sem='second'"  :class="{'ho':sem == 'second'}"> الفصل الثاني</button>
          <button style="width:50%"  @click="sem='first'" :class="{'ho':sem == 'first'}" >الفصل الأول</button>
          </div></div>
  <div  class="  mx-12 my-1  text-lg text-primary">
  <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-1 px-2 hover:bg-hovercolor w-28  h-12" @click="Show(true)" > إضافة مقرر</button>
  </div>    
  </div>  
   <div >
      <table>
 <thead>
     <th></th>
     <th class="bg-primary text-white text-xl" > الفصل </th>
     <th class="bg-primary text-white text-xl">السنة</th>
     <th class="bg-primary text-white text-xl">الكود</th>
     <th class="bg-primary text-white text-xl">المقرر</th>
 </thead>
<tbody v-for="course in findCourse" :key="course.id">
<tr>
   <td class=" space-x-5 " style="width:20%"> 
 <button  class="bg-primary text-body text-xl rounded-lg text-center my-1 py-2 px-4 hover:bg-hovercolor"   >
   تعديل
 </button> 
    <button  class="bg-primary text-body text-xl rounded-lg text-center my-1 py-2 px-4 hover:bg-hovercolor"  >
حذف
 </button> 
   </td>
   <td>{{course.semester}}</td>
   <td>{{course.year_of_course}}</td>
   <td>{{course.course_code}}</td>
   <td>{{course.name}}</td>
   </tr>
 </tbody>
  </table>
  </div>
  <div v-if="addLec">
  
  <AddLecture @close="Show" ></AddLecture></div>
   
</template>
<script>
import axios from "axios";
axios.defaults.baseURL="http://localhost/olearning/public/api";
import { ref } from '@vue/reactivity'
import { mapGetters } from 'vuex'
import AddLecture from '../../components/ExamService/AddLecture.vue' 
export default {
  methods: {
     back(){
        this.$router.go(-1)
    },
    Show(d){
      this.addLec=d
    }
  },
      
  setup(){
    const addLec=ref(false)
      const year=ref('first')
      const sem =ref('first')
      const courses =ref([])
       
    return{year,sem,addLec,courses}
    },

computed:{
  
   ... mapGetters(["spec","dept"]),
    findCourse(){
    return this.courses.filter(us =>{
      return us.semester.match(this.sem)&& us.year_of_course.match(this.year)
    })
  }

}, components:{AddLecture},
async mounted(){
   try{
             const res = await axios.get('/showAllCourses',{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
            this.courses=res.data.data
            
             console.log(res)
              }
        catch (e) {
             console.log(e);
           }
           
}
}
</script>
<style lang="">
    
</style>