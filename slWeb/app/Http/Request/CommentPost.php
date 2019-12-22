<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentPost extends FormRequest
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
            'contributor_name' => 'required|string|max:30|regex:/[^　]+/',
            'text' => 'required|string|max:300|regex:/[^　]+/',
            'rating' => 'required|integer|between:1,5',
        ];
    }
}
