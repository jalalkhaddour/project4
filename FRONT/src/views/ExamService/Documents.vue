<template>
  <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"
    style="text-align:center">
    <div>
      <img src="../../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back" alt="">
    </div>
    <div>
      وثائق &nbsp;&nbsp;</div>
  </div>
  <div class="flex justify-between items-center mt-4 mx-6 ">
    <div class="flerx justify-center items-center space-x-4 text-primary text-lg">
      <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor"
        @click="getby">طباعة</button>

    </div>
    <div class="flerx justify-center items-center space-x-4 text-primary text-lg">
      <button class="bg-primary text-body text-lg rounded-lg text-center  px-5 hover:bg-hovercolor"
        @click="SearchStudent()">عرض</button>

    </div>
    <div class="flerx justify-center items-center space-x-4 text-primary text-lg">

      <select class="rounded-lg text-primary text-lg h-8 " v-model="docType">
        <option value="k">
          كشف علامات
        </option>
        <option value="b">
          بيان وضع
        </option>
      </select>
      <label>
        : الوثيقة
      </label>
    </div>

    <div class="flerx justify-center items-center space-x-4 text-primary text-lg">
      <input type="text" class="search rounded-lg w-34" v-model="university_num">
      <label>
        : الرقم الجامعي
      </label>
    </div>
  </div>
  <div>
    <div class=" border-primary border-2 mx-4 mt-6 mb-6" v-if="docType == 'k'">
      <div class="flex  items-center justify-between mb-24 mt-6 mx-6  text-primary text-lg">
        <div class="h-42 w-42">
          <img src="../../assets/Images/al-baath-logo.png" class="h-36 w-36 pt-2 " alt="" />
        </div>
        <div class="m-1 ">
          <label class="flex justify-center items-center mx-auto">الجمهورية العربية السورية</label><br>
          <label class="flex justify-center items-center mx-auto">جامعة البعث
          </label><br>
          <label class="flex justify-center items-center mx-auto">كلية الآداب والعلوم الإنسانية</label>
        </div>
      </div>
      <div class="flex justify-center text-primary text-4xl mb-24">
        كشف العلامات
      </div>
      <div class=" mx-auto mt-2">
        <table class="t1 text-primary">
          <tr class="t1 text-primary">
            <td class="t1 bg-body text-primary ">
              {{ student1.mothername }}
            </td>
            <td class="t1 bg-body  text-primary">
              : اسم الأم
            </td>
            <td class="t1 bg-body text-primary">
              {{ student1.fathername }}
            </td>
            <td class="t1 bg-body text-primary">
              : اسم الأب
            </td>
            <td class="t1 bg-body text-primary">
              {{ student1.fullname }}
            </td>

            <td class="t1 bg-body text-primary">
              : اسم الطالب وكنيته
            </td>
          </tr>
          <tr class="t1 text-primary">
            <td class="t1 bg-body text-primary ">
              {{ student1.birthdate }} {{ student1.birthplace }}
            </td>
            <td class="t1 bg-body text-primary ">
              : محل وتاريخ الولادة
            </td>
            <td class="t1 bg-body text-primary">
              {{ student1.nationality }}
            </td>
            <td class="t1 bg-body text-primary">
              : الجنسية

            </td>
            <td class="t1 bg-body text-primary">
              {{ student1.created_at }}
            </td>

            <td class="t1 bg-body text-primary">
              : تاريخ التسحيل
            </td>
          </tr>

        </table>
      </div>
      <div class="flex justify-end text-primary text-lg mt-14 mx-2">
        <label>
          2022 فيما يلي كشف بدرجات الطالب/ة خلال سنين دراسته الجامعية في كلية الآداب والعلوم الإنسانية برنامج التعليم
          المفتوح قسم الترجمة حتى العام الدراسي
        </label>
      </div>
      <div class="mt-4">
        <div class="flex justify-center text-primary text-2xl">
          السنة الأولى
        </div>
        <div class=" mx-auto mt-2">
          <table class="h-92 w-92">
            <tr>
              <th colspan="3">الدرجة</th>
              <th colspan="3" rowspan="2">مقررات الفصل الثاني</th>
              <th colspan="3">الدرجة</th>
              <th colspan="3" rowspan="2">مقررات الفصل الأول </th>

            </tr>
            <tr>
              <th colspan="2">كتابة</th>
              <th>رقماً</th>
              <th colspan="2">كتابة</th>
              <th>رقماً</th>

            </tr>
             {{initt_i()}}
             {{setSems(1)}}
            <tbody  v-for="s in sec1" :key="s.id" >
                  <tr >
                    <td colspan="2"> </td>
                    {{ looog(i,secNum,1)  }}
                  <td>{{ seco2.semester == 'second'? seco2.Mark:'' }}</td>
                  <td colspan="3">{{ seco2.semester == 'second'? seco2.course_name:'' }} </td>
                    <td colspan="2"> </td>
                  <td>{{ s.semester == 'first'? s.Mark:'' }}</td>
                  <td colspan="3">{{ s.semester == 'first'? s.course_name:'' }}</td> </tr>


             {{ movv_i()}}
            </tbody>
            <tfoot>
              <td colspan="3"></td>

              <td colspan="3"> المعدل </td>
              <td colspan="3"></td>

              <td colspan="3">المجموع </td>
            </tfoot>

          </table>
        </div>
      </div>
      <div class="mt-4">
        <div class="flex justify-center text-primary text-2xl">
          السنة الثانية
        </div>
        <div class=" mx-auto mt-2">
          <table class="h-92 w-92">
            <tr>
              <th colspan="3">الدرجة</th>
              <th colspan="3" rowspan="2">مقررات الفصل الثاني</th>
              <th colspan="3">الدرجة</th>
              <th colspan="3" rowspan="2">مقررات الفصل الأول </th>

            </tr>
            <tr>
              <th colspan="2">كتابة</th>
              <th>رقماً</th>
              <th colspan="2">كتابة</th>
              <th>رقماً</th>

            </tr>
             {{initt_i()}}
             {{setSems(2)}}
            <tbody  v-for="s in sec1" :key="s.id" >
                  <tr >
                    <td colspan="2"> </td>
                    {{ looog(i,secNum,2)  }}
                  <td>{{ seco2.semester == 'second'? seco2.Mark:'' }}</td>
                  <td colspan="3">{{ seco2.semester == 'second'? seco2.course_name:'' }} </td>
                    <td colspan="2"> </td>
                  <td>{{ s.semester == 'first'? s.Mark:'' }}</td>
                  <td colspan="3">{{ s.semester == 'first'? s.course_name:'' }}</td> </tr>


             {{ movv_i()}}
            </tbody>
            <tfoot>
              <td colspan="3"> </td>

              <td colspan="3"> المعدل </td>
              <td colspan="3"></td>

              <td colspan="3">المجموع </td>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="mt-4">
        <div class="flex justify-center text-primary text-2xl">
          السنة الثالثة
        </div>
        <div class=" mx-auto mt-2">
          <table class="h-92 w-92">
            <tr>
              <th colspan="3">الدرجة</th>
              <th colspan="3" rowspan="2">مقررات الفصل الثاني</th>
              <th colspan="3">الدرجة</th>
              <th colspan="3" rowspan="2">مقررات الفصل الأول </th>

            </tr>
            <tr>
              <th colspan="2">كتابة</th>
              <th>رقماً</th>
              <th colspan="2">كتابة</th>
              <th>رقماً</th>

            </tr>
             {{initt_i()}}
             {{setSems(3)}}
            <tbody  v-for="s in sec1" :key="s.id" >
                  <tr >
                    <td colspan="2"> </td>
                    {{ looog(i,secNum,3)  }}
                  <td>{{ seco2.semester == 'second'? seco2.Mark:'' }}</td>
                  <td colspan="3">{{ seco2.semester == 'second'? seco2.course_name:'' }} </td>
                    <td colspan="2"> </td>
                  <td>{{ s.semester == 'first'? s.Mark:'' }}</td>
                  <td colspan="3">{{ s.semester == 'first'? s.course_name:'' }}</td> </tr>


             {{ movv_i()}}
            </tbody>
            <tfoot>
              <td colspan="3"> </td>

              <td colspan="3"> المعدل </td>
              <td colspan="3"></td>

              <td colspan="3">المجموع </td>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="mt-4">
        <div class="flex justify-center text-primary text-2xl">
          السنة الرابعة
        </div>
        <div class=" mx-auto mt-2">
          <table class="h-92 w-92">
            <tr>
              <th colspan="3">الدرجة</th>
              <th colspan="3" rowspan="2">مقررات الفصل الثاني</th>
              <th colspan="3">الدرجة</th>
              <th colspan="3" rowspan="2">مقررات الفصل الأول </th>

            </tr>
            <tr>
              <th colspan="2">كتابة</th>
              <th>رقماً</th>
              <th colspan="2">كتابة</th>
              <th>رقماً</th>

