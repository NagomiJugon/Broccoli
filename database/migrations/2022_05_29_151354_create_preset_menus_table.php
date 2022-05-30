<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresetMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preset_menus', function (Blueprint $table) {
            $table->id();
            $table->string( 'name' , 128 );
            $table->unsignedBigInteger( 'user_id' );
            $table->unsignedBigInteger( 'muscle_category_id' );
            $table->datetime( 'created_at' )->useCurrent();
            $table->datetime( 'updated_at' )->useCurrent()->userCurrentOnUpdate();
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
            $table->foreign( 'muscle_category_id' )->references( 'id' )->on( 'muscle_categories' );
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
        Schema::dropIfExists('preset_menus');
    }
}
