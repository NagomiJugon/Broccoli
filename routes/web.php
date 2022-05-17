<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrainningEventController;

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
Route::post( '/login' , [ AuthController::class , 'login' ] );
Route::middleware([ 'auth' ])->group( function () {
    Route::prefix( '/trainning' )->group( function () {
        Route::get( '/record' , [ MenuController::class , 'record' ] );
        Route::get( '/register/index' , [ TrainningEventController::class , 'index' ] );
        Route::get( '/register' , [ TrainningEventController::class , 'register' ] );
    });
    Route::prefix( '/result' )->group( function () {
       Route::get( '/register' , [ MenuController::class , 'register' ] );
       Route::get( '/list' , [ MenuController::class , 'list' ] );
       Route::get( '/edit/' , [ MenuController::class , 'edit' ] );
       Route::get( '/edit/save' , [ MenuController::class. 'editSave' ] );
    });
    Route::prefix( '/user' )->group( function () {
        Route::get( '/table_init_trainning_event' , [ UserController::class , 'exeInitTrainningEvent' ] );
    });
});

Route::prefix( '/user' )->group( function() {
   Route::get( '/index' , [ UserController::class , 'index' ] );
   Route::post( '/register' , [ UserController::class , 'register' ] );
});
