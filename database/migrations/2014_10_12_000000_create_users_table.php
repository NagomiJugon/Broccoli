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
            $table->string( 'name' , 128 );
            $table->string( 'email' , 191 )->unique();
            $table->datetime( 'email_verified_at' )->nullable();
            $table->string( 'password' , 191 );
            $table->rememberToken();
            $table->datetime( 'created_at' )->useCurrent();
            $table->datetime( 'updated_at' )->useCurrent()->userCurrentOnUpdate();
            $table->collation = 'utf8mb4_bin';
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
