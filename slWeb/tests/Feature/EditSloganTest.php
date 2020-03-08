<?php

namespace Tests\Feature;

use App\Slogan;
use Tests\SlWebTestCase;

class EditSloganTest extends SlWebTestCase
{
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
    public function editSloganにslogan_idの値が含まれない場合、ステータスコード404を返す()
    {
        $params = [
            'slogan_id' => 0,
        ];
        $response = $this->get(route('editSlogan', $params));
        $response->assertStatus(404);
    }
}
