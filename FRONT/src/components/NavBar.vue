<template>
  <div style="width:100% ; ">
    <div>
      <div class="header h-52 " style=" width: 100%; ">
        <!-- <div class="header h-52" style=" width: 100%; "> -->

        <div class="flex items-center justify-between ">
          <div id="al_baath_logo">
            <a href="https://albaath-univ.edu.sy/">
              <img src="../assets/Images/al-baath-logo.png" class="h-24 w-24 pt-2 " alt="" />
            </a>
          </div>
          <button><img @click="menuTOG" class=" absolute top-0 right-0 h-12 w-12  me"
              src="../assets/Images/menu.png "></button>
          <div class="backdrop" @click="menu1 = false" v-if="menu1">
            <div v-if="menu1"
              class="absolute top-1px right-0 text-white bg-primary text-lg w-20 text-center text-right rounded-lg m-2 mt-8 me">

              <button class="hover:bg-hovercolor rounded-lg text-center w-20"> <router-link to="/"> &nbsp; الرئيسية
                  &nbsp;</router-link><br></button>
              <hr class="bg-body" />
              <button class="hover:bg-hovercolor rounded-lg text-center w-20"> <router-link to="/administrtive">
                  &nbsp;إداري &nbsp;</router-link><br></button>
              <hr class="bg-body" />
              <button class="hover:bg-hovercolor rounded-lg text-center w-20"> <router-link to="/about">&nbsp;حول
                  &nbsp;</router-link><br></button>


            </div>
          </div>
          <div
            class="text-white   text-xl px-7 absolute top-0 right-3  flex  justify-between space-x-12 invisible md:visible ">

            <router-link to="/about" class="my-8 ">&nbsp;حول &nbsp;</router-link>
            <router-link to="/administrtive" class="my-8 " v-if="Role == 'Admin' || Role == 'AfAdmin' || Role == 'ExAdmin'">
              &nbsp;إداري &nbsp;</router-link>
            <router-link to="/"
              class="my-8 transition duration-500 hover:border-yellow-400 border-b-4 border-gray-800 border-opacity-75  ">
              &nbsp; الرئيسية &nbsp;</router-link>
            <img src="../assets/Images/user.png" class="my-2 w-14 h-14 cursor-pointer " alt="" @click="info" />
          </div>
          <div class="absolute right-12 top-14 text-white text-lg   p-2 justify-end flex" style="height:5px;  "
            v-if="show">
            <div>
              <UserInfo :show="show" @sh="close" @cl="cl" />
            </div>
          </div>
          <transition appear @beforeEnter="beforeEnter" @enter="enter" @after-enter="afterEnter">
            <h1 v-if="homeAnimation" class="flex text-5xl  font-bold text-white items-top  top-2/3 mx-auto my-28 "
              style="letter-spacing: 2px;"> برنامج التعليم المفتوح</h1>
          </transition>
          <h1 v-if="homeAnimation2" class="flex text-5xl  font-bold text-white items-top  top-2/3 mx-auto my-28 "
            style="letter-spacing: 2px;"> برنامج التعليم المفتوح</h1>

        </div>

      </div>
    </div>
  </div>
  <div v-if="showa">
    <ChangePass @close="close"></ChangePass>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import UserInfo from './UserInfo.vue'
import ChangePass from './AdministrationService/ChangePass.vue'
import gsap from 'gsap'
export default {
  props: []
  ,
  name: 'NavBar',
  data() {
    return {
      menu1: false,
      show: false,
      uinfo: '',
      showa: false,

    }
  }, components: { UserInfo, ChangePass }
  ,
  methods: {
    menuTOG() {
      this.menu1 = !this.menu1
    }, info() {
      this.show = !this.show
    }, close(d) {
      this.showa = d
    }, cl(d) {
      this.show = d
    },
    beforeEnter(el) {
      console.log("before enter")
      el.style.transform = "translateY(-60px)"
      el.style.opacity = 0
    },
    enter(el, done) {
      console.log("enter", el)
      gsap.to(el, {
        y: 0,
        opacity: 1,
        duration: 3,
        onComplete: done,
        ease: 'bounce.out'
      })
     
    },afterEnter(el,done){
      this.$store.commit('setHomeAnimation',false)
      gsap.to(el, {
        opacity: 0,
        duration: 0.1,
        onComplete: done,
      })
      setTimeout(() => {
        this.$store.commit('setHomeAnimation2',true)
      }, 1000);
     
    }
  }, computed: {
    ...mapGetters(["homeAnimation","homeAnimation2"]),
    ...mapGetters('AdUser', ['username', 'password', 'Authenticated', 'Cookies', 'Role']),
  },mounted() {
 
  },
}
</script>

<style>
#al_baath_logo {
  position: absolute;
  width: 110px;
  height: 110px;
  left: 20px;
  top: 10px;
}

.header {
  background-image: url("../assets/Images/Header.png");
  background-repeat: no-repeat;
  background-size: cover;

}

.me {
  visibility: hidden;
}

@media only screen and (max-width: 770px) {
  .me {
    visibility: visible;

  }
}

.backdrop1 {
  top: 0;
  position: fixed;
  margin: 0;
  background: rgba(73, 73, 73, 0.9);
  height: 100%;
  width: 100%;
}</style>