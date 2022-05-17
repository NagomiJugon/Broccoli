<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger( 'user_id' );
            $table->unsignedBigInteger( 'trainning_event_id' );
            $table->datetime( 'created_at' )->useCurrent();
            $table->datetime( 'updated_at' )->useCurrent()->userCurrentOnUpdate();
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
            $table->foreign( 'trainning_event_id' )->references( 'id' )->on( 'trainning_events');
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
        Schema::dropIfExists('results');
    }
}
