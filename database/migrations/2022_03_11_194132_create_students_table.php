<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('fullname',50);
            $table->string('fathername',25);
            $table->string('mothername',25);
            $table->string('birthplace', 45);
            $table->date('birthdate');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('place_num_registration', 100)->nullable()->default(null)->comment('مكان ورقم القيد');
            $table->string('nationality', 45)->nullable()->default('syrian');
            $table->string('address', 75)->nullable()->default(null);
            $table->string('phone', 15)->nullable()->default(null);
            $table->string('recruitment_division', 150)->nullable()->default(null)->comment('شعبة التجنيد');
            $table->string('national_num', 45)->comment('الرقم الوطني');
            $table->string('homephone', 45)->nullable()->default(null);
            $table->biginteger('university_num')->nullable(false)->default(16808);
            $table->enum('certifeca', ['bac', 'inst', 'col']);
            $table->enum('specialization', ['en', 'fr'])->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
