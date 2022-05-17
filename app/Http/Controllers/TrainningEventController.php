<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TrainningEventRegisterGetRequest;
use App\Models\MuscleCategory as MuscleCategoryModel;
use App\Models\TrainningEvent as TrainningEventModel;

class TrainningEventController extends Controller
{
    public function index() {
        $list = MuscleCategoryModel::get();
        return view( 'menu.register' , [ 'list' => $list ] );
    }
    
    public function register( TrainningEventRegisterGetRequest $request ){
        $datum = $request->validated();
        
        $datum[ 'user_id' ] = Auth::id();
        
        try {
            $r = TrainningEventModel::create( $datum );
        } catch ( \Throwable $e ) {
            $request->session()->flash( 'front.trainning_event_register_failure' , true );
            return redirect( '/trainning/record');
        }
        
        $request->session()->flash( 'front.trainning_event_register_success' . true );
        
        return redirect( '/trainning/record' );
    }
}
