<template>
   <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"  style="text-align:center">
      <div>
  <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
  فرز القاعات &nbsp;&nbsp;</div>
  </div>
      <div class="flex items-center justify-center">
               <div class="flex items-center">
              <select   class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary " >
                  <option value="1">أولى</option>
          <option value="2">ثانية</option>
          <option value="3">ثالثة</option>
          <option value="4">رابعة</option>
              </select>
           <label class="text-lg text-primary p-3 m-3">
            : القاعة
            </label>
    </div>
    <div class="flex items-center">
                      <select  class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary ">
                        <option>1111</option>
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
        <div class="flex items-center ">
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
    <div class="flex items-center justify-center space-x-12 text-primary text-lg">
        <div>
            <label>1000</label>
            <label> : العدد الإجمالي</label>
        </div>
                <div>
            <label>000</label>
            <label>
                 : سعة &nbsp;القاعات
            </label>
        </div>
    </div>
    <div>
   <div class="mx-12 text-xl font-medium">
       
      <table>
          <thead>   
              <th  class="text-lg">طباعة</th>
              <th class="text-lg">الحالة </th> 
              <th class="text-lg">عمليات</th>
              <th class="text-lg">السعة</th>
              <th class="text-lg">القاعة </th>
             
          </thead>
           <tbody >
          
              <tr>
          <td></td>
          <td> </td>
          <td>    <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor" @click="dtoggle()" >تعبئة</button> </td>
          <td> </td>
          <td>{{sec}} </td>
          
              </tr>
          </tbody>
      </table>
  </div>
<div  v-if="sec" >

<StudentDis @close="dtoggle()"></StudentDis>
    
</div>
    </div> 
</template>

<script>
import axios from "axios";
axios.defaults.baseURL="http://localhost/olearning/public/api";
import StudentDis from '../../components/ExamService/StudentDis.vue'
export default {
    
  data () {
    return {
       sec:false
    }
   
    },
    components:{StudentDis}
  ,
 methods:{
    back(){
        this.$router.go(-1)
    },
    dtoggle(){
        this.sec= !this.sec
    }
    }
}
</script>

<style>

</style>