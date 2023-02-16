<template>
<div>
      <table>
         
 <thead>
    
     
     <th class="bg-primary text-white text-lg">محذوف</th>
     <th class="bg-primary text-white text-lg">مكافئ</th>
      <th class="bg-primary text-white text-lg" > المقرر</th>

 </thead>
 <tbody v-if="cert=='inst_en' && sec=='en'">
  <tr>
   <td><input type="checkbox"  :disabled=true :checked=false   value="112"/></td>
   <td> 2قراءة سنة1+سنة</td>
   <td>القراءة و الاستيعاب</td>
  </tr>
  <tr>
   <td><input type="checkbox"  :disabled=true :checked=false   value="116"/></td>
   <td>  لغة العربية سنة 1  </td>
   <td>اللغة العربية 1

   </td>
  </tr>
<tr>
   <td><input type="checkbox"  :disabled=true :checked=false  value="122"/></td>
   <td>  استماع و محادثة سنة1 + سنة2</td>
   <td>قراءة و استيعاب 2 </td>
</tr>
<tr>
   <td><input type="checkbox"  :disabled=true :checked=false   value="216"/></td>
   <td>  لغة عربية سنة 2 </td>
   <td>اللغةالعربية 2  </td>
</tr>
<tr>
   <td><input type="checkbox" :disabled=true :checked=false   value="211"></td>
   <td>  
                 قواعد سنة1 + سنة2
   </td>
            <td> 
    القواعد
   </td>
</tr>
<tr>
   <td><input type="checkbox"  :disabled=true :checked=false   value="225"></td>
   <td>  مدخل إلى علم الترجمة </td>
   <td>ترجمة سنة1 + سنة2</td>
</tr>
  

 </tbody>
 
    <tbody v-if="cert=='col' && sec=='en'">

  <tr>
   <td><input type="checkbox" :disabled=true :checked=false   value="116"></td>
   <td> لغة عربية1 +  لغة العربية 2 </td>
   <td>اللغة العربية  </td>
  </tr>
 </tbody>
  <tbody v-if="cert=='out_col' && sec=='en'" >
    <tr>
   <td><input type="checkbox"  :disabled=true :checked=false  value="111"/></td>
   <td>       قواعد و صوتيات 1 + اللغة1
</td>
   <td>1 القواعد
      </td>
</tr>
    <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="114"/></td>
   <td> 1 إنشاء1 + تعبير و استيعاب</td>
   <td> 
     كتابة 1
   </td>
  </tr>

<tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="115"/></td>
   <td>  
ترجمة 1
   </td>
   <td>
        الترجمة العامة 1
   </td>
</tr>

    <tr>
   <td><input type="checkbox"  :disabled=true :checked=false  value="116"/></td>
   <td>   اللغة العربية   </td>
   <td>اللغة العربية 1

   </td>
  </tr>


    <tr>
   <td><input type="checkbox"  :disabled=true :checked=false  value="121"/></td>
   <td>اللغة2 + قواعد و صوتيات 2 </td>
   <td>القواعد 2</td>
  </tr>
  

      <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="114"/></td>
   <td> 2 إنشاء2 + تعبير و استيعاب</td>
   <td> 
     كتابة 2
   </td>
  </tr>
<tr>
   <td><input type="checkbox"  :disabled=true  :checked=false  value="124"/></td>
   <td>  
ترجمة 2
   </td>
   <td>
        الترجمة العامة 2
   </td>
</tr>
    <tr>
   <td><input type="checkbox"  :disabled=true :checked=false  value="211"/></td>
   <td>      قواعد و صوتيات 3 + اللغة 3
 
       </td>
   <td>       3 القواعد

      </td>
</tr>
     <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="212"/></td>
   <td> 3 إنشاء3 + تعبير و استيعاب</td>
   <td> 
     كتابة 3
   </td>
  </tr>
  <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="215"/></td>
   <td>  
ترجمة 3
   </td>
   <td>
        الترجمة العامة 3
   </td>
</tr>

    <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="221"/></td>
   <td>      قواعد و صوتيات 4 + اللغة 4

       </td>
   <td>       4 القواعد

      </td>
</tr>
  <tr>
   <td><input type="checkbox" :disabled=true  value="215"/></td>
   <td>  
ترجمة 4
   </td>
   <td>
        الترجمة العامة 4
   </td>
</tr>
    <tr>
   <td><input type="checkbox" :disabled=true  value="311"/></td>
   <td> 
علم اللغة 1
   </td>
   <td>
    
        (التراكيب و الدلالة) علم اللغة 

   </td>
</tr>
 </tbody>
<tbody  v-if="cert=='inst_fr' && sec=='fr'" >
    <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="111"/></td>
   <td>
محادثة
        </td>
   <td> 
       الاستيعاب و التعبير الشفهي 1    
   </td>
  </tr>


   <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="113"/></td>
   <td>
تعبير كتابي 1
        </td>
   <td> 
        التعبير الكتابي
   </td>
  </tr>
 
 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="113"/></td>
   <td>
