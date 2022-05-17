<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultRegisterGetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trainning_event_id' => [ 'required' ],
            
            'weight1' => [ 'required' ],
            'reps1' => [ 'required' ],
            
            'weight2' => [ 'required_with:reps2' ],
            'reps2' => [ 'required_with:weight2' ],
            
            'weight3' => [ 'required_with:reps3' ],
            'reps3' => [ 'required_with:weight3' ],
            
            'weight4' => [ 'required_with:reps4' ],
            'reps4' => [ 'required_with:weight4' ],
            
            'weight5' => [ 'required_with:reps5' ],
            'reps5' => [ 'required_with:weight5' ],
        ];
    }
}
