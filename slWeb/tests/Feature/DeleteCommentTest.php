<?php

namespace Tests\Feature;

use App\Slogan;
use App\User;
use Tests\SlWebTestCase;

class DeleteCommentTest extends SlWebTestCase
{
    /**
     * @test
     */
    public function ログインしてdeleteCommentにidをPOSTすると、commentを削除後、リダイレクトする()
    {
        $slogan = Slogan::first();
        $sloganId = $slogan->id;
        $comment = $slogan->comments->first();
        $deletedRating = $comment->rating;
        $params = [
            'comment_id' => $comment->id,
        ];
        $resultParams = [
            'id' => $comment->id,
        ];

        // 更新後になるはずの評価
        $ratingSum = $slogan->comments->sum('rating') - $deletedRating;
        $ratingCount = $slogan->comments->count() - 1;
        $updatedRating = bcdiv($ratingSum, $ratingCount, 1);

        $response = $this->actingAs(User::first())->post(route('deleteComment', $params));
        // キャッチコピーの評価レートが更新されているか確認
        $this->assertSame($updatedRating, Slogan::find($sloganId)->rating);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('comments', $resultParams);
        $this->assertEquals('コメントを1件削除しました。', session('message'));
    }

    /**
     * @test
     */
    public function ログインしてdeleteCommentに存在しないidをPOSTすると、ステータスコード404を返す()
    {
        $params = [
            'comment_id' => 0,
        ];

        $response = $this->actingAs(User::first())->post(route('deleteComment', $params));
        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function ログインせずにdeleteCommentにidをPOSTすると、リダイレクトする()
    {
        $slogan = Slogan::first();
        $comment = $slogan->comments->first();
        $params = [
            'comment_id' => $comment->id,
        ];
        $resultParams = [
            'id' => $comment->id,
        ];

        $response = $this->post(route('deleteComment', $params));
        $response->assertStatus(302);
        $this->assertDatabaseHas('comments', $resultParams);
        $this->assertEquals('ログインしてください。', session('message'));
    }
}
