<?php

namespace App\Services;

use App\Comment;
use App\Slogan;
use DB;

class CommentService
{
    /**
     * コメントを1件追加する
     *
     * @param array $input フォームからの入力値
     * @throws \Throwable
     */
    public function insertComment(array $input): void
    {
        DB::transaction(function () use ($input) {
            $sloganId = $input['slogan_id'];
            $slogan = Slogan::findOrFail($sloganId);
            $comment = new Comment();
            $comment->fill($input);
            $slogan->comments()->save($comment);
            $this->updateSloganRating($sloganId);
        });
    }

    /**
     * コメントを1件削除する
     *
     * @param int $comment_id
     * @throws \Throwable
     */
    public function deleteComment(int $comment_id): void
    {
        DB::transaction(function () use ($comment_id) {
            $comment = Comment::findOrFail($comment_id);
            $slogan_id = $comment->slogan->id;
            $comment->delete();
            $this->updateSloganRating($slogan_id);
        });
    }

    /**
     * キャッチコピーの評価を修正する
     *
     * @param $slogan_id
     */
    private function updateSloganRating($slogan_id): void
    {
        $slogan = Slogan::findOrFail($slogan_id);
        $sumRating = $slogan
            ->comments
            ->sum('rating');
        $countRating = $slogan
            ->comments
            ->count();
        $slogan->rating = bcdiv($sumRating, $countRating, 1);
        $slogan->update();
    }
}
