<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 16);
            $table->string('password', 400);
            $table->rememberToken();
            $table->string('fname', 25)->nullable(false);
            $table->string('lname', 25)->nullable(false);
            $table->foreignId('roleID')
                ->constrained('roles', 'id')
                ->onUpdate('no action')
                ->onDelete('cascade');
            $table->boolean('IsActive');
            $table->unique(["id"], 'userID_UNIQUE');
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
        Schema::dropIfExists('users');
    }
}
