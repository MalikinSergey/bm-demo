<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class UserEmailVerification extends Mailable
{

    /**
     * @type User
     */
    protected $user;

    /**
     * @type string
     */
    protected $hash;

    /**
     * UserEmailVerification constructor.
     * @param User $user
     * @param string $hash
     */
    public function __construct(User $user, string $hash)
    {
        $this->user = $user;
        $this->hash = $hash;
    }

    public function build()
    {
        return $this->subject('Verify Your Email Address')
            ->view('mail.user-email-verification', ['hash' => $this->hash]);
    }
}