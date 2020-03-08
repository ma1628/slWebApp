<?php

namespace Tests\Feature;

use Tests\SlWebTestCase;

class InputSloganTest extends SlWebTestCase
{
    /**
     * @test
     */
    public function inputSloganにアクセスするとキャッチコピー追加ページを開く()
    {
        $response = $this->get(route('inputSlogan'));
        $response->assertStatus(200);
        $response->assertViewIs('slogan.inputSlogan');
    }
}
