<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrainningEventController;
use App\Http\Controllers\PresetMenuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get( '/' , [ AuthController::class , 'index' ] )->name( 'front.index' );
Route::post( '/login' , [ AuthController::class , 'login' ] )->name( 'front.login' );
Route::middleware([ 'auth' ])->group( function () {
    Route::get( '/logout' , [ AuthController::class , 'logout' ] )->name( 'front.logout' );
    Route::prefix( '/trainning' )->group( function () {
        Route::get( '/register' , [ TrainningEventController::class , 'register' ] )->name( 'trainning.register' );
        Route::post( '/register/save' , [ TrainningEventController::class , 'registerSave' ] )->name( 'trainning.register.save' );
        Route::get( '/list' , [ TrainningEventController::class , 'list' ] )->name( 'trainning.list' );
        Route::get( '/edit' , [ TrainningEventController::class , 'edit' ] )->name( 'trainning.edit' );
        Route::post( '/edit/save' , [ TrainningEventController::class , 'editSave' ] )->name( 'trainning.edit.save' );
        Route::get( '/delete' , [ TrainningEventController::class , 'delete' ] )->name( 'trainning.delete' );
        Route::post( '/delete/save' , [ TrainningEventController::class , 'deleteSave' ] )->name( 'trainning.delete.save' );
    });
    Route::prefix( '/result' )->group( function () {
        Route::get( '/record' , [ ResultController::class , 'record' ] )->name( 'result.record' );
        Route::post( '/register' , [ ResultController::class , 'register' ] )->name( 'result.register' );
        Route::get( '/list' , [ ResultController::class , 'list' ] )->name( 'result.list' );
        Route::get( '/edit' , [ ResultController::class , 'edit' ] )->name( 'result.edit' );
        Route::post( '/edit/save' , [ ResultController::class, 'editSave' ] )->name( 'result.edit.save' );
        Route::get( '/delete' , [ ResultController::class , 'delete' ] )->name( 'result.delete' );
        Route::post( '/delete/save' , [ ResultController::class , 'deleteSave' ] )->name( 'result.delete.save' );
    });
    Route::prefix( '/preset_menu' )->group( function () {
        Route::get( '/register' ,[ PresetMenuController::class , 'register' ] )->name( 'preset_menu.register' );
        Route::post( '/register/save' , [ PresetMenuController::class , 'registerSave' ] )->name( 'preset_menu.register.save' );
    });
    Route::prefix( '/user' )->group( function () {
        Route::get( '/table_init_trainning_event' , [ UserController::class , 'exeInitTrainningEvent' ] );
    });
});

Route::prefix( '/user' )->group( function() {
   Route::get( '/index' , [ UserController::class , 'index' ] )->name( 'user.index' );
   Route::post( '/register' , [ UserController::class , 'register' ] )->name( 'user.register' );
});
