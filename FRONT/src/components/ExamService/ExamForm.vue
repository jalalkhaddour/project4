<template>
  <div class="grid grid-cols-3">
    <div class="flex flex-col items-center text-right text-primary space-y-4 text-xl mt-8 ">
      <div class="items-center justify-center space-x-8">

        <label class="pl-2">{{ code }}</label>
        <label> : رقم المقرر </label>
      </div>
      <div class="items-center justify-center space-x-6">
        <label class="pl-12">1000</label>
        <label> : رقم جلسة الرصد </label>
      </div>
    </div>
    <div class="flex flex-col items-center text-right text-primary space-y-4 text-xl mt-5 ">
      <div class=" space-x-2">
        <select v-model="semester" name="semester" class="h-10 cursor-pointer rounded-lg">
          <option value="1">أول</option>
          <option value="2">ثاني</option>
          <option value="3">تكميلي</option>
        </select>
        <label> : الفصل&nbsp; </label>
      </div>
      <div class=" space-x-2">
        <select name="cyear" v-model="year_of_course" class="h-10 cursor-pointer rounded-lg">
          <option value="first">أولى</option>
          <option value="second">ثانية</option>
          <option value="third">ثالثة</option>
          <option value="forth">رابعة</option>
        </select>
        <label> : السنة </label>
      </div>

    </div>
    <div class="flex flex-col items-center text-right text-primary space-y-2 text-xl mt-5">

      <div 
        class="text-primary flex justify-between font-medium text-2xl space-x-6">
        <div class="flex items-center justify-center">
          <div class="flex justify-center items-center">
            <button
              class="   bg-primary text-body text-xl rounded-lg  text-center  m-2  py-1  px-2   hover:bg-hovercolor   " @click="search">بحث
            </button>
            <input type="text" v-model="code1"
              class="  rounded-lg   search bg-no-repeat p-3    w-32    text-right hover:border hover:border-primary "
              dir="auto" />
          </div>
          <div class="mt-0 mx-2">
            <label for="id" class="pr-10">: الرقم</label>
          </div>
        </div>
      </div>
      <div class=" space-x-2">
        <select class="h-10 cursor-pointer rounded-lg ml-0  w-72" v-model="course">
          <option v-for="course in cources" :key="course.id" :value="course">{{ course.name }}</option>
        </select>
        <label class="">: المقرر </label>
      </div>
    </div>


  </div>
  <div class="flex space-x-12 pl-16 text-primary text-xl pt-9 ">
    <button class="bg-primary text-body text-xl rounded-lg text-center  py-1 px-5 hover:bg-hovercolor"
      v-if="sec == 'session'" @click="show(true)">فتح جلسة رصد</button>
    <button class="bg-primary text-body text-xl rounded-lg text-center  py-1 px-5 hover:bg-hovercolor"
      v-if="sec == 'session'" @click="transferCheck()">ترحيل جلسة رصد</button>
    <button class="bg-primary text-body text-xl rounded-lg text-center  py-1 px-2 hover:bg-hovercolor"
      v-if="sec == 'halls'"><router-link :to="{ name: 'hallsdistr' }">توزيع</router-link></button>
    <button class="bg-primary text-body text-xl rounded-lg text-center  py-1 px-5 hover:bg-hovercolor">تعديل</button>
    <button class="bg-primary text-body text-xl rounded-lg text-center  py-1 px-5 hover:bg-hovercolor"
      @click="save">حفظ</button>





    <div class="
            space-x-4 text-primary flex justify-center items-center border-primary  ">
      <!-- <input type="number" id="year" placeholder="YYYY" min="1970" max="2100" v-model="year"
        class="h-10 text-center cursor-pointer rounded-lg" /> -->
        <select class="h-10 cursor-pointer rounded-lg ml-0  " v-model="studyYear">
          <option v-for="year in study_year" :key="year" :value="year">{{ year }}</option>
        </select>
      <label class=" text-primary "> :العام الدراسي &nbsp; </label>

    </div>
    <div class="items-center justify-center py-2 space-x-8" v-if="sec == 'halls'">

      <input type="date">
      <label> : تاريخ الامتحان </label>
    </div>
    <div class="items-center justify-center py-2 space-x-8" v-if="sec == 'halls'">
      <input type="time">
      <label> : وقت الامتحان </label>
    </div>

  </div>
  <transition name="toast">
    <Toast v-if="shtoast" :msg="msg"></Toast>
  </transition>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import Toast from '../../components/Toast.vue'
export default {
  data() {
    return {
      code: '',
      code1:'',
      studyYear: '',
      year: 2000,
      cources: [{ id: 0, specialization: '', name: '', year_of_course: '', IsActive: 1, course_code: 111, semester: '' }],
      course: {},
      year_of_course: 'first',
      semester: 1,
      shtoast: false,
      msg: ''

    }
  }, components: { Toast },
  methods: {
    show(d) {
      this.$emit('show', d)

    }, async transferCheck() {
      try {
        const res = await axios.post('/transferCheckExAdmin', { code: this.c_code, specialization: this.spec, studyYear: this.study_year, studysemster: this.semster },
          { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

        console.log(res)
        this.msg = res.data.message
        this.shtoast = true
        setTimeout(() => { this.shtoast = false }, 3000);

      }
      catch (e) {
        console.log(e);
      }
    },
    async save() {
      // try{
      //        const res = await axios.post('/ExamByCourse',{
      //         code:111,
      //         specialization:'fr',
      //         study_year:'2013/2012',
      //         Examsemster:2
      //        },{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  

      //        console.log(res)
      //         }
      //   catch (e) {
      //        console.log(e);
      //      }

      try {
        const res = await axios.post('/getCheckSess', {
          code: 111,
          specialization: 'fr',
          studyYear: '2013/2012',
          studysemster: 2
        }, { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

        console.log(res)
      }
      catch (e) {
        console.log(e);
      }
    }, async marks() {
      try {
        const res = await axios.post('/getMarksByYearStudent', {
          university_num: 1007,
          specialization: this.spec,
          year_of_course: this.year_of_course
        }, { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

        console.log(res)
      }
      catch (e) {
        console.log(e);
      }

    },async search(){
      try {
        const res = await axios.post('/getCourseByCode', { course_code: this.code1, specialization: this.spec},
          { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

        console.log(res)
       
      } catch (error) {
        console.log(error)
      }
    }

  },
  props: ['sec']
  , async mounted() {
    // const y = new Date().getFullYear();
    // this.year = y
    // document.getElementById("year").max = y
    try {
      const res = await axios.post('/showAllCourses', { specialization: this.spec },
        { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

      this.cources = res.data.data
      //  console.log(this.cources)
    }
    catch (e) {
      console.log(e);
    }
    try {
      const res = await axios.get('/getStudyYearsList',
        { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

      // console.log(res.data.years)
      this.$store.commit('Exam/SetStudyYear', res.data.years)

    }
    catch (e) {
      console.log(e);
    }


  }, computed: {
    ...mapGetters(["spec"]),
    ...mapGetters('Exam', ['c_code', 'study_year', 'semster']),

  },
  updated() {

    // this.studyYear=`${this.year}/${this.year+1}`
    // console.log(this.studyYear)
    this.code = this.course.course_code
    this.year_of_course = this.course.year_of_course
    this.$store.commit('Exam/SetCode', this.code)
    this.$store.commit('Exam/SetSemster', this.semester)

  }

};
</script>

<style></style>