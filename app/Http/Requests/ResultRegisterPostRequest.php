<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\MuscleCategory as MuscleCategoryModel;

class ResultRegisterPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * 重量は空欄可(自重トレなど)
     * 重量が入力済みの場合はレップ数を必須入力とする
     * @return array
     */
    public function rules()
    {
        $list = array(
            'selected_category' => [ 'nullable' ],
            
            'weight1' => [ 'nullable' ],
            'reps1' => [ 'required' ],
            
            'weight2' => [ 'nullable' ],
            'reps2' => [ 'required_with:weight2' ],
            
            'weight3' => [ 'nullable' ],
            'reps3' => [ 'required_with:weight3' ],
            
            'weight4' => [ 'nullable' ],
            'reps4' => [ 'required_with:weight4' ],
            
            'weight5' => [ 'nullable' ],
            'reps5' => [ 'required_with:weight5' ],
        );
        
        foreach( MuscleCategoryModel::all() as $category ) {
            $list[ 'trainning_event_id0' ] = [ 'required' ];
            $list[ 'trainning_event_id'.$category->id ] = [ 'required' ];
        }
        
        return [
            $list
        ];
    }
}
