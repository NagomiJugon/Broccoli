<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainningEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainning_events', function (Blueprint $table) {
            $table->id();
            $table->string( 'name' , 128 );
            $table->unsignedBigInteger( 'muscle_category_id' );
            $table->unsignedBigInteger( 'user_id' );
            $table->unsignedTinyInteger( 'cooltime' );
            $table->datetime( 'created_at' )->useCurrent();
            $table->datetime( 'updated_at' )->useCurrent()->userCurrentOnUpdate();
            $table->foreign( 'muscle_category_id' )->references( 'id' )->on( 'muscle_categories' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
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
        Schema::dropIfExists('trainning_events');
    }
}
