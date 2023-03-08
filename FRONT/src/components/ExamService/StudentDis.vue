<template>
  <div class="backdrop3">
    <div
      class="   text-2xl text-primary   flex   space-y-4   rounded-lg   flex-col p-0  my-24   border-3 border-primary  w-1/3   mx-auto my-50     bg-body ">
      <div class=" h-9 flex items-center relative w-full p-3 pt-2 bg-primary  ">
        <lable class="mx-auto text-2xl text-body"> فرز</lable>
        <img src='../../assets//Images/close-box.png' class="absolute right-3 cursor-pointer" @click="ha()" />
      </div>
      <div class="flex justify-center m-2 space-x-8 ">

        <div class="flex justify-center space-x-2">
          <label>{{ cla.capacity }}</label>
          <label>
            : السعة
          </label>

        </div>
        <div class="flex justify-center space-x-2">
          <label>{{ cla.class_num }}</label>
          <label>
            : القاعة

          </label>

        </div>
      </div>
      <div>
        <div class="flex justify-center m-2 space-x-8">

<div class="flex justify-center space-x-2">
<label>{{ studysemester}}</label>
<label>
: الفصل الدراسي
</label>

</div>
          <div class="flex justify-center space-x-2">
<label>{{ studyYear }}</label>
<label>
: العام الدراسي

</label>

</div>
</div>

      </div>
      <div class="flex justify-center m-2">
        <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor m-6"
          @click="fill">تعبئة</button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from "axios";

export default {
  props: ['cla', 'studysemester', 'studyYear', 'code'],
  data() {
    return {
      ch: ''
    }
  },
  methods: {
    ha() {
      this.$emit("close");
    },
    async fill() {

      try {
        const res = await axios.post('/PutStudentsInClassByCourse',
          { course_id: this.code.course_code, specialization: this.spec, studyYear: this.studyYear, class_id: this.cla.class_id, studysemster: this.studysemester }
          , { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

        console.log(res)

      }
      catch (e) {
        console.log(e);

      }
    }
  },
  mounted() {
    // console.log(this.cla)
    // console.log(this.studyYear)
    // console.log(this.studysemester)
    // console.log(this.code.course_code)

  }, computed: {
    ...mapGetters(["spec"]),
  }
}
</script>

<style></style>