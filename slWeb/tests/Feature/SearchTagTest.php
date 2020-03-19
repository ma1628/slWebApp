<?php

namespace Tests\Feature;

use App\Tag;
use Tests\SlWebTestCase;

class SearchTagTest extends SlWebTestCase
{
    /**
     * @test
     */
    public function searchTagにqueryが含まれていた場合、検索結果を返す()
    {
        $tag_name = Tag::first()->tag_name;
        $params = [
            'query' => $tag_name,
        ];
        $response = $this->get(route('searchTag', $params));
        $response->assertStatus(200);

        $data = Tag::where('tag_name', 'LIKE', "%{$tag_name}%")->get();
        $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
        foreach ($data as $row) {
            $output .= '<li class="tag_li"><a href="#">' . $row->tag_name . '</a></li>';
        }
        $output .= '</ul>';

        $this->assertSame($output,$response->content());
    }

    /**
     * @test
     */
    public function searchTagにqueryが含まれていなかった場合、ステータスコード200を返す()
    {
        $params = [
            'query' => "",
        ];
        $response = $this->get(route('searchTag', $params));
        $response->assertStatus(200);
        $this->assertSame("",$response->content());
    }

    /**
     * @test
     */
    public function searchTagにqueryが含まれており、検索結果が存在しなかった場合、ステータスコード200を返す()
    {
        $params = [
            'query' => substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10),
        ];
        $response = $this->get(route('searchTag', $params));
        $response->assertStatus(200);
        $this->assertSame("",$response->content());
    }
}
