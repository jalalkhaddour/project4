<template>
    <div style="text-align:center" class="text-5xl p-6 text-primary"> خدمات شعبة الامتحانات</div>
    <div class="my-8 space-y-8 bg-body text-white text-2xl ">
   
        <div class=" flex justify-center space-x-24">
         <router-link :to="{name:'container',params:{sec:'halls'}}"> <button class="card h-44 rounded-full w-44 bg-primary">قاعات</button></router-link>
         <router-link :to="{name:'container',params:{sec:'results'}}"> <button class=" card h-44 rounded-full w-44 bg-primary">النتائج الإجمالية</button></router-link>
         <router-link :to="{name:'container',params:{sec:'session'}}"> <button class="   card h-44 rounded-full w-44 bg-primary">فتح جلسة رصد</button></router-link>

        </div>
        <div class=" flex justify-center space-x-24">
         <router-link to="" > <button @click="displaySer(true)" class=" card h-44 rounded-full w-44 bg-primary">المزيد</button></router-link>
         <router-link to="/exaDocuments"> <button class="card h-44 rounded-full w-44 bg-primary">وثائق</button></router-link>
         </div>
    </div>
</template>

<script>
export default {
  methods: {
      displaySer(d){
     this.$emit("display",d)
}
  },

}
</script>

<style>

</style>