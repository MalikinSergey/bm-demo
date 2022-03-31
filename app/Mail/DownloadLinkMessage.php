<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class DownloadLinkMessage extends Mailable
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
    public function __construct($item)
    {
        $this->item = $item;
    }

    public function build()
    {
        return $this
            ->subject($this->item->name . " Download Link")
            ->view('mail.download-link', ['item' => $this->item]);
    }
}