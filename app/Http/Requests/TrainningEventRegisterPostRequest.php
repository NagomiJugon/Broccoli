<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainningEventRegisterPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'muscle_category_id' => [ 'required' ],
            'name' => [ 'required' , 'max:128' ],
            'cooltime' => [ 'required' ],
        ];
    }
}
