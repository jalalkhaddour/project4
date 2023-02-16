<template>
<div>
    <div style="text-align:center" class="text-5xl p-6 text-primary"> خدمات شعبة الشؤون</div>
    <div class="my-8 space-y-8 bg-body text-white text-2xl ">
   
        <div class=" flex justify-center space-x-24">
         <router-link :to="{name:'publicrecord'}"> <button class="  card h-44 rounded-full w-44 bg-primary">سجل عام</button></router-link>
         <router-link :to="{name:'Student'}"> <button class=" card h-44 rounded-full w-44 bg-primary">الطلاب</button></router-link>
         <router-link :to="{name:'newstudent'}"> <button class="   card h-44 rounded-full w-44 bg-primary"> تسجيل طالب جديد</button></router-link>
        </div>
        <div class=" flex justify-center space-x-24">
         <router-link to="" > <button  @click="displaySer(true)" class=" card h-44 rounded-full w-44 bg-primary">المزيد</button></router-link>
         <router-link to="/affDocuments"> <button class=" card h-44 rounded-full w-44 bg-primary">وثائق</button></router-link>
         </div>
    </div>
</div>
</template>

<script>
export default {
  name:'AffairsService',
methods: {
      displaySer(d){
     this.$emit("display",d)
}
  },
}
</script>

<style>

</style>