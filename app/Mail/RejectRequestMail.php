<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    /**
     * Create a new message instance.
     */
    public function __construct($first_name)
    {
        $this->name = $first_name;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Request Rejected - ' . $this->name)
                    ->view('emails.requestreject')
                    ->with('name', $this->name);
    }
}
