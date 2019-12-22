<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SloganDetailsPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phrase' => 'required|string|max:50|regex:/[^　]+/',
            'writer' => 'nullable|string|max:15',
            'source' => 'required|string|max:50|regex:/[^　]+/',
            'supplement' => 'nullable|string|max:1000',
            //'tags.*.slogan_id' => 'required|integer|exists:slogans,id',
//            'tags' => 'string|max:30|regex:/[^　]+/',
            'tagNames' => 'string|max:90|regex:/[#.{1,30}]+/',
//            'tags.*.tag_kana' => 'nullable|string|max:90|regex:/^[ぁ-んーa-zA-Z0-9]+$/u',
        ];
    }
}
