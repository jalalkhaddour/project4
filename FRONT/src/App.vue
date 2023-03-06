<script>
import Home from './views/HomeView.vue'

export default{
  props: {
  },
components:{Home}
}

</script>

<template >

  <router-view></router-view>
</template>

<style>
@media screen and (min-width: 1366px) {
    .test-bottom {
        position: absolute;
        bottom: 80px;
        right: 112px;
    }
    .t-h {
        height: 160px;
    }
    .ml-t2 {
        margin-left: 128px;
    }
    .ml-t1 {
        margin-left: 224px;
    }
    .imh-t {
        height: 300px;
    }
    .right-t {
        position: absolute;
        right: 33.333333%;
    }
}
/*toast animation */ 
.toast-enter-active{
   /* transition: all 0.3s ease; */
   animation: wobble 0.5s ease;
  }
  
    .toast-leave-to{
      opacity: 0;
      transform: translateY(-60px);
    }
    .toast-leave-active{
      transition: all 0.3s ease;
    }
    @keyframes wobble{
      0%{  opacity: 0; transform: translateY(-60px);}
      50%{opacity: 1;  transform: translateY(0px);} 
      60%{transform: translateX(8px);}   
      70%{transform: translateX(-8px);}   
      80%{transform: translateX(4px);}   
      90%{transform: translateX(-4px);}   
      100%{transform: translateX(0px);}   
   }

</style>