</tr>
 {{initt_i()}}
 {{setSems(4)}}
<tbody  v-for="s in sec1" :key="s.id" >
      <tr >
        <td colspan="2"> </td>
        {{ looog(i,secNum,4)  }}
      <td>{{ seco2.semester == 'second'? seco2.Mark:'' }}</td>
      <td colspan="3">{{ seco2.semester == 'second'? seco2.course_name:'' }} </td>
        <td colspan="2"> </td>
      <td>{{ s.semester == 'first'? s.Mark:'' }}</td>
      <td colspan="3">{{ s.semester == 'first'? s.course_name:'' }}</td> </tr>


 {{ movv_i()}}
</tbody>
            <tfoot>
              <td colspan="3"> </td>

              <td colspan="3"> المعدل </td>
              <td colspan="3"></td>

              <td colspan="3">المجموع </td>
            </tfoot>
          </table>
        </div>
      </div>
      <div>
        <label class="flex justify-end text-primary text-lg m-6">
          : ملاحظات
        </label>
        <div class="flex justify-end">
          <textarea class="flex justify-end text-primary text-lg m-6 rounded-lg w-96 h-24 p-2" dir="rtl"></textarea>
        </div>
      </div>
      <label
        class="flex justify-center text-primary m-2 ">_______________________________________________________________________________</label>
      <div class="flex justify-between items-center text-primary text-2xl mb-24 mx-16 ">
        <label>
          عميد كلية الآداب والعلوم الإنسانية
        </label>
        <label>
          رئيس الدائرة
        </label>
        <label>
          رئيس شعبة الامتحانات
        </label>
        <label>
          المدقق
        </label>
        <label>
          المنظم
        </label>
      </div>
      <div class="flex justify-between items-center text-primary text-2xl mb-24 mx-16 ">
        <label>مدير شؤون الطلاب</label>
        <label>
          نائب رئيس الجامعة لشؤون التعليم المفتوح
        </label>
      </div>

    </div>
    <div class=" border-primary border-2 mx-4 mt-6 mb-6" v-if="docType == 'b'">
      <div class="flex  items-center justify-between mb-24 mt-6 mx-6  text-primary text-lg">
        <div class="h-42 w-42">
          <img src="../../assets/Images/al-baath-logo.png" class="h-36 w-36 pt-2 " alt="" />
        </div>
        <div class="m-1 ">
          <label class="flex justify-center items-center mx-auto">الجمهورية العربية السورية</label><br>
          <label class="flex justify-center items-center mx-auto">جامعة البعث
          </label><br>
          <label class="flex justify-center items-center mx-auto">كلية الآداب والعلوم الإنسانية</label>
        </div>
      </div>
      <div class="flex justify-center text-primary text-4xl mb-24">
        بيان وضع
      </div>
      <div class=" mx-auto mt-2">
        <table class="t1 text-primary">
          <tr class="t1 text-primary">
            <td class="t1 bg-body text-primary ">
              {{ student1.mothername }}
            </td>
            <td class="t1 bg-body  text-primary">
              : اسم الأم
            </td>
            <td class="t1 bg-body text-primary">
              {{ student1.fathername }}
            </td>
            <td class="t1 bg-body text-primary">
              : اسم الأب
            </td>
            <td class="t1 bg-body text-primary">
              {{ student1.fullname }}
            </td>

            <td class="t1 bg-body text-primary">
              : اسم الطالب وكنيته
            </td>
          </tr>
          <tr class="t1 text-primary">
            <td class="t1 bg-body text-primary ">
              {{ student1.birthdate }} {{ student1.birthplace }}
            </td>
            <td class="t1 bg-body text-primary ">
              : محل وتاريخ الولادة
            </td>
            <td class="t1 bg-body text-primary">
              {{ student1.nationality }}
            </td>
            <td class="t1 bg-body text-primary">
              : الجنسية

            </td>
            <td class="t1 bg-body text-primary">
              {{ student1.created_at }}
            </td>

            <td class="t1 bg-body text-primary">
              : تاريخ التسحيل
            </td>
          </tr>

        </table>
      </div>
      <label class="flex justify-end text-primary text-2xl mt-24 m-6">
        هو من طلاب كلية الآداب والعلوم الإنسانية برنامج التعليم المفتوح قسم الترجمة رقمه
        الجامعي{{ student1.university_num }} وبناءً عليه أعطي هذه الوثيقة
      </label>
      <div class="flex justify-center text-primary ">____________________________________________________________________
      </div>
      <div class="flex justify-between items-center text-primary text-2xl mt-24 mb-24 mx-16 ">
        <label>
          عميد كلية الآداب والعلوم الإنسانية
        </label>

        <label>
          رئيس شعبة الامتحانات
        </label>
      </div>

    </div>


  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from 'vuex'

