<?php

namespace Tests\Feature;

use App\Slogan;
use Tests\SlWebTestCase;

class SloganListTest extends SlWebTestCase
{
    /**
     * @param $keyword
     * @param $searchMethod
     * @test
     * @dataProvider searchSloganDataProvider
     */
    public function sloganListにkeywordとsearchMethodが含まれる場合、検索結果が表示されている($searchMethod)
    {
        $slogan = Slogan::first();
        $keyword = "";
        if ($searchMethod == 'phrase') {
            $keyword = $slogan->phrase;
        } else if ($searchMethod == 'writer') {
            $keyword = $slogan->writer;
        } else if ($searchMethod == 'source') {
            $keyword = $slogan->source;
        }

        $params = [
            'keyword' => $keyword,
            'searchMethod' => $searchMethod,
        ];

        $response = $this->get(route('sloganList', $params));
        $response->assertStatus(200);

        $data = Slogan::withCount('comments')
            ->with('tags')
            ->where($searchMethod, 'like', '%' . $keyword . '%')
            ->orderByDesc('rating')
            ->paginate(config('const.PER_PAGE'));

        // リンク用に検索条件を設定
        $data->appends($params);

        $response->assertViewIs('slogan.sloganList');
        $response->assertViewHas('slogans', $data);
        $response->assertViewHas('params', $params);
    }

    public function searchSloganDataProvider()
    {
        return [
            'キャッチコピー検索' => ['phrase'],
            'ライター検索' => ['writer'],
            '出典検索' => ['source'],
        ];
    }

    /**
     * @param $keyword
     * @param $searchMethod
     * @test
     * @dataProvider searchNoSloganDataProvider
     */
    public function sloganListにkeywordとsearchMethodが含まれて、検索結果が0件の場合($keyword, $searchMethod)
    {
        $params = [
            'keyword' => $keyword,
            'searchMethod' => $searchMethod,
        ];
        $response = $this->get(route('sloganList', $params));
        $response->assertStatus(200);
        $response->assertViewIs('slogan.sloganList');
        $response->assertSeeText('該当するキャッチコピーが存在しません。');
    }

    public function searchNoSloganDataProvider()
    {
        return [
            'キャッチコピー検索0件' => ['テスト', 'phrase'],
            'ライター検索0件' => ['テスト', 'writer'],
            '出典検索0件' => ['テスト', 'source'],
        ];
    }

    /**
     * @param $keyword
     * @param $searchMethod
     * @test
     * @dataProvider searchSloganIncorrectDataProvider
     */
    public function sloganListにパラメータを誤って指定した場合($keyword, $searchMethod)
    {
        $params = [
            'keyword' => $keyword,
            'searchMethod' => $searchMethod,
        ];
        $response = $this->get(route('sloganList', $params));
        $response->assertStatus(302);
    }

    public function searchSloganIncorrectDataProvider()
    {
        return [
            'キャッチコピー検索誤り' => ['キャッチコピー', 'phras'],
            'ライター検索誤り' => ['ライター', 'writera'],
            '出典検索誤り' => ['出典', 'sourcea'],
        ];
    }
}
