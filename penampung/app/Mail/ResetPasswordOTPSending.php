<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ResetPasswordOTPSending extends Mailable
{
    use Queueable, SerializesModels;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function envelope()
    {
        return new Envelope(
            from: new Address('jade@agrobizportal.com', 'Jamkrindo'),
            subject: 'OTP Reset Password',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.auth.reset_password',
            with: [
                'otp' => $this->otp
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
