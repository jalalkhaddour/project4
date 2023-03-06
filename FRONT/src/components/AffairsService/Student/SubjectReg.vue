<template>
    <div class="backdrop3 "  >
     <div class="text-2xl text-primary flex space-y-4 rounded-lg flex-col my-52   border-2 w-9/12 bg-body   mx-auto h-80  border-primary" >
       <div class=" h-10 flex items-center relative w-full p-3 pt-3 bg-primary  "  >
         <lable class="mx-auto text-2xl text-body">تسجيل مواد</lable>
       <img src="../../../assets/Images/close-box.png" class=" absolute right-3 cursor-pointer" @click="handle(false)" alt="">
       
       </div>
     
       <div class="overflow-auto">

    
                     <table >
   
         
 <thead>
     <th class="bg-primary text-white text-lg" style="width:15%">تسجيل</th>
     <th class="bg-primary text-white text-lg" style="width:15%"> متكافئة</th>
     <th class="bg-primary text-white text-lg" style="width:15%"> عدد مرات الرسوب </th>
     <th class="bg-primary text-white text-lg" style="width:15%">الفصل</th>
     <th class="bg-primary text-white text-lg" style="width:15%">السنة</th>
     <th class="bg-primary text-white text-lg" style="width:15%">المادة</th>
     <th class="bg-primary text-white text-lg" style="width:15%">
     رمز المادة
     </th>
 </thead>
 <tbody>


<tr v-for="c in this.courses" :key="c.course_id" >
   <td> <button class="bg-primary text-body text-xl rounded-lg text-center my-1 py-2 px-4 hover:bg-hovercolor"  @click="addCourse(c.course_id,c.issimilar)"> اضافة</button>
</td>
   <td><input type="checkbox"  v-model="c.isSim"  /></td>
   <td class="text-primary">{{c.NumOfFail}}</td>
   <td>{{c.semester1}}</td>
   <td>{{c.year_of_course1}}</td>
   <td>{{c.course_name}}</td>
   <td>{{c.course_code}}</td>
  
</tr>

 </tbody>
  </table>
    <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-1 px-2 hover:bg-hovercolor w-28  h-12" @click.self="attach" > تسجيل </button>
    <button class="bg-primary text-body text-xl rounded-lg text-center m-2 ml-56 py-2 px-2 hover:bg-hovercolor"   @click="remCou()"> حذف</button>

       </div>
 
        
   </div>

    
    </div></template>
      
   
    
    <script>
import axios from "axios";

    import { mapGetters } from 'vuex'
    export default {
        data() {
            return {
              allCourses:[],
                IsSim:false,
            }
        },
        props:["courses"],
        methods:{
            handle(d){
            this.$emit("close",d)
        },
        async attach(){
          try{
          const res= await axios.post("/AttatchStudentCourses",{ university_num:this.university_num,specialization:this.spec,courses:this.allCourses},{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token')}});
             console.log(res);
             }catch(e){console.log(e)}
        },
        addCourse(c,IsSim){
         // let co1=ref({id:c,isSim:IsSim})
         let co1={id:c,IsSim:IsSim}
          this.allCourses.push(co1)
       // this.allCourses=[...this.allCourses]+co1

        }
        ,remCou(){

          this.allCourses.pop()
        }
        },
computed:{
   ...mapGetters('Student',['university_num','fullname','info']),
   ... mapGetters(["spec","dept"]),

},mounted() {
  for(var course of  this.courses){
              switch(course.semester){
                case 'first':course.semester1 ='أول'
                break;
                case 'second':course.semester1='ثاني' 
                break;
                case 'third':course.semester1='ثالث'
                break;
             
              }
              switch(course.year_of_course){
                case 'first':course.year_of_course1 ='أولى'
                break;
                case 'second':course.year_of_course1='ثانية' 
                break;
                case 'third':course.year_of_course1='ثالثة'
                break;
                case 'forth':course.year_of_course1='رابعة'
                break;
              }}
             
},
    
    }
    </script>