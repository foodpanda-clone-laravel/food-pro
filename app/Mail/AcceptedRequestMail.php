<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptedRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $temporaryPassword;
    public $restaurantName;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($firstName, $temporaryPassword, $restaurantName, $email)
    {
        $this->firstName = $firstName;
        $this->temporaryPassword = $temporaryPassword;
        $this->restaurantName = $restaurantName;
        $this->email= $email;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to ' . $this->restaurantName)
                    ->view('restaurantrequest')
                    ->with([
                        'firstName' => $this->firstName,
                        'temporaryPassword' => $this->temporaryPassword,
                        'restaurantName' => $this->restaurantName,
                        'email' => $this->email
                    ]);
    }
}
