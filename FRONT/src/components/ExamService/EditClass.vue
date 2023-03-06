<template>
    <div class="backdrop3">
      <div
        class="   text-2xl text-primary   flex   space-y-4   rounded-lg   flex-col p-0  my-24   border-3 border-primary  w-1/3   mx-auto     bg-body "  >
        <div
          class=" h-9 flex items-center relative w-full p-3 pt-2 bg-primary  " >
          <lable class="mx-auto text-2xl text-body" v-if="proc=='add'"> إضافة قاعة </lable>
          <lable class="mx-auto text-2xl text-body" v-if="proc=='edit'"> تعديل قاعة </lable>
          <img
            src="../../assets/Images/close-box.png"
            class="absolute right-3 cursor-pointer"
            @click="ha(false)"
            alt=""
          />
        </div>
        <div> 
            <div class="flex justify-center space-y-2">
            <div>
              <form class="space-y-3">
                 <div>
                  <input  type="text" id="class_num"  dir="auto" v-model="class_num"  name=""  class="rounded-lg  mx-3 my-1 w-48 text-right  px-2"/>
                  <label for="class_num"> :القاعة </label>
                </div>
                <div>
                  <input  type="text" id="capacity"  dir="auto" v-model="capacity"  name=""  class="rounded-lg  mx-3 my-1 w-48 text-right  px-2"/>
                  <label for="capacity"> :السعة </label>
                </div>
                <div>
                  <input  type="text" id="capacity"  dir="auto" v-model="ready"  name=""  class="rounded-lg  mx-3 my-1 w-48 text-right  px-2"/>
          
                <label for="ready"> : الحالة </label>
              </div>
              <div>
                  <input  type="text" id="location"  dir="auto" v-model="location"  name=""  class="rounded-lg  mx-3 my-1 w-48 text-right  px-2"/>
                  <label for="location"> :الموقع </label>
                </div>
               
                   <div class="text-lg   rounded-lg  mx-28 text-green-800" v-if="msg">
                    {{msg}}
                  </div>  
                  <div class="text-lg   rounded-lg  mx-28 text-red-500" v-if="msg1">
                    {{msg1}}
                  </div> 
              </form>
            </div>
            
          </div><div class="mx-auto">
              <button class="bg-primary text-body text-xl rounded-lg text-center m-4 py-1 px-2  hover:bg-hovercolor w-28  h-12" @click="add" v-if="proc=='add'"> إضافة </button>
              <button class="bg-primary text-body text-xl rounded-lg text-center m-4 py-1 px-2  hover:bg-hovercolor w-28  h-12" @click="edit" v-if="proc=='edit'"> تعديل </button>
  </div>
        </div>
      </div>
    </div>
  </template>
        
     
      
      <script>
  import axios from 'axios';    
  import { mapGetters } from 'vuex'   
  export default {
  
    data() {
      return {
        msg:'',
        msg1:'',
        class_id:0,
        class_num:'',
        capacity:0,
        ready:0,
        location:'',
        classes:[{}],
        classes_count:0,
        classes_capacity:0
      };
    },props:['clas','proc'],
    methods: {
        ha() {
      this.$emit("close");
    },async add(){
        try{
               const res = await axios.post('/addExamClass',
               {specialization:this.spec,class_num:this.class_num,ready:this.ready,capacity:this.capacity,location:this.location}
               ,{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});
               this.msg=res.data.message
               console.log(res)
               this.msg1=''
                }
          catch (e) {
               console.log(e);
               this.msg1=e.response.data.message
               this.msg=''
             }
             try{
             const res = await axios.post('/showAllClasses',{specialization:this.spec},
             {headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
             this.classes=[{}]
             const classes1=res.data.classes
              for(var cl in classes1){
                this.classes[cl]=classes1[cl]
              }
              this.classes_count=0
              this.classes_capacity=0
              for (var cla of this.classes){
                this.classes_count++;
                this.classes_capacity+=cla.capacity
                      }
            this.reset(this.classes,this.classes_count,this.classes_capacity)

            //  console.log(this.classes)
              }
        catch (e) {
             console.log(e);
           }
           
             
      },async edit(){
       try{
               const res = await axios.post('/UpdateExamClass',
               {id:this.class_id,class_num:this.class_num,ready:this.ready,capacity:this.capacity,location:this.location}
               ,{headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});
               this.msg=res.data.message
               console.log(res)
               this.msg1=''
                }
          catch (e) {
               console.log(e);
               this.msg1=e.response.data.message
               this.msg=''
             }
             try{
             const res = await axios.post('/showAllClasses',{specialization:this.spec},
             {headers: {'Authorization':'Bearer '+this.$cookies.get('access_token'),'Access-Control-Allow-Credentials':true}});  
             this.classes=[{}]
             const classes1=res.data.classes
              for(var cl in classes1){
                this.classes[cl]=classes1[cl]
              }
              this.classes_count=0
              this.classes_capacity=0
              for (var cla of this.classes){
                this.classes_count++;
                this.classes_capacity+=cla.capacity
                      }
            this.reset(this.classes,this.classes_count,this.classes_capacity)

            //  console.log(this.classes)
              }
        catch (e) {
             console.log(e);
           }
           
             
      },reset(cl,count,capacity){
      this.$emit('recive',cl,count,capacity)
    }
     
    },computed:{
     
        ...mapGetters(["spec"]),
  
  },
   mounted(){
    //   console.log(this.clas)
      if(this.proc=='edit'){
      this.class_id=this.clas.class_id
      this.class_num=this.clas.class_num
      this.capacity=this.clas.capacity
      this.ready=this.clas.ready
      this.location=this.clas.location
    }
    //   console.log(this.class_id)
  }
}
  </script>
      
      <style>
  </style>