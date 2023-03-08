<template>
  <div class="">
    <div
      class="bg-primary  rounded-lg text-body text-2xl px-9 py-1  text-center mx-12 mb-2 flex justify-between items-center ">
      <button class="bg-primary hover:bg-hovercolor rounded-lg p-1" @click="getby('forth')"
        :class="{ ho: year == 'forth' }">السنة الرابعة</button>
      <button class="bg-primary hover:bg-hovercolor rounded-lg p-1" @click="getby('third')"
        :class="{ ho: year == 'third' }">السنة الثالثة</button>
      <button class="bg-primary hover:bg-hovercolor rounded-lg p-1" @click="getby('second')"
        :class="{ ho: year == 'second' }">السنة الثانية</button>
      <button class="bg-primary hover:bg-hovercolor rounded-lg p-1" @click="getby('first')"
        :class="{ ho: year == 'first' }">السنة الأولى</button>
    </div>
    <div class="border-2 border-hovercolor">

      <div class="mx-12">
        <div class="flex justify-center space-x-24 text-white text-lg bg-primary  items-center rounded-lg">
          <button style="width:50%" @click="sem = 'second'" :class="{ 'ho': sem == 'second' }"> الفصل الثاني</button>

          <button style="width:50%" @click="sem = 'first'" :class="{ 'ho': sem == 'first' }">الفصل الأول</button>


        </div>
        <Subjecttable :sem="sem" :allC="allC" />

        <div id="filters" class=" flex justify-center items-center mx-12 my-1  text-lg text-primary">
          <button class="bg-primary text-body text-xl rounded-lg text-center m-2 py-1 px-2 hover:bg-hovercolor w-28  h-12"
            @click.self="sr" v-if="dept == 'affairs'"> تسجيل مواد</button>
          <!-- <div class="space-x-4 m-2"><input type="radio" name="filter" v-model="filter" value="succsess "  >&nbsp; المواد الناجحة</div>
    <div class="space-x-4 m-2"> <input type="radio" name="filter" v-model="filter" value="failed">&nbsp;المواد الراسبة</div>
    <div class="space-x-4 m-2"><input type="radio" name="filter" v-model="filter" value="unreg">&nbsp;غير المسجلة </div>
    <div class="space-x-4 m-2"><input type="radio" name="filter" v-model="filter" value="reg"> &nbsp; المسجلة </div>
    <div class="space-x-4 m-2"><input type="radio" name="filter" v-model="filter" value="all" selected=true> &nbsp; الكل </div>-->
        </div>
      </div>
    </div>


  </div>
</template>

<script>
import axios from "axios";

import { ref } from '@vue/reactivity'
import { mapGetters } from 'vuex'
import AboutView from '../../../views/AboutView.vue'
import Subjecttable from './Subjecttable.vue'
export default {
  // eslint-disable-next-line vue/no-unused-components
  components: { AboutView, Subjecttable },
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'Subject',

  setup() {

    const year = ref('first')
    const sem = ref('first')
    const filter = ref('all')
    const allC = ref([{ sem: '', year: '' }])
    return { year, sem, filter, allC }
  },
 

  methods: {

    sr() {
      this.$emit("sr")
    }, async getby(a) {
      this.year = a
      console.log(this.year)
      try {
        const res = await axios.post('/getMarksByYearStudent', { university_num: this.university_num, specialization: this.spec, year: a }, { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });
        console.log(res);
        this.allC = [];
        const new55 = res.data.cours;
        var u = 0;
        for (var v of new55) {
          this.allC[u] = v;
          u += 1;
        }
        console.log(this.allC);
      }
      catch (e) {
        console.log(e);
      }
    }

  }, computed: {
    ...mapGetters('Student', ['university_num', 'fullname', 'info']),
    ...mapGetters(["spec", "dept"]),
    findCourse() {
      return this.allC.filter(us => {
        return us.sem.match(this.sem)
      })
    }

  }, mounted() {
  

  }
}

</script>

<style></style>