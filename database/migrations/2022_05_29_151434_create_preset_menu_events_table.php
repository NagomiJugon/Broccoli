<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresetMenuEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preset_menu_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger( 'preset_menu_id' );
            $table->unsignedBigInteger( 'trainning_event_id' );
            $table->float( 'weight' );
            $table->datetime( 'created_at' )->useCurrent();
            $table->datetime( 'updated_at' )->useCurrent()->userCurrentOnUpdate();
            $table->foreign( 'preset_menu_id' )->references( 'id' )->on( 'preset_menus' );
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
        Schema::dropIfExists('preset_menu_events');
    }
}
