<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class TwoFactorAuthMail extends Mailable
{
    use Queueable, SerializesModels;
    public $secretKey;
    public $inlineUrl;
    public function __construct($secretKey, $inlineUrl)
    {
        $this->secretKey = $secretKey;
        $this->inlineUrl = $inlineUrl;
    }
    public function build()
    {
        return $this->subject('Your 2FA Setup')
                    ->view('two_factor_auth')
                    ->with([
                        'secretKey' => $this->secretKey,
                        'inlineUrl' => $this->inlineUrl,
                    ]);
    }
}