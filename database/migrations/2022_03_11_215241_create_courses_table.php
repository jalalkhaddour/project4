<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('course_code');
            $table->enum('year_of_course', ['first', 'second', 'third', 'forth']);
            $table->enum('semester', ['first', 'second']);
            $table->enum('specialization', ['en', 'fr'])->nullable()->default(null);
            $table->boolean('IsActive')->default(true);

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
        Schema::dropIfExists('courses');
    }
}
