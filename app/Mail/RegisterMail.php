<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $register;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($register)
    {
        $this->register = $register;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('comocomo@mail.com')
            ->view('emails.register')
            ->with(
            [
                'token' => $this->register->token
            ]);
            /*->attach(public_path('/images').'/demo.jpg', [
                    'as' => 'demo.jpg',
                    'mime' => 'image/jpeg',
            ]);*/
    }
}
