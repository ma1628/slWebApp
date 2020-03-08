<?php

namespace Tests\Feature;

use App\Tag;
use Tests\SlWebTestCase;

class SloganListByTagSearchTest extends SlWebTestCase
{
    /**
     * @test
     */
    public function sloganListByTagSearchにtag_idが含まれる場合、検索結果が表示されている()
    {
        $tag = Tag::first();
        $tagId = $tag->id;
        $params = [
            'tag_id' => $tagId
        ];

        $response = $this->get(route('sloganListByTagSearch', $params));
        $response->assertStatus(200);

        $data = $tag->slogans()
                ->paginate(config('const.PER_PAGE'));

        $response->assertViewIs('slogan.sloganListByTagSearch');
        $response->assertViewHas('slogans', $data);
    }

    /**
     * @test
     * @dataProvider stringTagIdDataProvider
     */
    public function sloganListByTagSearchに数字意外のtag_idが指定された場合、ステータスコード500を返す($string_tag_id)
    {
        $params = [
            'tag_id' => $string_tag_id
        ];

        $response = $this->get(route('sloganListByTagSearch', $params));
        $response->assertStatus(404);
    }

    public function stringTagIdDataProvider()
    {
        return [
            '文字' => ['a'],
        ];
    }

    /**
     * @test
     * @dataProvider nonExistentTagIdDataProvider
     */
    public function sloganListByTagSearchに存在しないtag_idが指定された場合、ステータスコード404を返す($nonExistent_tag_id)
    {
        $params = [
            'tag_id' => $nonExistent_tag_id
        ];

        $response = $this->get(route('sloganListByTagSearch', $params));
        $response->assertStatus(404);
    }

    public function nonExistentTagIdDataProvider()
    {
        return [
            'idに存在しない数字' => ['0'],
        ];
    }
}
