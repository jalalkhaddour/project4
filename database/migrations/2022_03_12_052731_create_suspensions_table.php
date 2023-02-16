<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuspensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspensions', function (Blueprint $table) {
            $table->id();
            $table->enum('suspension_year', ['first', 'second', 'third', 'forth']);
            $table->enum('suspension_semester', ['first', 'second']);
            $table->integer('reg_receipt_num')->comment('ÑÞã ÇíÕÇá ÇáÊÓÌíá');
            $table->date('reg_receipt_date');
            $table->foreignId('student_id')
                ->constrained('students','id')
                ->onUpdate('no action')
                ->onDelete('no action');
            $table->enum('counter', ['1', '2', '3', '4'])->nullable()->default(null);
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
        Schema::dropIfExists('suspensions');
    }
}
