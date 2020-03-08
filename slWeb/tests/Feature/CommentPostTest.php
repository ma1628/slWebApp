<?php

namespace Tests\Feature;

use App\Http\Requests\CommentPost;
use Illuminate\Support\Facades\Validator;
use Tests\SlWebTestCase;

class CommentPostTest extends SlWebTestCase
{
    /**
     * @test
     * @dataProvider CommentPostDataProvider
     * @param $param
     * @param $expect
     * @param $messageArray
     */
    public function CommentPostのバリデーションテスト($param, $expect, $messageArray = null)
    {
        $request = new CommentPost();
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

    public function CommentPostDataProvider()
    {
        $error_required_Param = [
            'contributor_name' => '',
            'text' => '',
            'rating' => '',
        ];

        $error_required_Message = [
            'contributor_name' => [
                0 => '投稿者名は必ず入力してください。'
            ],
            'text' => [
                0 => 'コメントは必ず入力してください。'
            ],
            'rating' => [
                0 => '評価は必ず入力してください。'
            ],
        ];

        $error_string_Param = [
            'contributor_name' => 1111,
            'text' => 0000,
            'rating' => '0',
        ];

        $error_string_Message = [
            'contributor_name' => [
                0 => '投稿者名は文字列を入力してください。'
            ],
            'text' => [
                0 => 'コメントは文字列を入力してください。'
            ],
            'rating' => [
                0 => '評価は、1から5の間で指定してください。'
            ],
        ];

        $error_max_Param = [
            'contributor_name' => str_repeat('a', 31),
            'text' => str_repeat('a', 301),
            'rating' => 6,
        ];

        $error_max_Message = [
            'contributor_name' => [
                0 => '投稿者名は30文字以下で入力してください。'
            ],
            'text' => [
                0 => 'コメントは300文字以下で入力してください。'
            ],
            'rating' => [
                0 => '評価は、1から5の間で指定してください。'
            ],
        ];

        $error_Integer_Param = [
            'contributor_name' => 'a',
            'text' => 'a',
            'rating' => '3.5',
        ];

        $error_Integer_Message = [
            'rating' => [
                0 => '評価は整数で指定してください。'
            ],
        ];

        $error_Integer_Param2 = [
            'contributor_name' => 'a',
            'text' => 'a',
            'rating' => 'a',
        ];

        $error_Integer_Message2 = [
            'rating' => [
                0 => '評価は整数で指定してください。'
            ],
        ];

        return [
            '必須エラー' => [$error_required_Param, false, $error_required_Message],
            '文字列エラー' => [$error_string_Param, false, $error_string_Message],
            '最大文字数エラー' => [$error_max_Param, false, $error_max_Message],
            '整数エラー' => [$error_Integer_Param, false, $error_Integer_Message],
            '整数エラー２' => [$error_Integer_Param2, false, $error_Integer_Message2],
        ];
    }
}
