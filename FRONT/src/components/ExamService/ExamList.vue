<template>
<div class="space-x-2 space-y-2"> 
  <!-- <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
    <router-link to="">
      <p style="text-align: center">الانقطاعات</p></router-link>
    <hr class="bg-body" />
  </div>
  <div class="w-52 hover:bg-hovercolor rounded-5">
    <router-link to="">
      <p style="text-align: center">الإيقافات</p></router-link>
    <hr class="bg-body flex justify-center" />
  </div> -->
  <div class="w-52 hover:bg-hovercolor rounded-5">
    <router-link :to="{name:'container',params:{sec:'results'}}">
      <p style="text-align: center">النتائج الإجمالية</p></router-link>
    <hr class="bg-body flex justify-center" />
    </div> 
    <!-- <div class="w-52 hover:bg-hovercolor rounded-5">
      <router-link to=""> <p style="text-align: center">التفقد</p></router-link>
      <hr class="bg-body flex justify-center" />
      </div>  -->
     <!-- <div class="w-52 hover:bg-hovercolor rounded-5">
        <router-link :to="{name:'documents'}">
          <p style="text-align: center">بيان وضع</p></router-link>
        <hr class="bg-body flex justify-center" />
      </div>-->
    
        <!-- <div class="w-52 hover:bg-hovercolor rounded-5">
          <router-link to="">
            <p style="text-align: center">حياة جامعية</p></router-link>
          <hr class="bg-body flex justify-center" />
        </div> -->
        <div class="w-52 hover:bg-hovercolor rounded-5">
        <router-link :to="{name:'container',params:{sec:'session'}}">
          <p style="text-align: center">جلسات الرصد والنتائج</p></router-link>
        <hr class="bg-body flex justify-center" />
        </div> 
        <!-- <div class="w-52 hover:bg-hovercolor rounded-5">
          <router-link to="">
            <p style="text-align: center">عقوبات</p></router-link
          >
          <hr class="bg-body flex justify-center" />
        </div> -->
        <div class="w-52 hover:bg-hovercolor rounded-5">
          <router-link :to="{name:'container',params:{sec:'halls'}}">
            <p style="text-align: center">قاعات</p></router-link
          >
          <hr class="bg-body flex justify-center" />
        </div>
        <div class="w-52 hover:bg-hovercolor rounded-5">
          <router-link :to="{name:'examstudent'}">
            <p style="text-align: center">طلاب</p></router-link
          >
          <hr class="bg-body flex justify-center" />
        </div>
      <!--  <div class="w-52 hover:bg-hovercolor rounded-5">
          <router-link :to="{name:'documents'}">
            <p style="text-align: center">كشف علامات</p></router-link
          >
          <hr class="bg-body flex justify-center" />
        </div>-->
        <div class="w-52 hover:bg-hovercolor rounded-5">
          <router-link :to="{name:'lectures'}">
            <p style="text-align: center">مقررات الطلاب</p></router-link
          >
          <hr class="bg-body flex justify-center" />
        </div>
        <!-- <div class="w-52 hover:bg-hovercolor rounded-5">
          <router-link to="">
            <p style="text-align: center">نسخ احتياطي</p></router-link
          >
          <hr class="bg-body flex justify-center" />
        </div> -->
        </div> 
</template>

<script>
export default {};
</script>

<style>
</style>