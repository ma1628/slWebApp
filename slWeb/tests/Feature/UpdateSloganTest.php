<?php

namespace Tests\Feature;

use App\Slogan;
use Tests\SlWebTestCase;

class UpdateSloganTest extends SlWebTestCase
{
    /**
     * @test
     * @dataProvider updateSloganDataProvider
     */
    public function updateSloganにキャッチコピーをPOSTすると、データベースに反映されて、リダイレクトする($param, $expectedSlogan, $expectedTags = null)
    {
        $sloganId = Slogan::first()->id;
        $redirectParam = [
            'slogan_id' => $sloganId
        ];
        $param = array_merge($param, array('slogan_id' => $sloganId));
        $response = $this->call('POST', route('updateSlogan'), $param);
        $response->assertRedirect(route('sloganDetail', $redirectParam));
        $this->assertDatabaseHas('slogans', $expectedSlogan);

        if ($expectedTags == null) {
            $this->assertEquals(true, Slogan::find($sloganId)
                ->first()
                ->tags
                ->isEmpty());
        } else {
            $this->assertDatabaseHas('tags', $expectedTags);
            // キャッチコピーとタグにリレーションが設定されているか確認
            $array_tagNames = Slogan::find($sloganId)
                ->first()
                ->tags
                ->map(function ($item, $key) {
                    return $item->tag_name;
                })
                ->toArray();
            $this->assertEquals($expectedTags['tag_name'], array_values($array_tagNames));
        }
    }

    public function updateSloganDataProvider()
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

        return [
            '正常系（全て入力）' => [$param, $expectedSlogan, $expectedTags],
            '正常系（未入力あり）' => [$param2, $expectedSlogan2],
        ];
    }
}
