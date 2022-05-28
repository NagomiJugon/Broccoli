<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ResultRegisterPostRequest;
use App\Models\TrainningEvent as TrainningEventModel;
use App\Models\Result as ResultModel;
use App\Models\TrainningSet as TrainningSetModel;
use App\Models\MuscleCategory as MuscleCategoryModel;

class ResultController extends Controller
{
    public function record() {
        $list_all = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        
        foreach( MuscleCategoryModel::all() as $category ) {
            $list[ 'list_id_'.$category->id ] = $this->getMuscleCategoryListBuilder( $category->id )->get();
        }
        return view( 'result.record' , [ 'list' => $list , 'list_all' => $list_all ] );
    }
    
    
    public function register( ResultRegisterPostRequest $request ) {
        $datum = $request->validated();
        
        try{
            // トレーニング実績の登録
            $r_result = ResultModel::create([
               'user_id' => Auth::id(),
               'trainning_event_id' => $datum[ 'trainning_event_id' ],
            ]);
            
            // セット内容の登録
            for( $i = 1 ; $i < 6 ; $i++ ) {
                if ( $datum[ 'weight'.$i ] !== "" ) {
                    $r_set = TrainningSetModel::create([
                        'weight' => $datum[ 'weight'.$i ],
                        'reps' => $datum[ 'reps'.$i ],
                        'result_id' => $r_result->id,
                    ]);
                }
            }
        } catch ( \Throwable $e ) {
            $request->session()->flash( 'front.trainning_result_register_failure' , true );
            echo $e->getMessage();
            exit;
            return redirect( route( 'result.record' ) );
        }
        
        $request->session()->flash( 'front.trainning_result_register_success' , true );
        
        return redirect( route( 'result.record' ) );
    }
    
    
    public function list() {
        $list_all = $this->getPaginateListBuilder();
        
        foreach( MuscleCategoryModel::all() as $category ) {
            $list[ 'list_id_'.$category->id ] = $this->getPaginateCategorizedListBuilder( $category->id );
        }
        
        $muscle_categories = MuscleCategoryModel::all();
        
        return view( 'result.list' , [ 'list' => $list , 'list_all' => $list_all , 'muscle_categories' => $muscle_categories ] );
    }
    
    
    public function edit( Request $request ) {
        $d = $request->input();
        $muscle_category_id = $d[ 'muscle_category_id' ];
        
        $list_trainning_event = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        
        $list_all = $this->getPaginateListBuilder();
        
        foreach( MuscleCategoryModel::all() as $category ) {
            $list[ 'list_id_'.$category->id ] = $this->getPaginateCategorizedListBuilder( $category->id );
        }
        
        $muscle_categories = MuscleCategoryModel::all();
        
        return view( 'result.edit2' , [ 'list' => $list , 
                                        'list_all' => $list_all ,
                                        'list_trainning_event' => $list_trainning_event ,
                                        'muscle_categories' => $muscle_categories ,
                                        'muscle_category_id' => $muscle_category_id ] );
    }
    /*
    public function edit) {
        $list_trainning_event = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        $list_result = $this->getPaginateListBuilder();
        return view( 'result.edit' , [ 'list_trainning_event' => $list_trainning_event , 'list_result' => $list_result ] );
    }
    */
    
