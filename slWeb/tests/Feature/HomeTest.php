<?php

namespace Tests\Feature;

use App\Slogan;
use Tests\SlWebTestCase;

class HomeTest extends SlWebTestCase
{
    /**
     * @test
     */
    public function トップページに評価準でキャッチコピーが表示されている＿パラメータなし()
    {
        $response = $this->get(route('home'));
        $data = Slogan::withCount('comments')
            ->with('tags')
            ->orderByDesc('rating')
            ->paginate(config('const.PER_PAGE'));

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
        $data = Slogan::withCount('comments')
            ->with('tags')
            ->orderByDesc($order)
            ->paginate(config('const.PER_PAGE'));
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
}
