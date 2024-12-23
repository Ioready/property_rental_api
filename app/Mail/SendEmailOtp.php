<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $dArr;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dArr)
    {
        $this->dArr = $dArr;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        return $this->view('email.otp')->with('dArr', $this->dArr)->subject($this->subject);

    }
}