    public function editSave( Request $request ) {
        $data = $request->input();
        try {
            foreach ( $data as $key => $value ) {
                if ( preg_match( '/^trainning_set_id/' , $key ) !== 0 ) {
                    $id = $value;
                    $result = ResultModel::find( $data[ 'result'.$id ] );
                    $result->trainning_event_id = $data[ 'trainning_event_id'.$id ];
                    $result->save();
                    $trainning_set = TrainningSetModel::find( $data[ 'trainning_set_id'.$id ] );
                    $trainning_set->weight = $data[ 'weight'.$id ];
                    $trainning_set->reps = $data[ 'reps'.$id ];
                    $trainning_set->created_at = str_replace( "T" , " " , $data[ 'timestamp'.$id ] );
                    $trainning_set->save();
                }
            }
        } catch ( \Throwable $e ) {
            echo $e->getMessage();
            exit;
            $request->session()->flash( 'front.result_edit_save_failure' , true );
            return redirect( route( 'result.list' ) );
        }
        
        $request->session()->flash( 'front.result_edit_save_seccess' , true );
        
        return redirect( route( 'result.list' ) );
    }
    
    
    public function delete() {
        $list = $this->getPaginateListBuilder();
        return view( 'result.delete' , [ 'list' => $list ] );
    }
    
    
    public function deleteSave( Request $request ) {
        $data = $request->input();
        try {
            // trainning_setsレコードが存在しないresultsレコードが発生しうるのでどこかのタイミングでcount=0のresultsレコードを削除する
            foreach ( $data as $key => $value ) {
                if ( preg_match( '/^trainning_set_id/' , $key ) !== 0 ) {
                    $id = $value;
                    $trainning_set = TrainningSetModel::find( $id );
                    $trainning_set->delete();
                }
            }
        } catch ( \Throwable $e ) {
            echo $e->getMessage();
            exit;
            $request->session()->flash( 'front.result_delete_save_failure' , true );
            return redirect( route( 'result.list' ) );
        }
        
        $request->session()->flash( 'front.result_delete_save_seccess' , true );
        
        return redirect( route( 'result.list' ) );
    }
    
    
    protected function getListBuilder() {
        $select_list = [
            'results.id as result_id',
            'trainning_events.id as trainning_event_id',
            'trainning_events.name as trainning_events_name',
            'trainning_sets.id as trainning_set_id',
            'trainning_sets.created_at as trainning_set_datetime',
            'trainning_sets.weight as trainning_weight',
            'trainning_sets.reps as trainning_reps',
        ];
        return TrainningSetModel::leftJoin( 'results' , 'results.id' , '=' , 'trainning_sets.result_id' )
                                ->Join( 'trainning_events' , 'results.trainning_event_id' , '=' , 'trainning_events.id' )
                                ->select( $select_list )
                                ->where( 'results.user_id' , Auth::id() )
                                ->orderBy( 'trainning_sets.created_at' ,'DESC' )
                                ->orderBy( 'trainning_events.muscle_category_id' )
                                ->orderBy( 'trainning_sets.id' );
    }
    
    
    protected function getCategorizedListBuilder( $muscle_category_id ) {
        $select_list = [
            'results.id as result_id',
            'trainning_events.id as trainning_event_id',
            'trainning_events.name as trainning_events_name',
            'trainning_events.muscle_category_id',
            'trainning_sets.id as trainning_set_id',
            'trainning_sets.created_at as trainning_set_datetime',
            'trainning_sets.weight as trainning_weight',
            'trainning_sets.reps as trainning_reps',
        ];
        return TrainningSetModel::leftJoin( 'results' , 'results.id' , '=' , 'trainning_sets.result_id' )
                                ->Join( 'trainning_events' , 'results.trainning_event_id' , '=' , 'trainning_events.id' )
                                ->select( $select_list )
                                ->where( 'results.user_id' , Auth::id() )
                                ->where( 'trainning_events.muscle_category_id' , $muscle_category_id )
                                ->orderBy( 'trainning_sets.created_at' ,'DESC' )
                                ->orderBy( 'trainning_events.muscle_category_id' )
                                ->orderBy( 'trainning_sets.id' );
    }
    
    
    public function getPaginateListBuilder() {
        $per_page = 10; // ユーザー設定で変更できるようにする or 日付ごとで分割
        return $this->getListBuilder()->paginate( $per_page );
    }
    
    
    public function getPaginateCategorizedListBuilder( $muscle_category_id ) {
        $per_page = 10;
        return $this->getCategorizedListBuilder( $muscle_category_id )->paginate( $per_page );
    }
    
    
    public function getMuscleCategoryListBuilder( $muscle_category_id ) {
        $select_list = [
            'trainning_events.id as trainning_event_id',
            'trainning_events.name as trainning_event_name',
            'muscle_categories.name as muscle_categories_name',
        ];
        return TrainningEventModel::leftJoin( 'muscle_categories' , 'muscle_categories.id' , '=' , 'trainning_events.muscle_category_id' )
                                  ->select( $select_list )
                                  ->where( 'user_id' , Auth::id() )
                                  ->where( 'muscle_category_id' , $muscle_category_id );
    }
}
