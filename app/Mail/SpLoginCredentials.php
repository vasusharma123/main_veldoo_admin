<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SpLoginCredentials extends Mailable
{
    use Queueable, SerializesModels;
    public $userDetail;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userDetail, $password)
    {
        $this->userDetail = $userDetail;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Login Credentials")->view('email.spLoginCredential');
    }
}
