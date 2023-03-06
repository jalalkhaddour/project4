<template>
    <div class="mp">
        <div class=" w-full text-4xl  font-light  text-white   h-12 bg-primary flex p-2 justify-between items-center"
             style="text-align:center">
            <div>
                <img src="../assets/Images/arrow-left-circle.png" class="m-4 h-12  left-2 cursor-pointer " @click="back"
                     alt="">
            </div>
            <div>
                السجل العام &nbsp;&nbsp;
            </div>
        </div>

        <div class="filter flex  space-x-6 text-xl m-4 text-primary justify-center items-center">

            <div class="space-x-2">
                <select v-if="spec=='fr'" name="cert" class="h-10 cursor-pointer rounded-lg" v-model="cert">
                    <option value="all">الجميع</option>
                    <option value="bac">بكلوريا</option>
                    <option value="col"> كلية/ معهد</option>
                    <option value="instf">معهد فرنسي</option>
                    <option value="pe">عام فرنسي</option>

                </select>

                <select v-if="spec=='en'" name="cert" class="h-10 cursor-pointer rounded-lg" v-model="cert">
                    <option value="all">الجميع</option>
                    <option value="bac">بكلوريا</option>
                    <option value="col"> كلية/ معهد</option>
                    <option value="inst">معهد انكليزي</option>
                    <option value="pf">عام انكليزي</option>


                </select>

                <label>
                    : الشهادة&nbsp;
                </label>

            </div>
            <div class="space-x-2">

                <select name="year" class="h-10 cursor-pointer rounded-lg" v-model="year">

                    <option value="all">الكل</option>
                    <option value="first">الأولى</option>
                    <option value="second">الثانية</option>
                    <option value="third">الثالثة</option>
                    <option value="forth">الرابعة</option>
                </select>
                <label>
                    :السنة&nbsp;
                </label>


            </div>
            <div>
                <button class="bg-primary text-body text-xl rounded-lg text-center m-5 py-1 px-2  h-10 hover:bg-hovercolor"
                        @click="getStudents">عرض
                </button>
            </div>
           
        </div>
        <table class=" text-primary bg-white-100 text-lg">
            <thead>
            <th>الشهادة</th>
            <th>التخصص</th>
            <th>الجنس</th>
            <th>السنة الدراسية</th>
            <th>رقم الجوال</th>
            <th>شعبة التجنيد</th>
            <th>الجنسية</th>
            <th>العنوان</th>
            <th>الهاتف الأرضي</th>
            <th>الرقم الوطني</th>
            <th>محل ورقم القيد</th>
            <th>مكان الولادة</th>
            <th> تاريخ الولادة</th>
            <th>الرقم الجامعي</th>
            <th>اسم الأم</th>
            <th>اسم الأب</th>
            <th>الاسم</th>

            </thead>

            <tbody v-for="student in students" :key="student">

            <tr>

                <td>{{student.certifeca}}</td>
                <td>{{student.specialization}}</td>
                <td>{{student.gender}}</td>
                <td>{{student.created_at}}</td>
                <td>{{student.phone}}</td>
                <td>{{student.recruitment_division}}</td>
                <td>{{student.nationality}}</td>
                <td>{{student.address}}</td>
                <td>{{student.homephone}}</td>
                <td>{{student.national_num}}</td>
                <td>{{student.place_num_registration}}</td>
                <td>{{student.birthplace}}</td>
                <td>{{student.birthdate}}</td>
                <td>{{student.university_num}}</td>
                <td>{{student.mothername}}</td>
                <td>{{student.fathername}}</td>
                <td>{{student.fullname}}</td>

            </tr>

            </tbody>
        </table>
        <div style="width:100%;display: flex;flex-direction: row;align-items: center;justify-content: center ">
            <button class="bg-primary text-body text-xl rounded-lg text-center m-5 py-1 px-2  h-10 hover:bg-hovercolor"
                    @click="pageIncrease()">التالي
            </button>
            <button class="bg-primary text-body text-xl rounded-lg text-center m-5 py-1 px-2  h-10 hover:bg-hovercolor"
                    @click="pageDecrease()">السابق
            </button>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import axios from "axios";
    import {ref} from '@vue/reactivity'
    import {inject} from 'vue';

    axios.defaults.baseURL = "http://localhost/olearning/public/api";
    var page = 1;
    export default {

        setup() {

            const cookies = inject('cookies');
            return {cookies}

        },
        data() {
            return {
                cert: "all",
                year: "all",
                students: [],
            }
        },
        components: {},

        methods: {
            pageIncrease() {
                page = page + 1
                console.log(page)
                this.getStudents()

            },
            pageDecrease() {
                page = page - 1
                this.getStudents()
            },
            back() {
                this.$router.go(-1)
            }, async getStudents() {
                try {
                    console.log(this.spec)
                    const res = await axios.post('getStudents', {
                        specialization: this.spec,
                        year: this.year,
                        certifeca: this.cert,
                        page: page
                    }, {
                        headers: {
                            'Authorization': 'Bearer ' + this.$cookies.get('access_token'),
                            'Access-Control-Allow-Credentials': true
                        }
                    });

                    console.log(res)
                    this.students = res.data.data
                    for (var student of this.students){
                        switch(student.certifeca){
                          case 'bac':
                            student.certifeca="بكلوريا";
                            break;
                          case 'out_col':
                             student.certifeca="مستنفذ ومنقول";
                            break;
                          case 'col':
                             student.certifeca="شهادة جامعية";
                            break;
                          case 'inst_en':
                             student.certifeca="معهد إنكليزي";
                            break;   
                        }
                        switch(student.specialization){
                              case 'fr':
                                student.specialization="فرنسي";
                                break;
                              case 'en':
                                student.specialization="إنكليزي";
                                break;
                            }
                            switch(student.gender){
                              case 'male':
                                student.gender="ذكر";
                                break;
                               case 'female':
                                student.gender="أنثى";
                                break; 
                            }
                    }
                } catch (e) {
                    console.log(e);
                }

            },


        }, computed: {
            ...mapGetters(["spec"]),
  
        }


    }
</script>
<style>
    table {
        border: 2px solid #626262;
        border-radius: 2px;
        margin: 20px auto;
        width: 98%


    }

    .mp {
        resize: none;
    }

    th {
        border: 2px solid #626262;
        border-radius: 2px;
        border-collapse: collapse;
        color: white;
        border: 2px solid #000000;
    }

    td {
        color: black;
        background-color: white;
        border: 2px solid #000000;
        border-radius: 2px;
        text-align: center;
    }

</style>
