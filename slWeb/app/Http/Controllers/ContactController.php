<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailPost;
use App\Mail\SendContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * お問い合わせページに繊維する
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inputContact()
    {
        return view('contact.inputContact');
    }


    public function sendContact(SendMailPost $sendMailPost)
    {

        Mail::to(config('mail.from')["address"])->queue(new SendContactMail($sendMailPost->input('inquiry')));

        return redirect('/')->with('message', 'メッセージを送信しました。ご協力ありがとうございました。');
    }
}
