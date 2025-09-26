<?php
// app/Mail/KidInvitationMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class KidInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kid;

    public function __construct(User $kid)
    {
        $this->kid = $kid;
    }

    public function build()
    {
        $url = route('kid.invite.accept', ['token' => $this->kid->invite_token]);

        return $this->subject('Mini Pocket Invitation')
                    ->view('emails.kid_invite')
                    ->with([
                        'name' => $this->kid->first_name,
                        'url'  => $url,
                    ]);
    }
}
