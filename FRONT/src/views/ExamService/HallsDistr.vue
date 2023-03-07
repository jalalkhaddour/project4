<template>
  <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"
    style="text-align:center">
    <div>
      <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
      توزيع القاعات &nbsp;&nbsp;</div>
  </div>

  <div class="grid grid-cols-4  ">
    <div class=" flex flex-col items-center justify-center">
      <div class="flex items-center ">
        <select
          class="  rounded-lg search   bg-no-repeat p-1 m-2    w-32    text-right hover:border hover:border-primary "
          v-model="studysemester">
          <option value="1">أول</option>
          <option value="2">ثاني</option>
          <option value="3">تكميلي</option>

        </select>
        <label class="text-lg text-primary p-3 m-3">
          : الفصل
        </label>
      </div>
    </div>

    <div class=" flex flex-col items-center  space-y-1 pt-4">
      <div class="flex items-center">
        <input type="date"
          class="  rounded-lg search   bg-no-repeat p-3     w-32    text-right hover:border hover:border-primary "
          dir="auto" />
        <label class="text-lg text-primary p-3 ">
          : التاريخ
        </label>
      </div>
      <div class="flex items-center">
        <input type="time"
          class="  rounded-lg search   bg-no-repeat p-3     w-32    text-right hover:border hover:border-primary "
          dir="auto" />
        <label class="text-lg text-primary p-3 ">
          : الوقت
        </label>
      </div>
    </div>
    <div class=" flex flex-col items-center  space-y-0">
      <div class="flex items-center">
        <select class="  rounded-lg search   bg-no-repeat p-1    w-32    text-right hover:border hover:border-primary ">
          <option value="first">أولى</option>
          <option value="second">ثانية</option>
          <option value="third">ثالثة</option>
          <option value="fourth">رابعة</option>
        </select>
        <label class="text-lg text-primary p-6 mr-2">
          : السنة
        </label>
      </div>
      <div class="flex items-center">
        <select class="  rounded-lg search   bg-no-repeat p-1     w-32    text-right hover:border hover:border-primary ">
          <option value="first">أولى</option>

        </select>
        <label class="text-lg text-primary p-1 ">
          : العام الدراسي
        </label>
      </div>
    </div>
    <div class=" flex flex-col items-center  space-y-1 pt-4">
      <div class="flex items-center">
        <select v-model="code"
          class="  rounded-lg search   bg-no-repeat p-1     w-32    text-right hover:border hover:border-primary ">
          <option v-for="course in cources" :key="course.id" :value="course">{{ course.course_code }}</option>
        </select>
        <label class="text-lg text-primary p-3 ">
          : المقرر
        </label>
      </div>

      <div class="flex items-center">
        <select v-model="cla"
          class="  rounded-lg search   bg-no-repeat p-1     w-32    text-right hover:border hover:border-primary ">
          <option v-for="cl in classes" :key="cl.class_id" :value="cl">{{ cl.class_num }}</option>
        </select>
        <label class="text-lg text-primary p-3 ">
          : القاعة
        </label>
      </div>
    </div>
    <div class="  flex  justify-center ">
      <div class="justify-center flex space-x-5 ">
        <router-link to="distr">
          <button class="bg-primary text-body text-lg rounded-lg text-center   px-5 hover:bg-hovercolor">إدارة
            القاعات</button></router-link>
        <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor">عرض</button>
        <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor"
          @click="dtoggle(cla)">تعبئة</button>
      </div>
    </div>
  </div>
  <div class=" mt-1 ">
    <Halls></Halls>
  </div>
  <div v-if="sec">
    <StudentDis @close="dtoggle()" :cla="cla" :studysemester="studysemester" :studyYear="studyYear" :code="code">
    </StudentDis>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import Halls from '../../components/ExamService/Halls.vue'
import StudentDis from '../../components/ExamService/StudentDis.vue'
export default {
  components: { StudentDis, Halls },
  data() {
    return {
      classes: [{ class_id: 0, class_num: '', capacity: 0, ready: 0, location: '' }],
      cources: [],
      code: 0,
      sec: false,
      cla: {}
    }
  }
  , methods: {
    back() {
      this.$router.go(-1)
    },
    dtoggle(cla) {
      this.sec = !this.sec
      this.cla = cla
    }
  },
  async mounted() {
    try {
      const res = await axios.post('/showAllClasses', { specialization: this.spec },
        { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

      const classes1 = res.data.classes
      for (var cl in classes1) {
        this.classes[cl] = classes1[cl]
      }


      console.log(this.classes)
    }
    catch (e) {
      console.log(e);
    }
    try {
      const res = await axios.post('/showAllCourses', { specialization: this.spec },
        { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

      this.cources = res.data.data
      //  console.log(this.cources)
    }
    catch (e) {
      console.log(e);
    }
  }, computed: {

    ...mapGetters(["spec"]),

  },
}

</script>

<style></style>