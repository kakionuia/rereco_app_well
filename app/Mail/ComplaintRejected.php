<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $complaint;

    /**
     * Create a new message instance.
     */
    public function __construct($complaint)
    {
        $this->complaint = $complaint;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Keluhan Anda Ditolak')
                    ->view('emails.complaint_rejected')
                    ->with(['complaint' => $this->complaint]);
    }
}
