<?php

namespace App\Jobs;

use App\Mail\RejectRequestMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRejectedMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $name;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $mail = new RejectRequestMail($this->name);
        Mail::to($this->email)->send($mail);
    }
}
