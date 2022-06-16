<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegisterPost;
use App\Models\User as UserModel;
use App\Models\TrainningEvent as TrainningEventModel;
use App\Models\MuscleCategory as MuscleCategoryModel;

class UserController extends Controller
{
    public function index() {
        return view( 'user.index' );
    }
    
    public function register( UserRegisterPost $request ) {
        $datum = $request->validated();
        
        $datum[ 'password' ] = Hash::make( $datum[ 'password' ] );
        
        try {
            $r = UserModel::create( $datum );
            $this->initTrainningEventsTable( $r->id );
        } catch ( \Throwable $e ) {
            $request->session()->flash( 'front.user_register_failure' , true );
            return redirect( route( 'front.index' ) );
        }
        
        $request->session()->flash( 'front.user_register_success' , true );
        
        return redirect( route( 'front.index' ) );
    }
    
    public function exeInitTrainningEvent() {
      $this->initTrainningEventsTable( Auth::id() );
      return view( 'index' );
    }
    
    protected function initTrainningEventsTable( int $user_id ) {
         $muscle_categories = MuscleCategoryModel::all();
         
         foreach ( $muscle_categories as $mc ) {
            if ( $mc->name === '胸' ) $mc_c = $mc->id ;
            if ( $mc->name === '背中' ) $mc_b = $mc->id ;
            if ( $mc->name === '肩' ) $mc_s = $mc->id ;
            if ( $mc->name === '腕' ) $mc_a = $mc->id ;
            if ( $mc->name === '下半身' ) $mc_l = $mc->id ;
            if ( $mc->name === 'その他' ) $mc_o = $mc->id ;
         }
         
         $list = [
            [
               'name' => 'チェストプレス',
               'muscle_category_id' => $mc_c,
               'cooltime' => '2',
            ],
            [
               'name' => 'ペクトラル フライ',
               'muscle_category_id' => $mc_c,
               'cooltime' => '2',
            ],
            [
               'name' => 'ディップ',
               'muscle_category_id' => $mc_c,
               'cooltime' => '2',
            ],
            [
               'name' => 'ONE HAND UPWARD FLY',
               'muscle_category_id' => $mc_c,
               'cooltime' => '2',
            ],
            [
               'name' => 'ダンベルプレス',
               'muscle_category_id' => $mc_c,
               'cooltime' => '2',
            ],
            [
               'name' => 'デッドリフト',
               'muscle_category_id' => $mc_b,
               'cooltime' => '2',
            ],
            [
               'name' => 'チン(ワイド)',
               'muscle_category_id' => $mc_b,
               'cooltime' => '2',
            ],
            [
               'name' => 'チン(ナロウ)',
               'muscle_category_id' => $mc_b,
               'cooltime' => '2',
            ],
            [
               'name' => 'シーテッド ロー',
               'muscle_category_id' => $mc_b,
               'cooltime' => '2',
            ],
            [
               'name' => 'ショルダープレス',
               'muscle_category_id' => $mc_s,
               'cooltime' => '2',
            ],
            [
               'name' => 'サイドレイズ',
               'muscle_category_id' => $mc_s,
               'cooltime' => '2',
            ],
            [
               'name' => 'アームカール',
               'muscle_category_id' => $mc_a,
               'cooltime' => '2',
            ],
            [
               'name' => 'ケーブル プレスダウン',
               'muscle_category_id' => $mc_a,
               'cooltime' => '2',
            ],
            [
               'name' => 'レッグプレス',
               'muscle_category_id' => $mc_l,
               'cooltime' => '3',
            ],
            [
               'name' => 'レッグエクステンション',
               'muscle_category_id' => $mc_l,
               'cooltime' => '2',
            ],
            [
               'name' => 'シーテッド レッグカール',
               'muscle_category_id' => $mc_l,
               'cooltime' => '2',
            ],
            [
               'name' => 'アブドミナルクランチ',
               'muscle_category_id' => $mc_o,
               'cooltime' => '1',
            ],
         ];
        
         foreach ( $list as &$datum ) {
            $datum[ 'user_id' ] = $user_id;
         }
         unset( $datum );
         
         TrainningEventModel::insert( $list );
    }
    
}
