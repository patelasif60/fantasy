<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPlayer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Players that has been new added.
     *
     * @var User
     */
    public $players;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($players)
    {
        $this->players = $players;
        // echo "<pre>"; print_r($this->players); exit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Player Added')->markdown('emails.admin.players.new');
    }
}
