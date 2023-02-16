<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_in_exams', function (Blueprint $table) {
            $table->id();
            $table->string('semster', 25)->nullable();
            $table->date('date')->nullable();
            $table->boolean('state')->default(false);
            $table->string('study_year');
            $table->integer('Mark')->default(0);
            $table->foreignId('course_id')
                ->constrained('student_courses','id')
                ->onUpdate('no action')
                ->onDelete('no action');
            $table->foreignId('student_id')
                ->constrained('student_courses','id')
                ->onUpdate('no action')
                ->onDelete('no action');
            $table->foreignId('class_id')
                ->constrained('exam_classes','id')
                ->onUpdate('no action')
                ->onDelete('no action');
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
        Schema::dropIfExists('student_in_exams');
    }
}
