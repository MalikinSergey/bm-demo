<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class ContactFormMessage extends Mailable
{

    /**
     * @type array
     */
    protected $data;

    /**
     * UserEmailVerification constructor.
     * @param User $user
     * @param string $hash
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->view('mail.contact-form-message', ['data' => $this->data]);
    }
}