<?php

namespace Tests\Feature;

use Tests\SlWebTestCase;

class TrimSpaceTest extends SlWebTestCase
{
    /**
     * @test
     * @dataProvider trimSpaceDataProvider
     * @param $param
     * @param $expectedSlogan
     * @param $expectedTags
     */
    public function フォームに入力された値の前後の空白が削除されるかテスト($param, $expectedSlogan, $expectedTags)
    {
        $this->call('POST', route('addSlogan'), $param);
        $this->assertDatabaseHas('slogans', $expectedSlogan);
        $this->assertDatabaseHas('tags', $expectedTags);
    }

    public function trimSpaceDataProvider()
    {
        $zenakuSpace_Param = [
            'phrase' => '　　テスト　　',
            'writer' => '　　テスト　　',
            'source' => '　テスト　',
            'supplement' => '　　　テスト　',
            'tagNames' => [
                '0' => '　　テスト　',
                '1' => '　test　',
            ]
        ];

        $hankakuSpace_Param = [
            'phrase' => '  テスト  ',
            'writer' => '  テスト  ',
            'source' => ' テスト ',
            'supplement' => ' テスト  ',
            'tagNames' => [
                '0' => ' テスト  ',
                '1' => ' test   ',
            ]
        ];

        $linefeed_Param = [
            'phrase' => '
            テスト
            ',
            'writer' => '
            テスト
            ',
            'source' => '
            テスト
            
            ',
            'supplement' => '
            テスト
            ',
            'tagNames' => [
                '0' => '
                テスト  ',
                '1' => '
                test',
            ]
        ];

        $tab_Param = [
            'phrase' => '   テスト ',
            'writer' => '   テスト        ',
            'source' => '       テスト    ',
            'supplement' => '   テスト ',
            'tagNames' => [
                '0' => '    テスト ',
                '1' => 'test    ',
            ]
        ];

        $expectedSlogan = [
            'phrase' => 'テスト',
            'writer' => 'テスト',
            'source' => 'テスト',
            'supplement' => 'テスト',
        ];

        $expectedTags = [
            'tag_name' => [
                'テスト', 'test'
            ]
        ];

        return [
            '全角空白チェック' => [$zenakuSpace_Param, $expectedSlogan, $expectedTags],
            '半角空白チェック' => [$hankakuSpace_Param, $expectedSlogan, $expectedTags],
            '改行チェック' => [$linefeed_Param, $expectedSlogan, $expectedTags],
            'タブチェック' => [$tab_Param, $expectedSlogan, $expectedTags],
        ];
    }
}
