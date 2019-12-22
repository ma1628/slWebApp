<?php

namespace Tests\Feature;

use App\Http\Requests\CommentPost;
use App\Http\Requests\SloganDetailsPost;
use App\Http\Requests\TagDetailPost;
use App\Slogan;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestTest extends TestCase
{

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'TestDataSeeder']);
    }

    /**
     * @test
     * @dataProvider SloganDetailsPostDataProvider
     * @param $param
     * @param $expect
     * @param $messageArray
     */
    public function SloganDetailsPostのバリデーションエラー($param, $expect, $messageArray)
    {

        $request = new SloganDetailsPost();
        //フォームリクエストで定義したルールを取得
        $rules = $request->rules();
        //Validatorファサードでバリデーターのインスタンスを取得、その際に入力情報とバリデーションルールを引数で渡す
        $validator = Validator::make($param, $rules);
        //入力情報がバリデーショルールを満たしている場合はtrue、満たしていな場合はfalseが返る
        $result = $validator->passes();
        fwrite(STDERR, print_r($validator->errors()->messages(), TRUE));
        //期待値($expect)と結果($result)を比較
        $this->assertEquals($expect, $result);
        if ($messageArray) {
            // エラーメッセージの確認
            $this->assertEquals($messageArray, $validator->errors()->messages());
        }
    }

    public function SloganDetailsPostDataProvider()
    {
        $normalParam = [
            'phrase' => str_repeat('a', 50),
            'writer' => 'a',
            'source' => 'a',
            'supplement' => str_repeat('a', 1000),
            'tags' => [
                '0' => [
                    'slogan_id' => '3',
                    'tag_name' => 'ああ',
                    'tag_kana' => 'ああ',
                ],
                '1' => [
                    'slogan_id' => '99999',
                    'tag_name' => 'ああ',
                    'tag_kana' => 'ああ',
                ],
            ],
        ];

        $error_required_Param = [
            'phrase' => ' ',
            'writer' => '',
            'source' => '',
            'supplement' => '',
        ];

        $error_required_Message = [
            'phrase' => [
                0 => 'キャッチコピーは必ず入力してください。'
            ],
            'source' => [
                0 => '出典は必ず入力してください。'
            ],
        ];

        $error_ZenakuSpace_Param = [
            'phrase' => '　',
            'writer' => '　',
            'source' => '　',
            'supplement' => '　',
        ];

        $error_ZenakuSpace_Message = [
            'phrase' => [
                0 => 'キャッチコピーは必ず入力してください。'
            ],
            'source' => [
                0 => '出典は必ず入力してください。'
            ],
        ];

        $error_max_Param = [
            'phrase' => str_repeat('a', 51),
            'writer' => str_repeat('a', 16),
            'source' => str_repeat('a', 51),
            'supplement' => str_repeat('a', 1001),
        ];

        $error_max_Message = [
            'phrase' => [
                0 => 'キャッチコピーは、50文字以下で入力してください。'
            ],
            'writer' => [
                0 => 'ライターは、15文字以下で入力してください。'
            ],
            'source' => [
                0 => '出典は、50文字以下で入力してください。'
            ],
            'supplement' => [
                0 => '補足は、1000文字以下で入力してください。'
            ],
        ];

        return [
            '正常' => [$normalParam, true, false],
            '必須エラー' => [$error_required_Param, false, $error_required_Message],
            '必須エラー（全角空白チェック）' => [$error_ZenakuSpace_Param, false, $error_ZenakuSpace_Message],
            '最大文字数エラー' => [$error_max_Param, false, $error_max_Message],
        ];
    }
    /**
     * @test
     * @dataProvider CommentPostDataProvider
     * @param $param
     * @param $expect
     * @param $messageArray
     */
    public function CommentPostのバリデーションエラー($param, $expect, $messageArray)
    {

        $request = new CommentPost();
        //フォームリクエストで定義したルールを取得
        $rules = $request->rules();
        //Validatorファサードでバリデーターのインスタンスを取得、その際に入力情報とバリデーションルールを引数で渡す
        $validator = Validator::make($param, $rules);
        //入力情報がバリデーショルールを満たしている場合はtrue、満たしていな場合はfalseが返る
        //期待値($expect)と結果($result)を比較
        $this->assertEquals($expect, $validator->passes());
        if ($messageArray) {
            // エラーメッセージの確認
            $this->assertEquals($messageArray, $validator->errors()->messages());
        }

    }

    public function CommentPostDataProvider()
    {
        $normalParam = [
            'contributor_name' => str_repeat('a', 30),
            'text' => str_repeat('a', 300),
            'rating' => '5',
        ];

        $error_required_Param = [
            'contributor_name' => ' ',
            'text' => ' ',
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

        $error_ZenkakuSpace_Param = [
            'contributor_name' => '　',
            'text' => '　',
            'rating' => '　',
        ];

        $error_ZenkakuSpace_Message = [
            'contributor_name' => [
                0 => '投稿者名は必ず入力してください。'
            ],
            'text' => [
                0 => 'コメントは必ず入力してください。'
            ],
            'rating' => [
                0 => '評価は整数で指定してください。'
            ],
        ];

        $error_max_Param = [
            'contributor_name' => str_repeat('a', 31),
            'text' => str_repeat('a', 301),
            'rating' => '6',
        ];

        $error_max_Message = [
            'contributor_name' => [
                0 => '投稿者名は、30文字以下で入力してください。'
            ],
            'text' => [
                0 => 'コメントは、300文字以下で入力してください。'
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
            '正常' => [$normalParam, true, false],
            '必須エラー' => [$error_required_Param, false, $error_required_Message],
            '必須（全角空白）エラー' => [$error_ZenkakuSpace_Param, false, $error_ZenkakuSpace_Message],
            '最大文字数、範囲超過エラー' => [$error_max_Param, false, $error_max_Message],
            '整数確認エラー小数' => [$error_Integer_Param, false, $error_Integer_Message],
            '整数確認エラー文字列' => [$error_Integer_Param2, false, $error_Integer_Message2],
        ];
    }

    /**
     * @test
     * @dataProvider TagDetailsPostDataProvider
     * @param $param
     * @param $expect
     * @param $messageArray
     */
    public function TagDetailsPostのバリデーションエラー($param, $expect, $messageArray)
    {

        $request = new TagDetailPost();
        //フォームリクエストで定義したルールを取得
        $rules = $request->rules();
        //Validatorファサードでバリデーターのインスタンスを取得、その際に入力情報とバリデーションルールを引数で渡す
        $validator = Validator::make($param, $rules);
        //入力情報がバリデーショルールを満たしている場合はtrue、満たしていな場合はfalseが返る
        $result = $validator->passes();
        //期待値($expect)と結果($result)を比較
        $this->assertEquals($expect, $result);
        fwrite(STDERR, print_r($validator->errors()->messages(), TRUE));
        if ($messageArray) {
            // エラーメッセージの確認
            $this->assertEquals($messageArray, $validator->errors()->messages());
        }
    }

    public function TagDetailsPostDataProvider()
    {
        // 正常系はHTTPテストで確認するので省略
        $nomalParam = [
            'tags' => [
                '0' => [
                    'slogan_id' => '3',
                    'tag_name' => 'ああ',
                    'tag_kana' => 'ああ',
                ],
                '1' => [
                    'slogan_id' => '99999',
                    'tag_name' => 'ああ',
                    'tag_kana' => 'ああ',
                ],
            ],
        ];


        $error_required_Param = [
            'slogan_id' => '',
            'tag_name' => ' ',
            'tag_kana' => '',
        ];

        $error_required_Message = [
            'slogan_id' => [
                0 => 'エラーが発生しました。'
            ],
            'tag_name' => [
                0 => 'タグ名は必ず入力してください。'
            ],
        ];

        $error_ZenkakuSpace_Param = [
            'slogan_id' => '　',
            'tag_name' => '　',
            'tag_kana' => '',
        ];

        $error_ZenkakuSpace_Message = [
            'slogan_id' => [
                0 => 'エラーが発生しました。'
            ],
            'tag_name' => [
                0 => 'タグ名は必ず入力してください。'
            ],
        ];

        $error_max_Param = [
            'slogan_id' => 000000,
            'tag_name' => str_repeat('a', 31),
            'tag_kana' => str_repeat('a', 91),
        ];

        $error_max_Message = [
            'slogan_id' => [
                0 => 'エラーが発生しました。'
            ],
            'tag_name' => [
                0 => 'タグ名は、30文字以下で入力してください。'
            ],
            'tag_kana' => [
                0 => 'エラーが発生しました。タグ名が長すぎます。',
            ]
        ];

        $error_StringAndHiragana_Param = [
            'slogan_id' => 'a',
            'tag_name' => 1,
            'tag_kana' => 'カタカナ',
        ];

        $error_StringAndHiragana_Message = [
            'slogan_id' => [
                0 => 'エラーが発生しました。'
            ],
            'tag_name' => [
                0 => 'タグ名は文字列を入力してください。'
            ],
            'tag_kana' => [
                0 => 'エラーが発生しました。'
            ],
        ];

        $error_Kanji_Param = [
            'slogan_id' => 'a',
            'tag_name' => str_repeat('a', 30),
            'tag_kana' => '漢字',
        ];

        $error_Kanji_Message = [
            'slogan_id' => [
                0 => 'エラーが発生しました。'
            ],
            'tag_kana' => [
                0 => 'エラーが発生しました。'
            ],

        ];

        return [
            'てす' => [$nomalParam, false, $error_max_Message],
            '必須エラー' => [$error_required_Param, false, $error_required_Message],
            '必須エラー(全角空白)' => [$error_ZenkakuSpace_Param, false, $error_ZenkakuSpace_Message],
            'id存在エラー、文字数超過エラー' => [$error_max_Param, false, $error_max_Message],
            '形式エラー' => [$error_StringAndHiragana_Param, false, $error_StringAndHiragana_Message],
            'ひらがなチェックエラー' => [$error_Kanji_Param, false, $error_Kanji_Message],
        ];
    }
}
