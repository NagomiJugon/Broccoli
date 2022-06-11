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
    public function register() {
        $list = MuscleCategoryModel::get();
        return view( 'trainning.register' , [ 'list' => $list ] );
    }
    
    public function registerSave( TrainningEventRegisterPostRequest $request ){
        $datum = $request->validated();
        
        $datum[ 'user_id' ] = Auth::id();
        
        try {
            $r = TrainningEventModel::create( $datum );
        } catch ( \Throwable $e ) {
            $request->session()->flash( 'front.trainning_event_register_failure' , true );
            return redirect( route( 'result.record' ) );
        }
        
        $request->session()->flash( 'front.trainning_event_register_success' , true );
        
        return redirect( route( 'result.record' ) );
    }
    
    
    public function list() {
        
        $list_all = $this->getListBuilder()->get();
        
        foreach( MuscleCategoryModel::all() as $category ) {
            $list[ 'list_id_'.$category->id ] = $this->getCategorizedListBuilder( $category->id )->get();
        }
        
        $muscle_categories = MuscleCategoryModel::all();
        
        return view( 'trainning.list' , 
                     [
                        'list' => $list , 
                        'list_all' => $list_all , 
                        'muscle_categories' => $muscle_categories ,
                     ] 
                   );
    }
    
    
    public function edit( Request $request ) {
        // 絞ったカテゴリーを保持したまま画面遷移するために、選択中のmuscle_category_idを取得する
        $d = $request->input();
        $muscle_category_id = $d[ 'muscle_category_id' ];
        
        $list_all = $this->getListBuilder()->get();
        
        foreach( MuscleCategoryModel::all() as $category ) {
            $list[ 'list_id_'.$category->id ] = $this->getCategorizedListBuilder( $category->id )->get();
        }
        
        $muscle_categories = MuscleCategoryModel::all();
        
        $list_trainning_event = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        
        return view( 'trainning.edit' , 
                     [
                        'list' => $list , 
                        'list_all' => $list_all , 
                        'muscle_categories' => $muscle_categories ,
                        'muscle_category_id' => $muscle_category_id ,
                        'list_trainning_event' => $list_trainning_event
                     ] 
                   );
    }
    
    
    public function editSave( Request $request ) {
        $data = $request->input();
        
        try {
            foreach ( $data as $key => $value ) {
                /**
                 * requestから送られてきた配列のうち、trainning_event_idから始まるキーを見つけて
                 * 編集対象のtrainng_events.idを取得する
                 * キーの末尾についた数字がresult_idと紐づいている
                 */
                if ( preg_match( '/^trainning_event_id/' , $key ) !== 0 ) {
                    $id = $value;
                    $trainning_event = TrainningEventModel::find( $id );
                    $trainning_event->muscle_category_id = $data[ 'muscle_category_id'.$id ];
                    $trainning_event->name = $data[ 'trainning_event_name'.$id ];
                    $trainning_event->cooltime = $data[ 'cooltime'.$id ];
                    $trainning_event->save();
                }
            }
        } catch ( \Throwable $e ) {
            $request->session()->flash( 'front.trainning_event_edit_save_failure' , true );
            // redirect( route( 'trainning.edit' ) )にするとmuscle_category_idを連携できず、エラーになるのでback()で戻ることにする
            return redirect()->back();
        }
        
        $request->session()->flash( 'front.trainning_event_edit_save_success' , true );
        
        return redirect( route( 'trainning.list' ) );
    }
    
    
    public function delete( Request $request ) {
        // 絞ったカテゴリーを保持したまま画面遷移するために、選択中のmuscle_category_idを取得する
        $d = $request->input();
        $muscle_category_id = $d[ 'muscle_category_id' ];
        
        $list_all = $this->getListBuilder()->get();
        
        foreach( MuscleCategoryModel::all() as $category ) {
            $list[ 'list_id_'.$category->id ] = $this->getCategorizedListBuilder( $category->id )->get();
        }
        
        $muscle_categories = MuscleCategoryModel::all();
        
        $list_trainning_event = TrainningEventModel::where( 'user_id' , Auth::id() )->get();
        
        return view( 'trainning.delete' , 
                     [
                        'list' => $list , 
                        'list_all' => $list_all , 
                        'muscle_categories' => $muscle_categories ,
                        'muscle_category_id' => $muscle_category_id ,
                        'list_trainning_event' => $list_trainning_event
                     ] 
                   );
    }
    
    
    public function deleteSave( Request $request ) {
        $data = $request->input();
        
        try {
            // 削除したレコード数記録用
            $deleted = 0;
            foreach ( $data as $key => $value ) {
                if ( preg_match( '/^trainning_event_id/' , $key ) !== 0 ) {
                    $id = $value;
                    $trainning_event = TrainningEventModel::find( $id );
                    $deleted += $trainning_event->delete();
                }
            }
            // 削除するレコードがなかった場合は削除画面に戻り、メッセージを表示する
            if ( $deleted === 0 ) {
                $request->session()->flash( 'front.trainning_event_delete_save_null' , true );
                return redirect()->back();
            }
        } catch ( \Throwable $e ) {
            $request->session()->flash( 'front.trainning_event_delete_save_failure' , true );
            return redirect()->back();
        }
        
        $request->session()->flash( 'front.trainning_event_delete_save_seccess' , true );
        
        return redirect( route( 'trainning.list' ) );
    }
    
    
    /**
     * 全部位のトレーニング種目を取得する
     * ページネーション付き
     */
    protected function getListBuilder() {
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
                                  ->orderBy( 'trainning_events.created_at' , 'DESC' );
    }
    
    
    protected function getCategorizedListBuilder( $muscle_category_id ) {
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
                                  ->orderBy( 'trainning_events.created_at' , 'DESC' );
    }
}
