<template >
<div class="justify-center flex object-center">
  <div class="space-x-2 space-y-2 backdrop text-white object-center "  >
    <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
    <router-link :to="{name:''}">
      <p style="text-align: center">  تسجيل طالب جديد</p></router-link
    >
    <hr class="bg-body" />
  </div>
    <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
    <router-link :to="{name:'Student'}">
      <p style="text-align: center"> الطلاب </p></router-link
    >
    <hr class="bg-body" />
  </div>
    <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
    <router-link to="">
      <p style="text-align: center">سجل عام</p></router-link
    >
    <hr class="bg-body" />
  </div>

    <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
    <router-link to="">
      <p style="text-align: center">ترقين قيد</p></router-link
    >
    <hr class="bg-body" />
  </div>
  
    <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
    <router-link to="/transport">
      <p style="text-align: center">نقل طالب</p></router-link
    >
    <hr class="bg-body" />
  </div>


    <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
    <router-link to="">
      <p style="text-align: center">مصدقة تأجيل</p></router-link
    >
    <hr class="bg-body" />
  </div>
          <div class="w-52 hover:bg-hovercolor rounded-5">
          <router-link to='/graduates'>
            <p style="text-align: center">خريجون </p></router-link
          >
          <hr class="bg-body flex justify-center" />
        </div>
  </div>
</div>
</template>

<script>
import axios from "axios";

export default {

}
</script>

<style>

</style>