قواعد        </td>
   <td> 
قواعد اللغة الفرنسية 1   </td>
  </tr>
  

   <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="116"/></td>
   <td>
اللغةالعربية        </td>
   <td> 
 اللغة العربية -النحو و الصرف   </td>
  </tr>

   <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="123"/></td>
   <td>
علم الصوتيات        </td>
   <td> 
  الصوتيات</td>
  </tr>

   <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="225"/></td>
   <td>
 نصوص        </td>
   <td> 
  تحليل نصوص فرنسية</td>
  </tr>
</tbody>

<tbody  v-if="cert=='col' && sec=='fr'" >
      <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="116"/></td>
   <td>
اللغة العربية        </td>
   <td> 
 اللغة العربية -النحو و الصرف   </td>
  </tr>
</tbody>



<tbody  v-if="cert=='out_col' && sec=='fr'" >
       <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="111"/></td>
   <td>
استيعاب شفهي 1        </td>
   <td> 
       الاستيعاب و التعبير الشفهي 1    
   </td>
  </tr>


   <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="113"/></td>
   <td>
تعبير كتابي 1
        </td>
   <td> 
        التعبير الكتابي
   </td>
  </tr>

 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="113"/></td>
   <td>
 1 قواعد        </td>
   <td> 
قواعد اللغة الفرنسية 1   </td>
  </tr>

 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="115"/></td>
   <td>
 1 ترجمة        </td>
   <td> 
الترجمة إلى اللغة العربية 1 </td>
  </tr>

      <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="116"/></td>
   <td>
اللغةالعربية        </td>
   <td> 
 اللغة العربية -النحو و الصرف   </td>
  </tr>

       <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="121"/></td>
   <td>
محادثة
        </td>
   <td> 
       الاستيعاب و التعبير الشفهي 2    
   </td>
  </tr>

     <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="122"/></td>
   <td>
تعبير كتابي 2
        </td>
   <td> 
       الاستيعاب و التعبير الكتابي 1    
   </td>
  </tr>

 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="124"/></td>
   <td>
 2 قواعد        </td>
   <td> 
قواعد اللغة الفرنسية 2   </td>
  </tr>

 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="125"/></td>
   <td>
 2 ترجمة        </td>
   <td> 
الترجمة إلى اللغة العربية 2 </td>
  </tr>

 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="213"/></td>
   <td>
 3 ترجمة        </td>
   <td> 
الترجمة من اللغة العربية و إليها 1 </td>
  </tr>

 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="214"/></td>
   <td>
 3 قواعد        </td>
   <td> 
قواعد اللغة الفرنسية 3   </td>
  </tr>

     <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="221"/></td>
   <td>
تعبير كتابي 4
        </td>
   <td> 
       الاستيعاب و التعبير الكتابي 2    
   </td>
  </tr>

       <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="222"/></td>
   <td>
      ترجمة 4
        </td>
   <td> 
  الحضارة الأوروبية
   </td>
  </tr>
 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="224"/></td>
   <td>
 4 قواعد        </td>
   <td> 
قواعد اللغة الفرنسية 4   </td>
  </tr>

 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="225"/></td>
   <td>
 3 قواعد        </td>
   <td> 
   دراسة نصوص 4</td>
  </tr>

 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="226"/></td>
   <td>
   لغة أجنبية   
       </td>
   <td> 
 اللغة الإنكليزية 2   </td>
  </tr>


 <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="312"/></td>
   <td>
 الحضارة و الفكر 1         </td>
   <td> 
   ترجمة نصوص سياحية 1   </td>
  </tr>

   <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="313"/></td>
   <td>
   ترجمة 5         </td>
   <td> 
   ترجمة نصوص اقتصادية و تجارية 1   </td>
  </tr>

   <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="311"/></td>
   <td>
 الحضارة و الفكر 2         </td>
   <td> 
   ترجمة نصوص سياحية 2   </td>
  </tr>

   <tr>
   <td><input type="checkbox" :disabled=true :checked=false  value="323"/></td>
   <td>
    6 ترجمة </td>
   <td> 
   ترجمة نصوص إعلامية    </td>
  </tr>
  </tbody>
  </table>
  </div>
</template>

<style>
table{
    border: 2px solid #363636;
    border-radius: 2px;
    border-collapse: collapse;
    margin:  20px auto;
    width:100%
   

}
th{
    border: 2px solid #000000;
    border-radius: 2px;
    border-collapse: collapse;
    background-color: #626262;
    
}
td{
    color: black;
    background-color: white;
    border: 2px solid black;
    border-radius: 2px;
    text-align: center;
    font-size: 20px;
   
}
</style>
<script>
import axios from "axios";
axios.defaults.baseURL="http://localhost:8080/olearning/public/api";
export default{
    // eslint-disable-next-line vue/multi-word-component-names
    name:'EquSubjects',
    props:['sec','cert']

}
</script>