import { ref } from '@vue/reactivity'
import { resolveComponent } from "vue";
export default {

  setup() {
    const year1 = ref({})
    const i=0
     const secNum=0
    const year2 = ref({})
    const year3 = ref({})
    const year4 = ref({})
    const seco2 =ref({})
    const sec1 =ref({})
    const data = ref([])
    const section = ref('')
    const docType = ref('')
    const select = (s, d) => { section.value = s; Show.value = d }
    const allcourses = ref([{}]);
    const name = ref('')
    const id = ref('')
    const Show = ref(false)
    const stopreg = ref(false)
    const search = ref('')
    const status = ref('')
    const failed = ref([])
    const ShYear = ref(false)
    const sure = ref(false)
    const sr = () => { sure.value = true }
    const tran = ref(false)
    const trans = () => { tran.value = !tran.value }
    const student1 = ref({
      fullname: '',
      fathername: '',
      mothername: '',
      birthplace: '',
      birthdate: '',
      gender: '',
      place_num_registration: '',
      nationality: '',
      address: '',
      phone: '',
      recruitment_division: '',
      national_num: '',
      homephone: '',
      university_num: '',
      certifeca: '',
      specialization: '',
      created_at: ''
    })
    const suspsen = ref([])

    return {sec1,secNum, i,seco2,failed, data, select, section, docType, Show, id, name, status, search, ShYear, allcourses, sr, sure, stopreg, tran, trans, student1, suspsen, year1, year2, year3, year4 }
  },


  methods: {
    back() {
      this.$router.go(-1)
    },
    looog(vvv,sem,yeer) {
var yeer88=ref({});
if (yeer==1) {
       yeer88=this.year1;
}if (yeer==2) {
   yeer88=this.year2;
}if (yeer==3) {
     yeer88=this.year3;
}if (yeer==4) {
   yeer88=this.year4;
}
      if(sem==2){
        var lon=yeer88.second_semster.length-1;
        if(lon<vvv){
          this.seco2="";
        }
        else{
      this.seco2=yeer88.second_semster.at(vvv);}
    }
      else{
        var lon=this.year1.first_semster.length-1;
        if(lon<vvv){
          this.seco2="";
        }
        else{
      this.seco2=this.year1.first_semster.at(vvv);}
      }
      console.log(vvv);
      console.log(this.seco2);
    },
    initt_i() {
      this.i=0;
    },
    setSems(yeer) {
      var yeer88;
      var lon1=1;
      var lon2=1;
if (yeer==1) {
       yeer88=this.year1;
  lon1=this.year1.first_semster.length;
  lon2=this.year1.second_semster.length;
}if (yeer==2) {
   yeer88=this.year2;
  lon1=this.year2.first_semster.length;
  lon2=this.year2.second_semster.length;
}if (yeer==3) {
     yeer88=this.year3;
    lon1=this.year3.first_semster.length;
  lon2=this.year3.second_semster.length;
}if (yeer==4) {
   yeer88=this.year4;
  lon1=this.year4.first_semster.length;
  lon2=this.year4.second_semster.length;
}else{

}
      if (lon1 >= lon2)
        {
        this.secNum=2;
        this.sec1=yeer88.first_semster;
      }
             else
       {this.secNum=1
      this.sec1=yeer88.second_semster;
    }
    },
    movv_i() {
      this.i=this.i+1;
    },
    async SearchStudent() {
      this.show = true
      try {
        this.$store.commit('Student/SetID', this.id)
        console.log(this.university_num)
        const res = await axios.post("/searchForStudent", {
          university_num: this.university_num,
          specialization: this.spec
        }, { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } })
        console.log(res)
        this.student1 = res.data.data

      }
      catch (e) {
        console.log(e);
      }

      if (this.docType == 'k') {
        try {
          const res = await axios.post('/getMarksStudent', {
            specialization: 'fr',
            university_num: 1007
          }, { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });

          console.log(res)
          this.data = res.data
          for (var y of this.data) {
            if (y.year == 'first') {
              this.year1 = y.detal
            } if (y.year == 'second') {
              this.year2 = y.detal
            }
            if (y.year == 'third') {
              this.year3 = y.detal
            }
            if (y.year == 'forth') {
              this.year4 = y.detal
            }
          }
          console.log(this.year1)

        }
        catch (e) {
          console.log(e);
        }
      }




    }, async getby() {
      try {
        const res = await axios.post('/getMarksByYearStudent', { university_num: this.university_num, specialization: this.spec }, { headers: { 'Authorization': 'Bearer ' + this.$cookies.get('access_token'), 'Access-Control-Allow-Credentials': true } });
        console.log(res);
        this.allC = [];
        const new55 = res.data.cours;
        var u = 0;
        for (var v of new55) {
          this.allC[u] = v;
          u += 1;
        }
        console.log(this.allC);
      }
      catch (e) {
        console.log(e);
      }
    }, suspSelect(s) {
      this.select(s)
      this.loadsusp()
    },



  }, computed: {
    ...mapGetters(["spec", "dept"]),
    // merg1(){
    //   const first={}
    //   for(const f of this.year1.first_semster)

    //   {
    //     const second=f.second
    //     first[second]=first[second]||[]
    //     first[second].push(f)
    //   }
    //   console.log(first)
    //   return first
    // },
    // merg(){
    //  const year=this.year1
    //  const first=year.first_semster
    //  const second=year.second_semster
    //   var newyear=[]
    //   const newyear1=[]
    //   const newyear2=[]
    //   var id=0
    //       var hh={}
    //       for(var e of first){
    //        var type='f'

    //         var r=e
    //         newyear1.push({e})
    //         newyear1[id]=newyear1[id]||[]
    //         id++
    //       }
    //       for(var ew of second){
    //        var type='s'
    //        newyear2[id]=newyear2[id]||[]
    //        var r=ew
    //        newyear2.push({ew})
    //       id++
    //       }

    //       // var le=first.length+second.length-1
    //       // console.log(le)

    //       for(var e of first){
    //         for(var ew of second){
    //        newyear.push({e,ew})
    //        newyear=newyear||[]

    //       //  console.log({e,ew})

    //       id++

    //         }
    //       }
    //       newyear.filter((item,index)=>{newyear.indexOf(item)===index
    //       })



    //       console.log(newyear)
    //       return newyear
    // }
  }
}
</script>

<style>
.t1 {
  border-style: none;
  margin: 0PX;
  padding: 0PX;

}
</style>
