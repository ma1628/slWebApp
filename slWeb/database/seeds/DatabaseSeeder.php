<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // データのクリア
        \App\Comment::truncate();
        \App\Slogan::truncate();
        \App\Tag::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Eloquent::reguard();
        // シーダー実行
        $this->call(TestDataSeeder::class);
    }
}
