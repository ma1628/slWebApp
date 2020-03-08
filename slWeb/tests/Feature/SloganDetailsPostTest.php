<?php

namespace Tests\Feature;

use App\Http\Requests\SloganDetailsPost;
use Illuminate\Support\Facades\Validator;
use Tests\SlWebTestCase;

class SloganDetailsPostTest extends SlWebTestCase
{
    /**
     * @test
     * @dataProvider SloganDetailsPostDataProvider
     * @param $param
     * @param $expect
     * @param $messageArray
     */
    public function SloganDetailsPostのバリデーションテスト($param, $expect, $messageArray = null)
    {
        $request = new SloganDetailsPost();
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

    public function SloganDetailsPostDataProvider()
    {
        $error_required_Param = [
            'phrase' => '',
            'writer' => '',
            'source' => '',
            'supplement' => '',
            'tagNames' => [''],
        ];

        $error_required_Message = [
            'phrase' => [
                0 => 'キャッチコピーは必ず入力してください。'
            ],
            'source' => [
                0 => '出典は必ず入力してください。'
            ],
            'tagNames.0' => [
                0 => 'タグに値を指定してください。'
            ],
        ];

        $error_string_Param = [
            'phrase' => 11111,
            'writer' => 111,
            'source' => 1111,
            'supplement' => 3123213,
            'tagNames' => [
                0 => 1111,
                1 => 0000,
            ],
        ];

        $error_string_Message = [
            'phrase' => [
                0 => 'キャッチコピーは文字列を入力してください。'
            ],
            'writer' => [
                0 => 'ライターは文字列を入力してください。'
            ],
            'source' => [
                0 => '出典は文字列を入力してください。'
            ],
            'supplement' => [
                0 => '補足は文字列を入力してください。'
            ],
            'tagNames.0' => [
                0 => 'タグは文字列を入力してください。'
            ],
            'tagNames.1' => [
                0 => 'タグは文字列を入力してください。'
            ],
        ];

        $string_number_Param = [
            'phrase' => '1111',
            'writer' => 'aaa1113',
            'source' => '1111あああ',
            'supplement' => 'aaa12213ああ',
            'tagNames' => [
                0 => '00',
                1 => 'ああああ',
            ],
        ];

        $error_max_Param = [
            'phrase' => str_repeat('a', 51),
            'writer' => str_repeat('a', 16),
            'source' => str_repeat('a', 51),
            'supplement' => str_repeat('a', 1001),
            'tagNames' => [
                0 => str_repeat('a', 16),
                1 => str_repeat('a', 16),
            ],
        ];

        $error_max_Message = [
            'phrase' => [
                0 => 'キャッチコピーは50文字以下で入力してください。'
            ],
            'writer' => [
                0 => 'ライターは15文字以下で入力してください。'
            ],
            'source' => [
                0 => '出典は50文字以下で入力してください。'
            ],
            'supplement' => [
                0 => '補足は1000文字以下で入力してください。'
            ],
            'tagNames.0' => [
                0 => 'タグは15文字以下で入力してください。',
            ],
            'tagNames.1' => [
                0 => 'タグは15文字以下で入力してください。',
            ],
        ];

        return [
            '必須エラー' => [$error_required_Param, false, $error_required_Message],
            '文字列エラー' => [$error_string_Param, false, $error_string_Message],
            '文字数字混合正常系' => [$string_number_Param, true],
            '最大文字数エラー' => [$error_max_Param, false, $error_max_Message],
        ];
    }
}
