<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainningSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainning_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger( 'weight' );
            $table->unsignedTinyInteger( 'reps' );
            $table->unsignedBigInteger( 'result_id' );
            $table->datetime( 'created_at' )->useCurrent();
            $table->datetime( 'updated_at' )->useCurrent()->userCurrentOnUpdate();
            $table->foreign( 'result_id' )->references( 'id' )->on( 'results' );
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
        Schema::dropIfExists('trainning_sets');
    }
}
