<?php

namespace Tests\Feature;

use App\Slogan;
use Tests\SlWebTestCase;

class SloganDetailTest extends SlWebTestCase
{
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
    public function sloganDetailにslogan_idの値が含まれなかった場合、ステータスコードを返す()
    {
        $params = [
            'slogan_id' => 0,
        ];
        $response = $this->get(route('sloganDetail', $params));
        $response->assertStatus(404);
    }
}
