<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punishments', function (Blueprint $table) {
            $table->id();
            $table->string('reason',500);
            $table->string('type',55)->nullable()->default(false);
            $table->boolean('IsOut')->nullable()->default(false);
            $table->integer('seasons_period')->nullable();
            $table->foreignId('student_id')
                ->constrained('students','id')
                ->onUpdate('no action')
                ->onDelete('cascade');
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
        Schema::dropIfExists('punishments');
    }
}
