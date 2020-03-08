<?php

namespace Tests\Feature;

use App\Mail\CreateContactMail;
use Illuminate\Support\Facades\Mail;
use Tests\SlWebTestCase;

class SendContactTest extends SlWebTestCase
{
    /**
     * @test
     */
    public function sendContactにpostした場合、メールを送信してリダイレクトする()
    {
        Mail::fake();

        $email = config('mail.from')['address'];

        // 任意の実際のリクエスト処理
        $params = [
            'inquiry' => str_repeat('あ', 1000),
        ];
        $response = $this->post(route('sendContact', $params));

        // 1回送信されたことをアサート
        Mail::assertQueued(CreateContactMail::class, 1);

        // メールが指定したユーザーに送信されていることをアサート
        Mail::assertQueued(
            CreateContactMail::class,
            function ($mail) use ($email) {
                return $mail->to[0]['address'] === $email;
            }
        );

        $response->assertRedirect(route('home'));
        $this->assertEquals('お問い合わせ内容を送信しました。ご協力ありがとうございました。', session('message'));

    }
}
