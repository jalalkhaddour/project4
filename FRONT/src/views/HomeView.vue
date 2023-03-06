
<template>
<div >
<Navbar />
 <div v-if="Authenticated==false">
<!-- <UserLoginVue  @SuccessLogin="SuccessLogin" /> -->
<UserLoginVue></UserLoginVue>
</div>
 <div class="grid grid-cols-3 pt-36 gap-14 items-center text-white text-3xl  ml-10 ml-30 lg:pt-28 sm:pt-16 sm:mx-auto sm:space-x-24 lg:space-x-12  ">
         
        <button v-if="!success" class="rounded-full ml-40 ml-t1 bg-primary  h-40 w-40 card  " @click="toggleLogin('affairs')"    >الشؤون</button>
        <button v-if="!success" class="rounded-full ml-t2 ml-20  bg-primary h-40  w-40 card  " @click="toggleLogin('exam')" >الامتحانات</button>
         <button v-if="success" class="rounded-full ml-40 ml-t1 bg-primary  h-40 w-40  card " @click="setSpec('en')" > <router-link :to="{name:'Examination',params:{dept:dept}}">انكليزي</router-link> </button>
        <button v-if="success" class="rounded-full ml-t2 ml-20  bg-primary h-40  w-40  card " @click="setSpec('fr')" ><router-link :to="{name:'Examination',params:{dept:dept}}">فرنسي</router-link></button>
        <!-- <img src="../assets/Images/person.png" class=" pr-4 absolute right-24 imh-t  bottom-28 test-bottom invisible md:visible  " style="height: 45%;" alt=""> -->
        <transition name="scale" appear >
<img  src="../assets/Images/person.png" v-if="Authenticated" class="  absolute  right-24 top-1/3 pt-7 imh-t invisible md:visible " style="height: 45%;  " alt="">
        
        </transition>
</div>
<div class=" w-full  ">
        <img src="../assets/Images/Vector2.png" alt="" class=" h-48  w-80 absolute bottom-0 right-0  t-h">
</div>

</div>
 
<router-view></router-view>

</template>

<script>
import Navbar from '../components/NavBar.vue'
import { mapGetters } from 'vuex'
import UserLoginVue from '../components/UserLogin.vue'


export default {
    components:{Navbar,UserLoginVue},
   
    data() {
        return {
            
            success:false,
           
            
        }
    },methods: {
        
        toggleLogin(d){
       this.$store.commit("setDept",d)
       this.success=!this.success
        },
         setSpec(sp) {
           this.$store.commit("setSpec",sp)
        }
        
    },computed:{
        ... mapGetters(["dept","spec"]),
       ...mapGetters('AdUser',['username','password','Authenticated','cookies','Role']),

       
    }

}
</script>

<style>
.card{
    box-shadow:8px 8px 19px 8px rgba(0, 0, 0,0.9);
    transition: 0.35;
}
.card:hover{
   box-shadow:0 8px 16px 0 rgba(0, 0, 0,0.9); 
}
/*scale person image*/
.scale-enter-from{
    opacity: 0;
    transform:scale(0.2)
}
.scale-enter-active{
    transition: all 3s ease;
}
</style>