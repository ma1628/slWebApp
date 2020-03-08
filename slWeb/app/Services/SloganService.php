<?php


namespace App\Services;


use App\Slogan;
use App\Tag;
use DB;

class SloganService
{
    /**
     * 全てのキャッチコピーを指定されたソート順で取得
     * 指定されなかった場合は評価順
     *
     * @param String $order
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllSlogans($order = null)
    {
        if ($order == null) {
            $order = "rating";
        }

        return Slogan::withCount('comments')
            ->with('tags')
            ->orderByDesc($order)
            ->paginate(config('const.PER_PAGE'));
    }

    /**
     * 主キーを元にキャッチコピーを返す
     *
     * @param int $slogan_id
     * @return Slogan|Slogan[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getSlogan(int $slogan_id)
    {
        return Slogan::findOrFail($slogan_id);
    }

    /**
     * 検索方法とキーワードを元にキャッチコピーを検索して返す
     *
     * @param String $searchMethod
     * @param String $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchSlogans(String $searchMethod, String $keyword)
    {
        return Slogan::withCount('comments')
            ->with('tags')
            ->where($searchMethod, 'like', '%' . $keyword . '%')
            ->orderByDesc('rating')
            ->paginate(config('const.PER_PAGE'));
    }

    /**
     * tag_idを元に、タグとそれに紐づくキャッチコピーを返す
     *
     * @param int $tag_id
     * @return array
     */
    public function searchSlogansByTag(int $tag_id)
    {
        $tag = Tag::findOrFail($tag_id);
        $slogans = $tag->slogans()
            ->paginate(config('const.PER_PAGE'));
        return array($tag, $slogans);
    }

    /**
     * キャッチコピーとタグを登録する
     *
     * @param array $input フォームからの入力値
     * @throws \Throwable
     */
    public function insertSlogan(array $input): void
    {
        DB::transaction(function () use ($input) {
            $slogan = new Slogan();
            $slogan->fill($input)->save();
            if (isset($input['tagNames'])) {
                $tagNames = $input['tagNames'];
                $tagIds = array();
                foreach ($tagNames as $tagName) {
                    $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
                $slogan->tags()->attach($tagIds);
            }
        });
    }

    /**
     * キャッチコピーとタグを更新する
     *
     * @param array $input フォームからの入力値
     * @throws \Throwable
     */
    public function updateSlogan(array $input): void
    {
        DB::transaction(function () use ($input) {
            $slogan = Slogan::find($input['slogan_id']);
            $slogan->fill($input)->save();
            if (isset($input['tagNames'])) {
                $tagNames = $input['tagNames'];
                $tagIds = array();
                foreach ($tagNames as $tagName) {
                    $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                    $tagIds[] = $tag->id;
                    $slogan->tags()->sync($tagIds);
                }
            } else {
                $slogan->tags()->detach();
            }
        });
    }
}
