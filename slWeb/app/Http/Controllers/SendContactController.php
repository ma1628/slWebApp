<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryPost;
use App\Mail\CreateContactMail;
use Illuminate\Support\Facades\Mail;

/**
 * お問い合わせを送信する
 *
 * Class SendContactController
 * @package App\Http\Controllers
 */
class SendContactController extends Controller
{
    public function __invoke(InquiryPost $sendMailPost)
    {
        // 自身のメールアドレスに送信
        Mail::to(config('mail.from')["address"])
            ->queue(new CreateContactMail($sendMailPost->input('inquiry')));

        return redirect(route('home'))
            ->with('message', 'お問い合わせ内容を送信しました。ご協力ありがとうございました。');
    }
}
