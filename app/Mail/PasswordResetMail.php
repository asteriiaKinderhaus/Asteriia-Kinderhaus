<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $resetUrl;
    public int $expiresIn;

    public function __construct(
        string $name,
        string $resetUrl,
        int $expiresIn = 60
    ) {
        $this->name = $name;
        $this->resetUrl = $resetUrl;
        $this->expiresIn = $expiresIn;
    }

    public function build()
    {
        return $this
            ->subject('Reset Password - Asteriia Kinderhaus')
            ->view('emails.password-reset');
    }
}