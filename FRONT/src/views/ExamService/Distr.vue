<template>
   <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
  فرز القاعات &nbsp;&nbsp;</div>
  </div>
      <div class="flex items-center justify-center">
               <!-- <div class="flex items-center">
              <select   class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary " >
                  <option v-for="cl in classes" :key="cl.class_id" :value="cl.class_id">{{ cl.class_num}}</option>
              </select>
           <label class="text-lg text-primary p-3 m-3">
            : القاعة
            </label>
    </div> -->
    <div class="flex items-center">
                      <select v-model="code"  class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary ">
                        <option v-for="course in cources" :key="course.id" :value="course">{{ course.course_code }}</option>
                      </select>
           <label class="text-lg text-primary p-3 m-3">
            : المقرر
            </label>
    </div>
        <!-- <div class="flex items-center">
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
    </div> -->
        <div class="flex items-center ">
              <select   class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary " v-model="studyYear">
                    <option value="first">أولى</option>
          <option value="second">ثانية</option>
          <option value="third">ثالثة</option>
          <option value="fourth">رابعة</option>
              </select>
           <label class="text-lg text-primary p-3 m-3">
            : السنة
            </label>
    </div>
    <div class="flex items-center ">
              <select   class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary "  v-model="studysemester">
                    <option value="first">أول</option>
          <option value="second">ثاني</option>
          <option value="third">ثالث</option>
         
              </select>
           <label class="text-lg text-primary p-3 m-3">
            : الفصل
            </label>
    </div>
    </div>
    <div class="flex items-center justify-center space-x-12 text-primary text-lg">
      <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor" @click="edit('add')" >إضافة قاعة</button>
        <div>
            <label>{{ classes_count }}</label>
            <label> : العدد الإجمالي</label>
        </div>
                <div>
            <label>{{ classes_capacity }}</label>
            <label>
                 : سعة &nbsp;القاعات
            </label>
        </div>
    </div>
    <div>
   <div class="mx-12 text-xl font-medium">
       
      <table>
          <thead> 
              <th  class="text-lg"></th>  
              <th  class="text-lg">طباعة</th>
              <th class="text-lg">المحجوز </th> 
              <th class="text-lg">عمليات</th>
              <th class="text-lg">السعة</th>
              <th class="text-lg">القاعة </th>
             
          </thead>
           <tbody v-for="cl in classes" :key="cl.class_id" >
          
              <tr>
           <td class="space-x-2"> <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor" @click="edit('edit',cl)" >تعديل</button>
            <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor" @click="delete2(cl.class_id)" >حذف</button></td>     
          <td></td>
          <td> {{ cl.ready }}</td>
          <td>    <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor" @click="dtoggle(cl)" >تعبئة</button> </td>
          <td>{{ cl.capacity }} </td>
          <td>{{cl.class_num}} </td>
          
              </tr>
          </tbody>
      </table>
  </div>
<div  v-if="sec" >
<StudentDis @close="dtoggle()" :clas="clas" :studysemester="studysemester" :studyYear="studyYear" :code="code"></StudentDis>
</div>
<div v-if="editCla">
  <EditClass @close="edit()" @recive="recive" :clas="clas" :proc="proc"></EditClass>  
</div>
    </div> 
    <transition name="toast">
  <Toast v-if="shtoast" :msg="msg"></Toast>
</transition>
</template>

<script>

import axios from "axios";
import { mapGetters } from "vuex";
import StudentDis from '../../components/ExamService/StudentDis.vue'
import EditClass from "../../components/ExamService/EditClass.vue";
import Toast from "../../components/Toast.vue";
export default {
    
  data () {
    return {
       sec:false,
       editCla:false,
       classes:[{class_id:0,class_num:'',capacity:0,ready:0,location:''}],
       cources:[],
       code:0,
       classes_capacity:0,
       classes_count:0,
       clas:{},
       proc:'',
       studyYear:'',
       studysemester:'',
       msg:'',
       shtoast:false
    }
   
    },
    components:{StudentDis,EditClass,Toast}
  ,
 methods:{
    recive(cl,count,capacity){
      this.classes=cl
      this.classes_count=count
      this.classes_capacity=capacity
    },
    back(){
        this.$router.go(-1)
    },
    dtoggle(cla){
        this.sec= !this.sec
        this.clas=cla
    },
    edit(p,cla){
      this.editCla= !this.editCla
        this.clas=cla
        this.proc=p
    },async delete2(id){
       try{
               const res = await axios.post('/DeleteExamClass',
               {id:id}
               ,{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});
               
               console.log(res)
               this.msg=res.data.Message

               this.shtoast=true
             setTimeout(()=>{this.shtoast=false},3000);
                }
          catch (e) {
               console.log(e);
              
             }
             try{
             const res = await axios.post('/showAllClasses',{specialization:this.spec},
             {headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
             this.classes=[{}]
             const classes1=res.data.classes
              for(var cl in classes1){
                this.classes[cl]=classes1[cl]
              }
              this.classes_count=0
              this.classes_capacity=0
              for (var cla of this.classes){
                this.classes_count++;
                this.classes_capacity+=cla.capacity
                      }

            //  console.log(this.classes)
              }
        catch (e) {
             console.log(e);
           }
             
      }
    },
   async mounted(){
    try{
             const res = await axios.post('/showAllClasses',{specialization:this.spec},
             {headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
   
             const classes1=res.data.classes
              for(var cl in classes1){
                this.classes[cl]=classes1[cl]
              }
              for (var cla of this.classes){
                this.classes_count++;
                this.classes_capacity+=cla.capacity
                      }

            //  console.log(this.classes)
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
     
     ...mapGetters(["spec"]),

},
}
</script>

<style>

</style>