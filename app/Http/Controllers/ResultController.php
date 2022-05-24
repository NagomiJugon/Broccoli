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

class ResultController extends Controller
{
    public function record() {
        $list = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        /*
        $list[ 'list_all' ] = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        for ( $i = 1 ; $i <= TrainningEventModel::count() ; $i++ ) {
            $list[ 'list_id_'.$i ]  = TrainningEventModel::where([
                                                            [ 'user_id' , '=' , Auth::id() ],
                                                            [ 'muscle_category_id' , '=' , $i ],
                                                            ])
                                                            ->get();
        }*/
        return view( 'result.record' , [ 'list' => $list ] );
    }
    
    
    public function register( ResultRegisterPostRequest $request ) {
        dd( $request->input() );
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
        $per_page = 10;
        $list = $this->getListBuilder()->paginate( $per_page );
        return view( 'result.list' , [ 'list' => $list ] );
    }
    
    
    public function edit() {
        $per_page = 10;
        $list_trainning_event = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        $list_result = $this->getListBuilder()->paginate( $per_page );
        return view( 'result.edit' , [ 'list_trainning_event' => $list_trainning_event , 'list_result' => $list_result ] );
    }
    
    
    public function editSave( Request $request ) {
        $data = $request->input();
        //dd($data);
        try {
            foreach ( $data as $key => $value ) {
                if ( preg_match( '/^trainning_set_id/' , $key ) !== 0 || false ) {
                    $id = $value;
                    $result = ResultModel::find( $data[ 'result'.$id ] );
                    $result->trainning_event_id = $data[ 'trainning_event_id'.$id ];21
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
    
    
    protected function getListBuilder() {
        return TrainningSetModel::leftJoin( 'results' , 'results.id' , '=' , 'trainning_sets.result_id' )
                                ->Join( 'trainning_events' , 'results.trainning_event_id' , '=' , 'trainning_events.id' )
                                ->selectRaw( 'results.id as result_id' )
                                ->selectRaw( 'trainning_events.id as trainning_event_id' )
                                ->selectRaw( 'trainning_events.name as trainning_events_name' )
                                ->selectRaw( 'trainning_sets.id as trainning_set_id' )
                                ->selectRaw( 'trainning_sets.created_at as trainning_set_datetime' )
                                ->selectRaw( 'trainning_sets.weight as trainning_weight' )
                                ->selectRaw( 'trainning_sets.reps as trainning_reps' )
                                ->where( 'results.user_id' , Auth::id() )
                                ->orderBy( 'trainning_sets.created_at' ,'DESC' )
                                ->orderBy( 'trainning_events.muscle_category_id' )
                                ->orderBy( 'trainning_sets.id' );
    }
}
