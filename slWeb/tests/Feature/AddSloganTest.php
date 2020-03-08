<?php

namespace Tests\Feature;

use App\Slogan;
use Tests\SlWebTestCase;

class AddSloganTest extends SlWebTestCase
{
    // バリデーションエラーはSloganDetailPostTest.phpでテスト

    /**
     * @test
     * @dataProvider addSloganDataProvider
     */
    public function addSloganにキャッチコピーをPOSTするとinsertされ、リダイレクトする（未入力なし）($param, $expectedSlogan, $expectedTags)
    {
        $response = $this->call('POST', route('addSlogan'), $param);
        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('slogans', $expectedSlogan);
        $this->assertDatabaseHas('tags', $expectedTags);

        // キャッチコピーとタグにリレーションが設定されているか確認
        $array_tagNames = Slogan::wherePhrase($expectedSlogan['phrase'])
            ->first()
            ->tags
            ->map(function ($item, $key) {
                return $item->tag_name;
            })
            ->toArray();
        $this->assertEquals($expectedTags['tag_name'], array_values($array_tagNames));
    }

    public function addSloganDataProvider()
    {
        $param = [
            'phrase' => str_repeat('あ', 50),
            'writer' => str_repeat('あ', 15),
            'source' => str_repeat('あ', 50),
            'supplement' => str_repeat('あ', 1000),
            'tagNames' => [
                str_repeat('あ', 15), str_repeat('い', 15)
            ]
        ];

        $expectedSlogan = [
            'phrase' => str_repeat('あ', 50),
            'writer' => str_repeat('あ', 15),
            'source' => str_repeat('あ', 50),
            'supplement' => str_repeat('あ', 1000)
        ];

        $expectedTags = [
            'tag_name' => [
                str_repeat('あ', 15), str_repeat('い', 15)
            ]
        ];
        return [
            '正常系（全て入力）' => [$param, $expectedSlogan, $expectedTags],
        ];
    }

    /**
     * @test
     * @dataProvider addSloganDataProvider2
     * @param $param
     * @param $expectedSlogan
     * @param $expectedTags
     */
    public function addSloganにキャッチコピーをPOSTするとinsertされ、リダイレクトする（未入力あり）($param, $expectedSlogan, $expectedTags)
    {
        $response = $this->call('POST', route('addSlogan'), $param);
        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('slogans', $expectedSlogan);
        $this->assertDatabaseMissing('tags', $expectedTags);
    }

    public function addSloganDataProvider2()
    {
        $param2 = [
            'phrase' => str_repeat('あ', 50),
            'writer' => '',
            'source' => str_repeat('あ', 50),
            'supplement' => '',
            'tagNames' => ''
        ];

        $expectedSlogan2 = [
            'phrase' => str_repeat('あ', 50),
            'writer' => null,
            'source' => str_repeat('あ', 50),
            'supplement' => null
        ];

        $expectedTags2 = [
            'tag_name' => [
                '', null
            ]
        ];

        $param3 = [
            'phrase' => str_repeat('あ', 50),
            'writer' => '',
            'source' => str_repeat('あ', 50),
            'supplement' => '',
        ];

        $expectedSlogan3 = [
            'phrase' => str_repeat('あ', 50),
            'writer' => null,
            'source' => str_repeat('あ', 50),
            'supplement' => null
        ];

        $expectedTags3 = [
            'tag_name' => [
                '', null
            ]
        ];

        return [
            '正常系（未入力あり）' => [$param2, $expectedSlogan2, $expectedTags2],
            '正常系（未入力あり、tagNamesなし）' => [$param3, $expectedSlogan3, $expectedTags3],
        ];
    }
}
