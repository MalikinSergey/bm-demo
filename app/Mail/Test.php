<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class Test extends Mailable
{
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->view('mail.test');
    }
}