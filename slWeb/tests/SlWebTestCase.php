<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class SlWebTestCase extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'TestDataSeeder']);
    }
}
