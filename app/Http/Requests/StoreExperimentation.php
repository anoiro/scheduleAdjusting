<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperimentation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'labID'=>'required',
            'expName'=>'required|string|max:255',
            'start'=>'required|date',
            'end'=>'required|date',
            'recruit'=>'required',
            'thanks'=>'required',
            'room'=>'required',
            'weekend'=>'required',
        ];
    }
}
