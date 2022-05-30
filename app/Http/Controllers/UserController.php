<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegisterPost;
use App\Models\User as UserModel;
use App\Models\TrainningEvent as TrainningEventModel;

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
        } catch ( \Throwable $e ) {
            $request->session()->flash( 'front.user_register_failure' , true );
            return redirect( route( 'front.index' ) );
        }
        
        $this->initTrainningEventsTable( $r->id );
        
        $request->session()->flash( 'front.user_register_success' , true );
        
        return redirect( reout( 'front.index' ) );
    }
    
    public function exeInitTrainningEvent() {
      $this->initTrainningEventsTable( Auth::id() );
      return view( 'index' );
    }
    
    protected function initTrainningEventsTable( int $user_id ) {
        $list = [
            [
               'name' => 'チェストプレス',
               'muscle_category_id' => '1',
               'cooltime' => '2',
            ],
            [
               'name' => 'ペクトラル フライ',
               'muscle_category_id' => '1',
               'cooltime' => '2',
            ],
            [
               'name' => 'ディップ',
               'muscle_category_id' => '1',
               'cooltime' => '2',
            ],
            [
               'name' => 'ONE HAND UPWARD FLY',
               'muscle_category_id' => '1',
               'cooltime' => '2',
            ],
            [
               'name' => 'ダンベルプレス',
               'muscle_category_id' => '1',
               'cooltime' => '2',
            ],
            [
               'name' => 'デッドリフト',
               'muscle_category_id' => '2',
               'cooltime' => '2',
            ],
            [
               'name' => 'チン(ワイド)',
               'muscle_category_id' => '2',
               'cooltime' => '2',
            ],
            [
               'name' => 'チン(ナロウ)',
               'muscle_category_id' => '2',
               'cooltime' => '2',
            ],
            [
               'name' => 'シーテッド ロー',
               'muscle_category_id' => '2',
               'cooltime' => '2',
            ],
            [
               'name' => 'ショルダープレス',
               'muscle_category_id' => '3',
               'cooltime' => '2',
            ],
            [
               'name' => 'サイドレイズ',
               'muscle_category_id' => '3',
               'cooltime' => '2',
            ],
            [
               'name' => 'カールアーム',
               'muscle_category_id' => '4',
               'cooltime' => '2',
            ],
            [
               'name' => 'ケーブル プレスダウン',
               'muscle_category_id' => '4',
               'cooltime' => '2',
            ],
            [
               'name' => 'レッグプレス',
               'muscle_category_id' => '5',
               'cooltime' => '3',
            ],
            [
               'name' => 'レッグエクステンション',
               'muscle_category_id' => '5',
               'cooltime' => '2',
            ],
            [
               'name' => 'シーテッド レッグカール',
               'muscle_category_id' => '5',
               'cooltime' => '2',
            ],
            [
               'name' => 'アブドミナルクランチ',
               'muscle_category_id' => '6',
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
