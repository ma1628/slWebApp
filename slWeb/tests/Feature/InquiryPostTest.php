<?php

namespace Tests\Feature;

use App\Http\Requests\InquiryPost;
use Illuminate\Support\Facades\Validator;
use Tests\SlWebTestCase;

class InquiryPostTest extends SlWebTestCase
{
    /**
     * @test
     * @dataProvider InquiryPostDataProvider
     * @param $param
     * @param $expect
     * @param $messageArray
     */
    public function InquiryPostのバリデーションテスト($param, $expect, $messageArray = null)
    {
        $request = new InquiryPost();
        //フォームリクエストで定義したルールを取得
        $rules = $request->rules();
        //Validatorファサードでバリデーターのインスタンスを取得、その際に入力情報とバリデーションルールを引数で渡す
        $validator = Validator::make($param, $rules);
        //入力情報がバリデーショルールを満たしている場合はtrue、満たしていな場合はfalseが返る
        $result = $validator->passes();
        //期待値($expect)と結果($result)を比較
        $this->assertEquals($expect, $result);
        if ($messageArray) {
            // エラーメッセージの確認
            $this->assertEquals($messageArray, $validator->errors()->messages());
        }
    }

    public function InquiryPostDataProvider()
    {
        $error_required_Param = [
            'inquiry' => '',
        ];

        $error_required_Message = [
            'inquiry' => [
                0 => 'お問い合わせ内容は必ず入力してください。'
            ],
        ];

        $error_string_Param = [
            'inquiry' => 0000,
        ];

        $error_string_Message = [
            'inquiry' => [
                0 => 'お問い合わせ内容は文字列を入力してください。'
            ],
        ];

        $error_max_Param = [
            'inquiry' => str_repeat('a', 1001),
        ];

        $error_max_Message = [
            'inquiry' => [
                0 => 'お問い合わせ内容は1000文字以下で入力してください。'
            ],
        ];

        return [
            '必須エラー' => [$error_required_Param, false, $error_required_Message],
            '文字列エラー' => [$error_string_Param, false, $error_string_Message],
            '最大文字数エラー' => [$error_max_Param, false, $error_max_Message],
        ];
    }
}
