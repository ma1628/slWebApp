<?php


namespace App\Services;


use App\Tag;

class TagService
{
    /**
     * 全てのタグを取得する
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllTags()
    {
        return Tag::withCount('slogans')
            ->orderBy('slogans_count', 'desc')
            ->get();
    }

    /**
     * タグを検索して返す
     *
     * @param String $query
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function searchTags(String $query)
    {
        return Tag::where('tag_name', 'LIKE', "%{$query}%")->get();
    }
}
