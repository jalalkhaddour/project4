<template>
  <div class="space-x-2 space-y-2"> 
    <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
    <router-link :to="{name:'newstudent'}">
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
    <router-link to="/publicrecord">
      <p style="text-align: center">سجل عام</p></router-link
    >
    <hr class="bg-body" />
  </div>

    <div class="w-52 hover:bg-hovercolor rounded-5 m-2">
    <router-link :to="{name:'Stop'}">
      <p style="text-align: center">ترقين قيد</p></router-link
    >
    <hr class="bg-body" />
  </div>
  


   
          <div class="w-52 hover:bg-hovercolor rounded-5">
          <router-link to='/graduates'>
            <p style="text-align: center">خريجون </p></router-link
          >
          <hr class="bg-body flex justify-center" />
        </div>
                  <div class="w-52 hover:bg-hovercolor rounded-5">
          <router-link :to="{name:'stopped'}">
            <p style="text-align: center">المنسحبين </p></router-link
          >
          <hr class="bg-body flex justify-center" />
        </div>
  </div>
</template>

<script>
export default {

}
</script>

<style>

</style>