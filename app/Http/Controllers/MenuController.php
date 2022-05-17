<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ResultRegisterGetRequest;
use App\Models\TrainningEvent as TrainningEventModel;
use App\Models\Result as ResultModel;
use App\Models\TrainningSet as TrainningSetModel;

class MenuController extends Controller
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
        return view( 'menu.record' , [ 'list' => $list ] );
    }
    
    
    public function register( ResultRegisterGetRequest $request ) {
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
            return redirect( '/trainning/record' );
        }
        
        $request->session()->flash( 'front.trainning_result_register_success' , true );
        
        return redirect( '/trainning/record' );
    }
    
    
    public function list() {
        $per_page = 20;
        $list = $this->getListBuilder()->paginate( $per_page );
        return view( 'menu.list' , [ 'list' => $list ] );
    }
    
    
    public function edit() {
        $per_page = 20;
        $list_trainning_event = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        $list_result = $this->getListBuilder()->paginate( $per_page );
        return view( 'menu.edit' , [ 'list_trainning_event' => $list_trainning_event , 'list_result' => $list_result ] );
    }
    
    
    protected function getListBuilder() {
        return TrainningSetModel::leftJoin( 'results' , 'results.id' , '=' , 'trainning_sets.result_id' )
                                ->Join( 'trainning_events' , 'results.trainning_event_id' , '=' , 'trainning_events.id' )
                                ->selectRaw( 'trainning_events.id as trainning_event_id' )
                                ->selectRaw( 'trainning_events.name as trainning_events_name' )
                                ->selectRaw( 'trainning_sets.created_at as trainning_set_datetime' )
                                ->selectRaw( 'trainning_sets.weight as trainning_weight' )
                                ->selectRaw( 'trainning_sets.reps as trainning_reps' )
                                ->where( 'results.user_id' , Auth::id() )
                                ->orderBy( 'trainning_sets.created_at' ,'DESC' )
                                ->orderBy( 'trainning_events.muscle_category_id' )
                                ->orderBy( 'trainning_sets.id' );
    }
}
