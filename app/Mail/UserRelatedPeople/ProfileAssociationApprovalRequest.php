<?php

namespace App\Mail\UserRelatedPeople;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfileAssociationApprovalRequest extends Mailable
{
    use Queueable, SerializesModels;

    // public $token;
    public $companion_id;
    public $requested;
    public $requester;
    public $relation_type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $companion_id, $requested, $requester, $relation_type)
    {
        // $this->token=$token;
        $this->companion_id=$companion_id;
        $this->requested=$requested;
        $this->requester=$requester;
        $this->relation_type=$relation_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hotel@inverdata.com')
        ->subject($this->requester->name . ' ' . $this->requester->lastname . ' te agrego a su perfil para reservas de hotel.')
        ->view('mailables.UserRelatedPeople.ProfileAssociationApprovalRequestTemplate');
    }
}
