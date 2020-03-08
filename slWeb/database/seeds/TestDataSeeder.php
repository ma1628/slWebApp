<?php

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Slogan::class, 25)
            ->create()
            ->each(function ($slogan) {

                factory(\App\Comment::class, 3)
                    ->make()
                    ->each(function ($comment) use ($slogan) {
                        $slogan->comments()->save($comment);
                    });
            });


        $slogans = App\Slogan::all();

        factory(\App\Tag::class, 5)
            ->create()
            ->each(function ($tag) use ($slogans) {
                $tag->slogans()->attach(
                    $slogans->random(rand(1,3))->pluck('id')->toArray() // 1～3個のtagをsloganにランダムに紐づけ
                );
            });

        factory(\App\User::class, 3)
            ->create();
    }
}
