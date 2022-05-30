<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ResultRegisterPostRequest;
use App\Models\TrainningEvent as TrainningEventModel;
use App\Models\Result as ResultModel;
use App\Models\MuscleCategory as MuscleCategoryModel;

class ResultController extends Controller
{
    public function record() {
        $list_all = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        
        foreach( MuscleCategoryModel::all() as $category ) {
            $list[ 'list_id_'.$category->id ] = $this->getMuscleCategoryListBuilder( $category->id )->get();
        }
        
        return view( 'result.record' , [ 'list' => $list , 
                                         'list_all' => $list_all ,] );
    }
    
    
    public function register( Request $request ) {
        $datum = $request->input();
        
        $muscle_category_id = $datum[ 'selected_category' ];
        
        try {
            // 登録したレコード数記録用
            $created = 0;
            for( $i = 1 ; $i < 6 ; $i++ ) {
                if ( $datum[ 'reps'.$i ] !== "" ) {
                    $r = ResultModel::create([
                        'user_id' => Auth::id(),
                        'trainning_event_id' => $datum[ 'trainning_event_id'.$muscle_category_id ],
                        'weight' => $datum[ 'weight'.$i ],
                        'reps' => $datum[ 'reps'.$i ],
                    ]);
                    if ( $r !== null ) {
                        $created += 1 ;
                    }
                }
            }
            // 登録するレコードがなかった場合は記録画面に戻り、メッセージを表示する
            if ( $created === 0) {
                $request->session()->flash( 'front.trainning_result_register_null' , true );
                return redirect()->back();
            }
        } catch ( \Throwable $e ) {
            $request->session()->flash( 'front.trainning_result_register_failure' , true );
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
        
        return view( 'result.list' , [ 'list' => $list , 
                                       'list_all' => $list_all , 
                                       'muscle_categories' => $muscle_categories ] );
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
        
        return view( 'result.edit' , [ 'list' => $list , 
                                       'list_all' => $list_all ,
                                       'list_trainning_event' => $list_trainning_event ,
                                       'muscle_categories' => $muscle_categories ,
                                       'muscle_category_id' => $muscle_category_id ] 
                    );
    }
    
    
    public function editSave( Request $request ) {
        $data = $request->input();
        
        try {
            foreach ( $data as $key => $value ) {
                if ( preg_match( '/^result/' , $key ) !== 0 ) {
                    $id = $value;
                    $result = ResultModel::find( $data[ 'result'.$id ] );
                    $result->trainning_event_id = $data[ 'trainning_event_id'.$id ];
                    $result->weight = $data[ 'weight'.$id ];
                    $result->reps = $data[ 'reps'.$id ];
                    $result->timestamp = str_replace( "T" , " " , $data[ 'timestamp'.$id ] );
                    $result->save();
                }
            }
        } catch ( \Throwable $e ) {
            echo $e->getMessage();exit;
            $request->session()->flash( 'front.result_edit_save_failure' , true );
            return redirect( route( 'result.edit' ) );
        }
        
        $request->session()->flash( 'front.result_edit_save_seccess' , true );
        
        return redirect( route( 'result.list' ) );
    }
    
    public function delete( Request $request ) {
        $data = $request->input();
        $muscle_category_id = $data[ 'muscle_category_id' ];
        
        $list_all = $this->getPaginateListBuilder();
        
        foreach( MuscleCategoryModel::all() as $category ) {
            $list[ 'list_id_'.$category->id ] = $this->getPaginateCategorizedListBuilder( $category->id );
        }
        
        $list_trainning_event = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        
        $muscle_categories = MuscleCategoryModel::all();
        
        return view( 'result.delete' , [ 'list' => $list , 
                                          'list_all' => $list_all ,
                                          'list_trainning_event' => $list_trainning_event ,
                                          'muscle_categories' => $muscle_categories ,
                                          'muscle_category_id' => $muscle_category_id ] );
    }
    
    
    public function deleteSave( Request $request ) {
        $data = $request->input();
        
        try {
            // 削除したレコード数記録用
            $deleted = 0;
            foreach ( $data as $key => $value ) {
                if ( preg_match( '/^result/' , $key ) !== 0 ) {
                    $id = $value;
                    $result = ResultModel::find( $id );
                    $deleted += $result->delete();
                }
            }
            // 削除するレコードがなかった場合は削除画面に戻り、メッセージを表示する
            if ( $deleted === 0 ) {
                $request->session()->flash( 'front.result_delete_save_null' , true );
                return redirect()->back();
            }
        } catch ( \Throwable $e ) {
            $request->session()->flash( 'front.result_delete_save_failure' , true );
            return redirect( route( 'result.delete' ) );
        }
        
        $request->session()->flash( 'front.result_delete_save_seccess' , true );
        
        return redirect( route( 'result.list' ) );
    }
    
    
    protected function getListBuilder() {
        $select_list = [
            'results.id as result_id',
            'results.trainning_event_id as trainning_event_id',
            'results.timestamp as trainning_timestamp',
            'trainning_events.name as trainning_event_name',
            'results.weight as trainning_weight',
            'results.reps as trainning_reps',
        ];
        return ResultModel::leftJoin( 'trainning_events' , 'results.trainning_event_id' , '=' , 'trainning_events.id' )
                          ->select( $select_list )
                          ->where( 'results.user_id' , Auth::id() )
                          ->orderBy( 'results.timestamp' ,'DESC' )
                          ->orderBy( 'trainning_events.muscle_category_id' )
                          ->orderBy( 'results.id' );
    }
    
    
    protected function getCategorizedListBuilder( $muscle_category_id ) {
        $select_list = [
            'results.id as result_id',
            'results.trainning_event_id as trainning_event_id',
            'trainning_events.name as trainning_event_name',
            'trainning_events.muscle_category_id',
            'results.timestamp as trainning_timestamp',
            'results.weight as trainning_weight',
            'results.reps as trainning_reps',
        ];
        return ResultModel::leftJoin( 'trainning_events' , 'results.trainning_event_id' , '=' , 'trainning_events.id' )
                                ->select( $select_list )
                                ->where( 'results.user_id' , Auth::id() )
                                ->where( 'trainning_events.muscle_category_id' , $muscle_category_id )
                                ->orderBy( 'results.created_at' ,'DESC' )
                                ->orderBy( 'trainning_events.muscle_category_id' )
                                ->orderBy( 'results.id' );
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
            'muscle_categories.id as muscle_category_id',
            'muscle_categories.name as muscle_category_name',
        ];
        return TrainningEventModel::leftJoin( 'muscle_categories' , 'muscle_categories.id' , '=' , 'trainning_events.muscle_category_id' )
                                  ->select( $select_list )
                                  ->where( 'user_id' , Auth::id() )
                                  ->where( 'muscle_category_id' , $muscle_category_id );
    }
}
