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

    protected function prepareForValidation()
    {
        // バリデーションエラーの場合タグを再表示させる
        $this->session()->flash('oldTagNames', $this->get('tagNames'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phrase' => ['required', 'string', 'max:' . config('const.SLOGAN_MAX_INPUT_NUM')],
            'writer' => ['nullable', 'string', 'max:' . config('const.WRITER_MAX_INPUT_NUM')],
            'source' => ['required', 'string', 'max:' . config('const.SOURCE_MAX_INPUT_NUM')],
            'supplement' => ['nullable', 'string', 'max:' . config('const.SUPPLEMENT_MAX_INPUT_NUM')],
            'tagNames.*' => ['nullable', 'filled', 'string', 'max:' . config('const.TAG_NAME_MAX_INPUT_NUM')]
        ];
    }
}
