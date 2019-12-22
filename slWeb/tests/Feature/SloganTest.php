<?php

namespace Tests\Feature;

use App\Slogan;
use App\Tag;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SloganTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'TestDataSeeder']);
    }

    /**
     * @test
     */
    public function トップページにキャッチコピーが表示されている()
    {
        $response = $this->get(route('home'));
        $data = Slogan::withCount('comments')->orderByDesc('rating')->get();
        $data = $data->each(function ($item, $key) {
            $item->tags;
        });
        $response->assertViewIs('home');
        $response->assertViewHas('slogans', $data);
    }

    /**
     * @param $order
     * @test
     * @dataProvider orderDataProvider
     */
    public function トップページにソート順を指定してアクセスした場合、キャッチコピーが表示されている($order)
    {
        $params = [
            'order' => $order,
        ];
        $response = $this->get(route('home', $params));
        $data = Slogan::withCount('comments')->orderByDesc($order)->get();
        $data = $data->each(function ($item, $key) {
            $item->tags;
        });
        $response->assertViewIs('home');
        $response->assertViewHas('slogans', $data);
    }

    public function orderDataProvider()
    {
        return [
            '新着' => ['updated_at'],
            '高評価準' => ['rating'],
        ];
    }

    /**
     * @param $order
     * @test
     * @dataProvider orderIncorrectDataProvider
     * @test
     */
    public function トップページにソート順を誤って指定した場合($order)
    {
        $params = [
            'order' => $order,
        ];
        $response = $this->get(route('home', $params));
        $response->assertStatus(404);
    }

    public function orderIncorrectDataProvider()
    {
        return [
            '新着順誤り' => ['updatedat'],
            '高評価順誤り' => ['ratin'],
        ];
    }

    /**
     * @test
     */
    public function tagListにアクセスした場合、タグ一覧が表示されている()
    {
        $response = $this->get(route('tagList'));
        $data = Tag::withCount('slogans')->orderBy('slogans_count', 'desc')->get();
        $response->assertViewIs('tag.tagList');
        $response->assertViewHas('tags', $data);
    }

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

        $data = $tag->slogans()->get();

        $response->assertViewIs('slogan.sloganList');
        $response->assertViewHas('slogans', $data);
    }

    /**
     * @param $keyword
     * @param $searchMethod
     * @test
     * @dataProvider searchSloganDataProvider
     */
    public function sloganListにkeywordとsearchMethodが含まれる場合、検索結果が表示されている($keyword, $searchMethod)
    {
        $params = [
            'keyword' => $keyword,
            'searchMethod' => $searchMethod,
        ];
        $response = $this->get(route('sloganList', $params));
        $response->assertStatus(200);

        $data = Slogan::withCount('comments')
            ->where($searchMethod, 'like', '%' . $keyword . '%')
            ->orderByDesc('rating')
            ->get();

        $data = $data->each(function ($item, $key) {
            $item->tags;
        });

        $response->assertViewIs('slogan.sloganList');
        $response->assertViewHas('slogans', $data);
    }

    public function searchSloganDataProvider()
    {
        return [
            'キャッチコピー検索' => ['あ', 'phrase'],
            'ライター検索' => ['あ', 'writer'],
            '出典検索' => ['あ', 'source'],
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
        $response->assertSeeText('該当するキャッチコピーがありません');
    }

    public function searchNoSloganDataProvider()
    {
        return [
            'キャッチコピー検索0件' => ['１１１１１１', 'phrase'],
            'ライター検索0件' => ['1１１１１１１１１', 'writer'],
            '出典検索0件' => ['*＊＊＊＊＊', 'source'],
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
        $response->assertStatus(404);
    }

    public function searchSloganIncorrectDataProvider()
    {
        return [
            'キャッチコピー検索誤り' => ['キャッチコピー', 'phras'],
            'ライター検索誤り' => ['ライター', 'write'],
            '出典検索誤り' => ['出典', 'sourcea'],
            'キャッチコピー検索キーワード無' => ['', 'phrase'],
            'ライター検索キーワード無' => [' ', 'writer'],
            '出典検索キーワード無' => ['　', 'source'],
        ];
    }

    /**
     * @test
     */
    public function inputSloganにアクセスするとキャッチコピー追加ページを開く()
    {
        $response = $this->get(route('inputSlogan'));
        $response->assertStatus(200);
        $response->assertViewIs('slogan.inputSlogan');
    }

    /**
     * @test
     */
    public function addSloganにキャッチコピーをPOSTするとslogansテーブルにそのデータが追加され、リダイレクトする()
    {
        $params = [
            'phrase' => '追加',
            'writer' => 'ライター追加',
            'source' => '出典追加',
            'supplement' => '補足追加',
            'tagNames' => '#aaaaaaaaaabbbbbbbbbbcccccc30文字#1111111111222222222233333330文字',
        ];

        $sloganParams = [
            'phrase' => '追加',
            'writer' => 'ライター追加',
            'source' => '出典追加',
            'supplement' => '補足追加',
        ];

        $tagParams1 = [
            'tag_name' => 'aaaaaaaaaabbbbbbbbbbcccccc30文字',
        ];
        $tagParams2 = [
            'tag_name' => '1111111111222222222233333330文字',
        ];

        $response = $this->call('POST', route('addSlogan'), $params);
        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('slogans', $sloganParams);
        $this->assertDatabaseHas('tags', $tagParams1);
        $this->assertDatabaseHas('tags', $tagParams2);
    }

    /**
     * @test
     */
    public function sloganDetailにslogan_idの値が含まれる場合、該当するキャッチコピーを表示する()
    {
        $slogan = Slogan::first();
        $sloganId = $slogan->id;
        $params = [
            'slogan_id' => $sloganId,
        ];
        $response = $this->get(route('sloganDetail', $params));
        $response->assertStatus(200);
        $response->assertViewIs('slogan.sloganDetail');
        $slogan->comments;
        $slogan->tags;
        $response->assertViewHas('slogan', $slogan);
    }

    /**
     * @test
     */
    public function editSloganにslogan_idの値が含まれる場合、該当するキャッチコピーを表示する()
    {
        $slogan = Slogan::first();
        $sloganId = $slogan->id;
        $params = [
            'slogan_id' => $sloganId,
        ];
        $response = $this->get(route('editSlogan', $params));
        $response->assertStatus(200);
        $response->assertViewIs('slogan.editSlogan');
        $slogan->tags;
        $response->assertViewHas('slogan', $slogan);
    }

    /**
     * @test
     */
    public function updateSloganにキャッチコピーをPOSTすると、データベースに反映されて、リダイレクトする()
    {
        $sloganId = Slogan::first()->id;
        $params = [
            'id' => $sloganId,
            'phrase' => '追加',
            'writer' => 'ライター追加',
            'source' => '出典追加',
            'supplement' => '補足追加',
            'tagNames' => '#aaaaaaaaaabbbbbbbbbbcccccc30文字#1111111111222222222233333330文字',
        ];
        $redirectParam = [
            'slogan_id' => $sloganId,
        ];

        $sloganParams = [
            'phrase' => '追加',
            'writer' => 'ライター追加',
            'source' => '出典追加',
            'supplement' => '補足追加',
        ];

        $tagParams1 = [
            'tag_name' => 'aaaaaaaaaabbbbbbbbbbcccccc30文字',
        ];
        $tagParams2 = [
            'tag_name' => '1111111111222222222233333330文字',
        ];

        $response = $this->post(route('updateSlogan', $params));
        $response->assertRedirect(route('sloganDetail', $redirectParam));
        $this->assertDatabaseHas('slogans', $sloganParams);
        $this->assertDatabaseHas('tags', $tagParams1);
        $this->assertDatabaseHas('tags', $tagParams2);
    }

    /**
     * @test
     */
    public function addCommentにコメントをPOSTすると、データベースに反映されて、リダイレクトする()
    {
        $slogan = Slogan::first();
        $sloganId = $slogan->id;
        $testRating = 5;
        $params = [
            'slogan_id' => $sloganId,
            'contributor_name' => '投稿者名',
            'text' => '追加したコメントの本文',
            'rating' => $testRating
        ];

        $sumRating = $slogan->comments->sum('rating') + $testRating;
        $countRating = $slogan->comments->count() + 1;
        $updatedRating = bcdiv($sumRating, $countRating, 1);

        $redirectParam = [
            'slogan_id' => $sloganId,
        ];

        $response = $this->post(route('addComment', $params));
        // キャッチコピーの評価レートが更新されているか確認
        $this->assertSame($updatedRating, Slogan::find($sloganId)->rating);
        $response->assertRedirect(route('sloganDetail', $redirectParam));
        $this->assertDatabaseHas('comments', $params);
    }

//    /**
//     * @test
//     */
//    public function addTagにタグをPOSTすると、データベースに反映されて、リダイレクトする()
//    {
//        $sloganId = Slogan::first()->id;
//        $params = [
//            'slogan_id' => $sloganId,
//            'tag_name' => 'タグ名',
//            'tag_kana' => 'たぐめい',
//        ];
//        $response = $this->post(route('addTag', $params));
//
//        $savedData = [
//            'tag_name' => 'タグ名',
//            'tag_kana' => 'たぐめい',
//        ];
//        $this->assertDatabaseHas('tags', $savedData);
//
//        $tag = Tag::where('tag_kana', '=', 'たぐめい')->get();
//        $savedSlogan_Tag = [
//            'slogan_id' => $sloganId,
//            'tag_id' => $tag->first()->id,
//        ];
//
//        $this->assertDatabaseHas('slogan_tag', $savedSlogan_Tag);
//
//        $redirectParam = [
//            'slogan_id' => $sloganId,
//        ];
//        $response->assertRedirect(route('sloganDetail', $redirectParam));
//    }
}
