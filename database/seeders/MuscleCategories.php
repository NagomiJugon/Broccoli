<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MuscleCategories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'muscle_categories' )->insert([
            'name' => '胸',
        ]);
        
        DB::table( 'muscle_categories' )->insert([
            'name' => '背中',
        ]);
        
        DB::table( 'muscle_categories' )->insert([
            'name' => '肩',
        ]);
        
        DB::table( 'muscle_categories' )->insert([
            'name' => '腕',
        ]);
        
        DB::table( 'muscle_categories' )->insert([
            'name' => '下半身',
        ]);
        
        DB::table( 'muscle_categories' )->insert([
            'name' => 'その他',
        ]);
    }
}
