<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TrainningEventRegisterPostRequest;
use App\Http\Controllers\ResultController;
use App\Models\MuscleCategory as MuscleCategoryModel;
use App\Models\TrainningEvent as TrainningEventModel;

class TrainningEventController extends Controller
{
    public function index() {
        $list = MuscleCategoryModel::get();
        return view( 'trainning.register' , [ 'list' => $list ] );
    }
    
    public function register( TrainningEventRegisterPostRequest $request ){
        $datum = $request->validated();
        
        $datum[ 'user_id' ] = Auth::id();
        
        try {
            $r = TrainningEventModel::create( $datum );
        } catch ( \Throwable $e ) {
            $request->session()->flash( 'front.trainning_event_register_failure' , true );
            return redirect( route( 'result.record' ) );
        }
        
        $request->session()->flash( 'front.trainning_event_register_success' . true );
        
        return redirect( route( 'result.record' ) );
    }
    
    
    public function list() {
        $list_all = $this->getPaginateListBuilder();
        
        foreach( MuscleCategoryModel::all() as $category ) {
            $list[ 'list_id_'.$category->id ] = $this->getPaginateCategorizedListBuilder( $category->id );
        }
        
        $muscle_categories = MuscleCategoryModel::all();
        
        return view( 'trainning.list' , 
                     [
                        'list' => $list , 
                        'list_all' => $list_all , 
                        'muscle_categories' => $muscle_categories
                     ] 
                   );
    }
    
    
    /**
     * 全部位のトレーニング種目を取得する
     * ページネーション付き
     */
    protected function getPaginateListBuilder() {
        $per_page = 20;
        
        $select_list = [
            'trainning_events.id as trainning_event_id',
            'trainning_events.name as trainning_event_name',
            'muscle_categories.id as muscle_category_id',
            'muscle_categories.name as muscle_category_name',
            'trainning_events.cooltime as cooltime',
        ];
        
        return TrainningEventModel::leftJoin( 'muscle_categories' , 'trainning_events.muscle_category_id' , '=' , 'muscle_categories.id' )
                                  ->select( $select_list )
                                  ->where( 'trainning_events.user_id' , Auth::id() )
                                  ->orderBy( 'muscle_categories.id' )
                                  ->orderBy( 'trainning_events.created_at' , 'DESC' )
                                  ->paginate( $per_page );
    }
    
    
    protected function getPaginateCategorizedListBuilder( $muscle_category_id ) {
        $per_page = 20;
        
        $select_list = [
            'trainning_events.id as trainning_event_id',
            'trainning_events.name as trainning_event_name',
            'muscle_categories.id as muscle_category_id',
            'muscle_categories.name as muscle_category_name',
            'trainning_events.cooltime as cooltime',
        ];
        return TrainningEventModel::leftJoin( 'muscle_categories' , 'trainning_events.muscle_category_id' , '=' , 'muscle_categories.id' )
                                  ->select( $select_list )
                                  ->where( 'trainning_events.user_id' , Auth::id() )
                                  ->where( 'trainning_events.muscle_category_id' , $muscle_category_id )
                                  ->orderBy( 'muscle_categories.id' )
                                  ->orderBy( 'trainning_events.created_at' , 'DESC' )
                                  ->paginate( $per_page );
    }
}
