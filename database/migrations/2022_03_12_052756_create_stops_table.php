<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stops', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('stop_year')->nullable()->default(null);
            $table->text('reason')->nullable()->default(null);
            $table->string('new_university', 150);
            $table->string('personal_id_source', 150)->nullable()->default(null);
            $table->date('personal_id_date')->nullable()->default(null);
            $table->foreignId('student_id')
                ->constrained('students','id')
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
        Schema::dropIfExists('stops');
    }
}
