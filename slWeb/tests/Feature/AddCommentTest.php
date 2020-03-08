<?php

namespace Tests\Feature;

use App\Slogan;
use Tests\SlWebTestCase;

class AddCommentTest extends SlWebTestCase
{
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
            'contributor_name' => str_repeat('あ', 30),
            'text' => str_repeat('あ', 300),
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
        $this->assertEquals('コメントを投稿しました。', session('message'));
    }
}
