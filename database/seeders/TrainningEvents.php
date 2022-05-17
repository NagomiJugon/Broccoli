<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainningEvents extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 胸トレーニング
        DB::table( 'trainning_events' )->insert([
           'name' => 'チェストプレス',
           'muscle_category_id' => '1',
           'cooltime' => '2',s
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'ペクトラル フライ',
           'muscle_category_id' => '1',
           'cooltime' => '2',
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'ディップ',
           'muscle_category_id' => '1',
           'cooltime' => '2',
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'ONE HAND UPWARD FLY',
           'muscle_category_id' => '1',
           'cooltime' => '2',
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'ダンベルプレス',
           'muscle_category_id' => '1',
           'cooltime' => '2',
        ]);
        
        // 背中トレーニング
        DB::table( 'trainning_events' )->insert([
           'name' => 'デッドリフト',
           'muscle_category_id' => '2',
           'cooltime' => '2',
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'チン(ワイド)',
           'muscle_category_id' => '2',
           'cooltime' => '2',
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'チン(ナロウ)',
           'muscle_category_id' => '2',
           'cooltime' => '2',
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'シーテッド ロー',
           'muscle_category_id' => '2',
           'cooltime' => '2',
        ]);
        
        // 肩トレーニング
        DB::table( 'trainning_events' )->insert([
           'name' => 'ショルダープレス',
           'muscle_category_id' => '3',
           'cooltime' => '2',
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'サイドレイズ',
           'muscle_category_id' => '3',
           'cooltime' => '2',
        ]);
        
        // 腕トレーニング
        DB::table( 'trainning_events' )->insert([
           'name' => 'カールアーム',
           'muscle_category_id' => '4',
           'cooltime' => '2',
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'ケーブル プレスダウン',
           'muscle_category_id' => '4',
           'cooltime' => '2',
        ]);
        
        // 下半身トレーニング
        DB::table( 'trainning_events' )->insert([
           'name' => 'レッグプレス',
           'muscle_category_id' => '5',
           'cooltime' => '3',
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'レッグエクステンション',
           'muscle_category_id' => '5',
           'cooltime' => '2',
        ]);
        
        DB::table( 'trainning_events' )->insert([
           'name' => 'シーテッド レッグカール',
           'muscle_category_id' => '5',
           'cooltime' => '2',
        ]);
        
        // その他トレーニング
        DB::table( 'trainning_events' )->insert([
           'name' => 'アブドミナルクランチ',
           'muscle_category_id' => '6',
           'cooltime' => '1',
        ]);
        
    }
}
