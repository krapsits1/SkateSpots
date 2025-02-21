<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSkateSpotAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $skateSpot;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($skateSpot)
    {
        $this->skateSpot = $skateSpot;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Skate Spot Added')
                    ->view('emails.newSkateSpotAdded');
    }
}