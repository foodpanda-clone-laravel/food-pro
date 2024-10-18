<?php

namespace App\Jobs;

use App\Mail\AcceptedRequestMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAcceptedRequestMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $firstName;
    public $temporaryPassword;
    public $restaurantName;
    public $email;

    /**
     * Create a new job instance.
     */
    public function __construct($firstName, $temporaryPassword, $restaurantName, $email)
    {
        $this->firstName = $firstName;
        $this->temporaryPassword = $temporaryPassword;
        $this->restaurantName = $restaurantName;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->email)->send(new AcceptedRequestMail(
            $this->firstName,
            $this->temporaryPassword,
            $this->restaurantName,
            $this->email
        ));
    }
}
