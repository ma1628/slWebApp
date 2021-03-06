<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * メールを作成する
 *
 * Class CreateContactMail
 * @package App\Mail
 */
class CreateContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var String お問い合わせ本文
     */
    private $inquiry;

    /**
     * Create a new message instance.
     *
     * CreateContactMail constructor.
     * @param String $inquiry お問い合わせ本文
     */
    public function __construct(String $inquiry)
    {
        $this->inquiry=$inquiry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('contact.contactMailTemplate')
            ->with([
                'inquiry' => $this->inquiry
            ]);
    }
}
