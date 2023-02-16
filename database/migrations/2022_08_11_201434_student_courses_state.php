<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentCoursesState extends Migration
{
    public function up(){
Schema::create('student_courses_state', function (Blueprint $table) {
    $table->id();

    $table->foreignId('relation_id')
        ->constrained('student_courses','id')
        ->onUpdate('no action')
        ->onDelete('cascade');
    $table->string('state', 45)->nullable();
    $table->integer('Mark')->nullable()->default('0');
    $table->integer('NumOfFails')->nullable()->default('0');
    $table->date('last_exam_date')->nullable();
    $table->string('Examsemster')->nullable();
    $table->string('study_year', 45);
    $table->boolean('HaveNow')->default(false);
    $table->boolean('issimilar')->default(false);
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
    Schema::dropIfExists('student_courses_state');
}
}
