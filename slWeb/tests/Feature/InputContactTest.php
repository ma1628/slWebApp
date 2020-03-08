<?php

namespace Tests\Feature;

use Tests\SlWebTestCase;

class InputContactTest extends SlWebTestCase
{
    /**
     * @test
     */
    public function inputContactにアクセスした場合、お問い合わせページを表示する()
    {
        $response = $this->get(route('inputContact'));
        $response->assertStatus(200);
        $response->assertViewIs('contact.inputContact');
    }
}
