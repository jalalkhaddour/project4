<template>
  <div class="bg-body w-full h-full">

    <div
      class="space-x-9 w-full  text-white text-lg font-medium h-10 bg-primary flex justify-end items-center">
       
        <router-link to="/about">&nbsp;حول &nbsp;</router-link>
        <router-link to="/administrtive"  v-if="Role=='Admin' || Role=='AfAdmin' || Role=='ExAdmin'"> &nbsp;إداري &nbsp;</router-link>
        <router-link to="/" > &nbsp; الرئيسية &nbsp;</router-link>
        <img class=" h-12 w-24 pr-12 mt-3 cursor-pointer" src="../assets/Images/menu.png" @click="displaySer">
    </div>
    <!-- <p class="text-black" > {{$route.params.dept}}</p> -->
    <ExamService v-if="department=='exam'" @display="displaySer" />
    <AffairsService v-if="department=='affairs'"  @display="displaySer"/>
    <div class="w-full h-full bg-body relative">
      <div :class="{backdrop3:ms}" v-if="ms" @click.self="this.ms=false" class="justify-end flex">
   
        <div class="more bg-primary w-62 text-white text-lg fixed rounded-6 p-2 justify-end flex" style="height:700px; top:40px"  >
            <div >
<ExamList v-if="department=='exam'"/>
<AffairsList v-if="department=='affairs'"/>
            </div>
        </div>
      </div>
    </div>
    <br><br><br>
  </div>
</template>

<script> 
import { mapGetters } from 'vuex'
import AffairsService from '../components/AffairsService/AffairsService.vue'
import ExamService from '../components/ExamService/ExamService.vue'
import  AffairsList from '../components/AffairsService/AffairsList.vue'
import ExamList from '../components/ExamService/ExamList.vue'
export default {
  components:{AffairsService,ExamService,ExamList,AffairsList},
  data() {
    return {
      ms: false,
      department:this.dept
      // department:this.$route.params.dept
    };
  },props:['dept'],
 

  methods: {
    displaySer() {
      this.ms = !this.ms;
    },
    
  },computed:{
     ...mapGetters('AdUser',['username','password','Authenticated','Cookies','Role']),
  }
};
</script>

<style>
.backdrop3{
    top:0px;
    position: fixed;
    background-color: rgb(0, 0, 0,0.4);
    width: 100%;
    height: 100%;}
    .more{
    top:50px;
   
    }
    .ba{
    top:0px;
    position: fixed;
    background-color:rgb(192, 192, 192);
    width: 100%;
    height: 100%;
}
</style>