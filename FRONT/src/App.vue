<script>
import Home from './views/HomeView.vue'
export default{
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


</style>
