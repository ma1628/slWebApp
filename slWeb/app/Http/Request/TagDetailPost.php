<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagDetailPost extends FormRequest
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
            'tags.*.slogan_id' => 'required|integer|exists:slogans,id',
            'tags.*.tag_name' => 'required|string|max:30|regex:/[^　]+/',
            'tags.*.tag_kana' => 'nullable|string|max:90|regex:/^[ぁ-んーa-zA-Z0-9]+$/u',
        ];
    }
}
