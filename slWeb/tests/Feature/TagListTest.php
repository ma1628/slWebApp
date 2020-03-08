<?php

namespace Tests\Feature;

use App\Tag;
use Tests\SlWebTestCase;

class TagListTest extends SlWebTestCase
{
    /**
     * @test
     */
    public function tagListにアクセスした場合、タグ一覧が表示されている()
    {
        $response = $this->get(route('tagList'));
        $data = Tag::withCount('slogans')
            ->orderBy('slogans_count', 'desc')
            ->get();
        $response->assertViewIs('tag.tagList');
        $response->assertViewHas('tags', $data);
    }
}
