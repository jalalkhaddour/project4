<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userID')
                ->constrained('users', 'id')
                ->onUpdate('no action')
                ->onDelete('cascade');
            $table->foreignId('permissionID')
                ->constrained('permissions', 'id')
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
        //
    }
}
