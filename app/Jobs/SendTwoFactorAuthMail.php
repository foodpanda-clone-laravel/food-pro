<?php

namespace App\Jobs;

use App\Mail\TwoFactorAuthMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTwoFactorAuthMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $secretKey;
    public $inlineUrl;

    public $email;

    /**
     * Create a new job instance.
     *
     * @param string $secretKey
     * @param string $inlineUrl
     */
    public function __construct($secretKey, $inlineUrl, $email)
    {
        $this->secretKey = $secretKey;
        $this->inlineUrl = $inlineUrl;
        $this->email=$email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(
            new TwoFactorAuthMail($this->secretKey, $this->inlineUrl)
        );
    }
}
