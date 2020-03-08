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
            'contributor_name' => ['required', 'string', 'max:' . config('const.CONTRIBUTOR_NAME_MAX_INPUT_NUM')],
            'text' => ['required', 'string', 'max:' . config('const.COMMENT_MAX_INPUT_NUM')],
            'rating' => ['required', 'integer', 'between:1,5']
        ];
    }
}
